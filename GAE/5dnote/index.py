#coding=utf-8
import logging
import os

from google.appengine.api import users
from google.appengine.ext import webapp
from google.appengine.ext.webapp.util import run_wsgi_app
from google.appengine.ext import db
from google.appengine.ext.webapp import template



class Tag(db.Model):
	name = db.StringProperty()
	num  = db.IntegerProperty()

class Link(db.Model):
	title = db.StringProperty()
	url   = db.LinkProperty()
	descr = db.StringProperty(multiline=True)
	addtime=db.DateTimeProperty(auto_now_add=True)
	private=db.BooleanProperty()
	tag   = db.ListProperty(db.Key)

class MainPage(webapp.RequestHandler):
	def get(self):
		if users.get_current_user():
			url = 'add'#users.create_logout_url(self.request.uri)
			url_linktext = ' 添加 '
		else:
			url = users.create_login_url(self.request.uri)
			url_linktext = 'Login'
		
		link_list = []
		l_q = Link.all().order("-addtime")
		link = l_q.fetch(1000)
		
		for link_item in link:
			logging.info("%s" % link_item.title)
			tag_list = []
			for tag_key in link_item.tag:
				tag_list.append(db.get(tag_key))
				
			link_list.append({
				'info' : link_item,
				'tag_list' : tag_list})
			
		
		template_values = {
			'link_list': link_list,
			'url': url,
			'url_linktext': url_linktext
			}
		path = os.path.join(os.path.dirname(__file__),'index.html')
		self.response.out.write(template.render(path,template_values))
	
			

class AddForm(webapp.RequestHandler):
	def get(self):

		tag_query = Tag.all();
		tag_list = tag_query.fetch(1000)

		template_values = {
			'tag_list': tag_list
			}
		path = os.path.join(os.path.dirname(__file__),'add.html')
		self.response.out.write(template.render(path,template_values))
		
	

class AddAction(webapp.RequestHandler):
	def post(self):
		t = Tag()
		l = Link()

		l.title = self.request.get('title')
		l.url = self.request.get('url')
		l.descr = self.request.get('descr')
		l.private = bool(int(self.request.get('private')))

		tags = self.request.get('tags').split()
		t_q = t.all()
		for tag_name in tags:
			t_q = t_q.filter('name =',tag_name)
			if(t_q.count(1000)>0):
				t = t_q.get()
				t.num=t.num+1
				t.put()
			else:
				t = Tag()
				t.name = tag_name
				t.num=1
				t.put()
			l.tag.append(t.key())

		l.put()
		self.redirect('/')

application = webapp.WSGIApplication(
                                     [('/', MainPage),
                                      ('/add', AddForm),
									  ('/submit', AddAction)],
                                     debug=True)

def main():
	run_wsgi_app(application)

if __name__ == "__main__":
	main()