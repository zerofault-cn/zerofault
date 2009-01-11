#coding=utf-8
import logging
import os

from google.appengine.api import users
from google.appengine.ext import webapp
from google.appengine.ext.webapp.util import run_wsgi_app
from google.appengine.ext import db
from google.appengine.ext.webapp import template

#equivalent of javascript unescape()
from urllib import unquote
import re
def unichar_fromhex(otxt):
	bigchar = otxt.group('bigchar')[2:]
	val = int(bigchar, 16)
	return unichr(val)
def unescape(txt):
	p = re.compile(r'(?P<bigchar>%u[0-9A-Za-z]{4})', re.VERBOSE)
	return unquote(p.sub(unichar_fromhex, txt))
#-----------------------------------#

class Tag(db.Model):
	name = db.StringProperty()
	num  = db.IntegerProperty()

class Link(db.Model):
	title = db.StringProperty()
	url   = db.LinkProperty()
	descr = db.TextProperty()
	addtime=db.DateTimeProperty(auto_now_add=True)
	private=db.BooleanProperty()
	tag   = db.ListProperty(db.Key)

class Index(webapp.RequestHandler):
	def get(self):
		if users.get_current_user():
			isLogin = True
			auth_url = users.create_logout_url(self.request.uri)
			auth_text= '注销'
		else:
			isLogin = False
			auth_url = users.create_login_url(self.request.uri)
			auth_text= '登录'

		link_list = []
		l_q = Link.all().order("-addtime")
		link = l_q.fetch(1000)
		
		for link_item in link:
			#logging.info("%s" % link_item.title)
			tag_list = []
			for tag_key in link_item.tag:
				tag_list.append(db.get(tag_key))
				
			link_list.append({
				'info' : link_item,
				'tag_list' : tag_list})
			
		
		template_values = {
			'isLogin'  : isLogin,
			'auth_url' : auth_url,
			'auth_text': auth_text,
			'link_list': link_list,
			'tag_list' : Tag.all()
			}
		path = os.path.join(os.path.dirname(__file__),'index.html')
		self.response.out.write(template.render(path,template_values))
	
			

class AddForm(webapp.RequestHandler):
	def get(self):
		if users.get_current_user():
			title = self.request.get('title')
			url   = self.request.get('url')
			descr = self.request.get('descr')
			
			tag_query = Tag.all();
			tag_list = tag_query.fetch(1000)

			template_values = {
				'tag_list': tag_list,
				'title'   : unescape(title),
				'url'     : unescape(url),
				'descr'   : unescape(descr)
				}
			path = os.path.join(os.path.dirname(__file__),'add.html')
			self.response.out.write(template.render(path,template_values))
		else:
			self.redirect(users.create_login_url(self.request.uri))
	

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


application = webapp.WSGIApplication([
	('/', Index),
	('/add', AddForm),
	('/submit', AddAction),
	('/tag/.*', Index)
	],debug=True)

def main():
	run_wsgi_app(application)

if __name__ == "__main__":
	main()