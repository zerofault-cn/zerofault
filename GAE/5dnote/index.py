#coding=utf-8
import logging
import os

from google.appengine.api import users
from google.appengine.ext import webapp
from google.appengine.ext.webapp.util import run_wsgi_app
from google.appengine.ext import db
from google.appengine.ext.webapp import template

#-----------------------------------#
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

class Link(db.Model):
	title = db.StringProperty()
	url   = db.LinkProperty()
	descr = db.TextProperty()
	addtime=db.DateTimeProperty(auto_now_add=True)
	private=db.BooleanProperty()
	tag   = db.ListProperty(db.Key)

class Tag(db.Model):
	name = db.StringProperty()
	num  = db.IntegerProperty()

	@property
	def relLinks(self):
		return Link.gql("WHERE tag = :1 ORDER BY addtime DESC", self.key())

class Index(webapp.RequestHandler):
	def get(self,tag_name=''):
		user = users.get_current_user()
		if user and user.email()=='zerofault@gmail.com':
			isLogin = True
			auth_url = users.create_logout_url(self.request.uri)
			auth_text= '注销'
		else:
			isLogin = False
			auth_url = users.create_login_url(self.request.uri)
			auth_text= '登录'

		limit = 20;
		p = int(self.request.get('p'))
		if not p:
			p=1
		offset = p*limit
		
		link_list = []
		l_q = Link.all().order("-addtime")
		if tag_name:
			t_q = Tag.gql("WHERE name = :1",unquote(tag_name).decode('utf-8'))
			#logging.info(unquote(tag_name))
			t = t_q.get()
			l_q = l_q.filter("tag =", t.key())
		
		if not isLogin:
			l_q = l_q.filter("private =", False)
		
		l_count = l_q.count(1000)
		link = l_q.fetch(limit,offset)
		
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
			'user_nickname'     : user.nickname(),
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
			key = self.request.get('key')
			tag_names= ''
			if key:
				l = db.get(key)
				title = l.title
				url   = l.url
				descr = l.descr
				tags  =db.get(l.tag)
				for tag in tags:
					tag_names = tag_names+tag.name+' '
					
			else:
				title = unescape(self.request.get('title'))
				url   = unescape(self.request.get('url'))
				descr = unescape(self.request.get('descr'))
				tag_names  = ''
			
			tag_query = Tag.all();
			tag_list = tag_query.fetch(1000)

			template_values = {
				'key'     : key,
				'tag_list': tag_list,
				'title'   : title,
				'url'     : url,
				'descr'   : descr,
				'tags'    : tag_names
				}
			path = os.path.join(os.path.dirname(__file__),'add.html')
			self.response.out.write(template.render(path,template_values))
		else:
			self.redirect(users.create_login_url(self.request.uri))
	

class AddAction(webapp.RequestHandler):
	def post(self):
		key = self.request.get('key')
		t = Tag()
		if key :
			l = db.get(key)
		else:
			l = Link()
		l.title = self.request.get('title')
		l.url = self.request.get('url')
		l.descr = self.request.get('descr')
		l.private = bool(int(self.request.get('private')))
		l.tag = []

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
class DelAction(webapp.RequestHandler):
	def get(self):
		user = users.get_current_user()
		key = self.request.get('key')
		if key and user and user.email()=='zerofault@gmail.com':
			l = db.get(key)
			for tag_key in l.tag:
				t = db.get(tag_key)
				t.num -= 1
				t.put()
			db.delete(key)
				
		self.redirect('/')

class DelTag(webapp.RequestHandler):
	def get(self):
		key = self.request.get('key')
		if key:
			db.delete(key)
		self.redirect('/')
	
application = webapp.WSGIApplication([
	('/', Index),
	('/add', AddForm),
	('/submit', AddAction),
	('/del', DelAction),
	('/deltag',DelTag),
	('/tag/(.*)', Index)
	],debug=True)

def main():
	run_wsgi_app(application)

if __name__ == "__main__":
	main()