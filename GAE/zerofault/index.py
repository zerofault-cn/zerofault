#coding=utf-8
import logging
import os
import math
import datetime
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
	usetime  = db.DateTimeProperty(auto_now_add=True)

class Index(webapp.RequestHandler):
	def get(self,tag_name=''):
		#********************** User Auth **************************#
		user = users.get_current_user()
		if user and user.email()=='zerofault@gmail.com':
			isLogin = True
			auth_url = users.create_logout_url(self.request.uri)
			auth_text= '注销'
		else:
			isLogin = False
			auth_url = users.create_login_url(self.request.uri)
			auth_text= '登录'

		#********************** Pagenator init**************************#
		limit = 20;
		p = self.request.get('p')
		if not p:
			p=1
		else:
			p = int(p)
		offset = (p-1)*limit
		
		#********************** Query **************************#
		link = Link.all().order("-addtime")
		if tag_name:
			t_q = Tag.gql("WHERE name = :1",unquote(tag_name).decode('utf-8'))
			#logging.info(unquote(tag_name))
			t = t_q.get()
			if t:
				link = link.filter("tag =", t.key())
		
		if not isLogin:
			link = link.filter("private =", False)
		
		link_count = link.count(1000) #总条数
			
		#********************** Search **************************#
		s = self.request.get('s')
		if not s:
			link = link.fetch(limit,offset)
		link_list = []
		for link_item in link:
			if s and link_item.title.find(s)<0:
				link_count -=1
				continue
			link_list.append({
				'info' : link_item,
				'tag_list' : db.get(link_item.tag)})
			
		#t_q=Tag.all()
		#tt=t_q.fetch(100)
		#for t in tt:
		#	t.usetime=datetime.datetime.now()
		#	t.put()
			
		#********************** Pagenator **************************#
		page_count = int(math.ceil(link_count / float(limit))) #总页数
		if page_count <=7 :
			page_numbers = range(1,page_count+1)
		else:
			if p<=6:
				page_numbers = range(1,max(1,p-3))
			else:
				page_numbers = [1,2] + ['...']
			page_numbers += range(max(1,p-3),min(p+4,page_count+1))
			if p >= page_count-5:
				page_numbers += range(min(p+4,page_count+1),page_count+1)
			else:
				page_numbers += (['...']+range(page_count-1,page_count+1))
			
		template_values = {
			'isLogin'  : isLogin,
			'user'     : user,
			'auth_url' : auth_url,
			'auth_text': auth_text,
			'link_list': link_list,
			'tag_list' : Tag.all().order("usetime"),
			'is_paginated':  page_count> 1,
			'has_next': p*limit < l_count,
			'has_previous': p > 1,
			'current_page': p,
			'next_page': p + 1,
			'previous_page': p - 1,
			'pages': page_count,
			'page_numbers': page_numbers,
			'count': link_count
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
					if tag:
						tag_names = tag_names+tag.name+' '
					
			else:
				title = unescape(self.request.get('title'))
				url   = unescape(self.request.get('url'))
				descr = unescape(self.request.get('descr'))
				tag_names  = ''
			
			
			template_values = {
				'key'     : key,
				'tag_list': Tag.all().order("usetime"),
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
		if key:
			oldtags = db.get(l.tag)
			for oldtag in oldtags:
				if oldtag:
					oldtag.num -= 1
					oldtag.put()
		l.tag = []

		tags = self.request.get('tags').split()
		for tag_name in tags:
			t_q = t.all()
			t_q = t_q.filter('name =',tag_name)
			logging.info(tag_name)
			if(t_q.count(1000)>0):
				t = t_q.get()
				t.num =t.num+1
				t.usetime = datetime.datetime.now()
				t.put()
			else:
				t = Tag()
				t.name = tag_name
				t.num=1
				t.usetime = datetime.datetime.now()
				t.put()
			l.tag.append(t.key())

		l.put()
		self.redirect('/')
class DelKey(webapp.RequestHandler):
	def get(self):
		user = users.get_current_user()
		key = self.request.get('key')
		if key and user and user.email()=='zerofault@gmail.com':
			l = db.get(key)
			if l and l.tag:
				for tag_key in l.tag:
					t = db.get(tag_key)
					t.num -= 1
					t.put()
				db.delete(key)
			self.response.out.write('1')
		else:
			self.response.out.write('0')

		
application = webapp.WSGIApplication([
	('/', Index),
	('/add', AddForm),
	('/submit', AddAction),
	('/search', Index),
	('/delkey', DelKey),
	('/tag/(.*)', Index)
	],debug=True)

def main():
	run_wsgi_app(application)

if __name__ == "__main__":
	main()