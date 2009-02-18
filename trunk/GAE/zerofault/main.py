#coding=utf-8
import logging
import os
import math
import datetime

from google.appengine.api import users
from google.appengine.api import urlfetch
from google.appengine.api import images
from google.appengine.ext import webapp
from google.appengine.ext import search
from google.appengine.ext.webapp import template
from google.appengine.ext.webapp.util import run_wsgi_app
from google.appengine.ext import db

from model import Entry,Tag

#-----------------------------------#
#equivalent of javascript unescape()
from urllib import unquote,quote
import re
def unichar_fromhex(otxt):
	bigchar = otxt.group('bigchar')[2:]
	val = int(bigchar, 16)
	return unichr(val)
def unescape(txt):
	p = re.compile(r'(?P<bigchar>%u[0-9A-Za-z]{4})', re.VERBOSE)
	return unquote(p.sub(unichar_fromhex, txt))
#-----------------------------------#

class Index(webapp.RequestHandler):
	def get(self,req_tag=''):
		#********************** User Auth **************************#
		isAdmin = False
		user = users.get_current_user()
		if user:
			if users.is_current_user_admin():
				isAdmin = True
			auth_url = users.create_logout_url(self.request.uri)
			auth_text= '注销'
		else:
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
		e = Entry.all().filter('type','link').order("-addtime")
		if req_tag:
			e = e.filter("tags", unquote(req_tag).decode('utf-8'))
		if not isAdmin:
			e = e.filter("private", False)
		
		#item_count = 1998#e.count() #总条数
		cur_pageid = e.get().pageid
		item_count = 0
		while cur_pageid>=0:
			entry=Entry.all().filter('type','link')
			if req_tag:
				entry = entry.filter('tags',unquote(req_tag).decode('utf-8'))
			if not isAdmin:
				entry = entry.filter('private', False)
			
			item_count += entry.filter('pageid',cur_pageid).count()
			cur_pageid -=1

		#********************** Search **************************#
		'''
		s = self.request.get('s')
		if s:
			e =[]
			query = search.SearchableQuery('Entry')
			query.Search(s)
			for result in query.Run():
				#self.response.out.write('%s' % result['email'])
				e.append(result)
				logging.info(result['title'])
		else:
		'''
		e = e.fetch(limit,offset)
			
			
		#********************** Pagenator **************************#
		page_count = int(math.ceil(item_count / float(limit))) #总页数
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
			'isAdmin'  : isAdmin,
			'user'     : user,
			'auth_url' : auth_url,
			'auth_text': auth_text,
			'entry_list': e,
			'tag_list' : Tag.all().order("usetime"),
			'is_paginated':  page_count> 1,
			'has_next': p*limit < item_count,
			'has_previous': p > 1,
			'current_page': p,
			'next_page': p + 1,
			'previous_page': p - 1,
			'pages': page_count,
			'page_numbers': page_numbers,
			'count': item_count
			}
		path = os.path.join(os.path.dirname(__file__),'templates/index.html')
		self.response.out.write(template.render(path,template_values))

class TypeIndex(webapp.RequestHandler):
	def get (self,type='pic',req_tag=''):
		#********************** User Auth **************************#
		isAdmin = False
		user = users.get_current_user()
		if user:
			if users.is_current_user_admin():
				isAdmin = True
			auth_url = users.create_logout_url(self.request.uri)
			auth_text= '注销'
		else:
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
		e = Entry.all().filter('type', type).order("-addtime")
		
		if req_tag:
			e = e.filter("tags", unquote(req_tag).decode('utf-8'))
		if not isAdmin:
			e = e.filter("private", False)
		
		item_count = e.count(1000) 
		#总条数
			
			
		#********************** Pagenator **************************#
		page_count = int(math.ceil(item_count / float(limit))) #总页数
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
			'type'     : type,
			'isAdmin'  : isAdmin,
			'user'     : user,
			'auth_url' : auth_url,
			'auth_text': auth_text,
			'entry_list': e,
			'tag_list' : Tag.all().filter('count_'+type+' >', 0),
			'is_paginated':  page_count> 1,
			'has_next': p*limit < item_count,
			'has_previous': p > 1,
			'current_page': p,
			'next_page': p + 1,
			'previous_page': p - 1,
			'pages': page_count,
			'page_numbers': page_numbers,
			'count': item_count
			}
		path = os.path.join(os.path.dirname(__file__),'templates/'+type+'.html')
		self.response.out.write(template.render(path,template_values))

class TagList(webapp.RequestHandler):
	def get(self):
		entry_count =Entry.all().count(1000)
		tags = Tag.all().order('usetime')
		tag_count = tags.count(1000)
		tag_list=[]
		for tag in tags:
			tag_list.append({"info":tag,"level":tag.count_link/(entry_count/tag_count)})
			
		
			
		path = os.path.join(os.path.dirname(__file__),'templates/tag.html')
		self.response.out.write(template.render(path,{'tags':tag_list}))
			

class AddForm(webapp.RequestHandler):
	def get(self):
		if users.is_current_user_admin():
			type= self.request.get('type')
			if not type:
				type = 'link'
			key = self.request.get('key')
			if key:
				e = db.get(key)
				title = e.title
				url   = e.url
				content = e.content
				tags  = ' '.join(tag for tag in e.tags)
				tags +=' '
				
					
			else:
				title = unescape(self.request.get('title'))
				url   = unescape(self.request.get('url'))
				content = unescape(self.request.get('content'))
				tags  = ''
			
			
			template_values = {
				'type'    : type,
				'key'     : key,
				'tag_list': Tag.all().order('usetime'),
				'title'   : title,
				'url'     : url,
				'content'   : content,
				'tags'    : tags
				}
			path = os.path.join(os.path.dirname(__file__),'templates/add.html')
			self.response.out.write(template.render(path,template_values))
		else:
			self.redirect(users.create_login_url(self.request.uri))
	

class AddAction(webapp.RequestHandler):
	def post(self):
		key  = self.request.get('key')
		if key :
			e = db.get(key)
		else:
			e = Entry()
		type = self.request.get('type')
		if not type:
			type = 'link'
		title = self.request.get('title')
		e.title = title.replace('&','&amp;').replace('<','&lt;').replace('>','&gt;')
		url = self.request.get('url')
		e.url = url.replace('&','&amp;').replace('<','&lt;').replace('>','&gt;')
		content = self.request.get('content')
		e.content = content
		#e.addtime +=datetime.timedelta(hours=+8)
		e.private = bool(int(self.request.get('private')))
		e.type = type
		if type =='pic' and not key:
			result = urlfetch.fetch(url)
			if result.status_code == 200:
				e.image = db.Blob(result.content)

		
		if key:#更新数据
			for oldtag in e.tags:
				tag = Tag.all().filter('name',oldtag)
				if(tag.count(1)>0):
					t = tag.get()
					if type == 'link':
						t.count_link -=1
					if type == 'note':
						t.count_note -=1
					if type == 'pic':
						t.count_pic -=1
					t.put()
		else:#新增数据
			max_pageCount =900 #超过此数据，则pageid递增
			entry = Entry.all().order('-addtime')
			cur_pageid = entry.get().pageid
			logging.info(cur_pageid)

			cur_pageCount = entry.filter('pageid =',cur_pageid).count(1000)
			logging.info(cur_pageCount)

			if cur_pageCount>=max_pageCount:
				e.pageid = cur_pageid+1
			else:
				e.pageid = cur_pageid
			
		e.tags = []
		tag_names = self.request.get('tags').split()
		for tag_name in tag_names:
			tag = Tag.all().filter('name',tag_name)
			if(tag.count(1)>0):
				t = tag.get()
				if type == 'link':
					t.count_link +=1
				if type == 'note':
					t.count_note +=1
				if type == 'pic':
					t.count_pic +=1

				t.usetime = datetime.datetime.now()
				t.put()
			else:
				t = Tag()
				t.name = tag_name
				if type == 'link':
					t.count_link =1
				if type == 'note':
					t.count_note =1
				if type == 'pic':
					t.count_pic =1
				t.usetime = datetime.datetime.now()
				t.put()
			e.tags.append(db.Category(tag_name))
		e.put()
		if type == 'link':
			self.redirect('/')
		else:
			self.redirect('/'+type+'/')

class DelKey(webapp.RequestHandler):
	def get(self):
		user = users.get_current_user()
		key = self.request.get('key')
		if key and users.is_current_user_admin():
			e = db.get(key)
			logging.info(e.title)
			if e and e.tags:
				for tag in e.tags:
					tag = Tag.all().filter('name',tag)
					if (tag.count(1)>0):
						t = tag.get()
						if e.type == 'link':
							t.count_link -= 1
						if e.type == 'note':
							t.count_note -= 1
						if e.type == 'pic':
							t.count_pic -= 1
						t.put()
			db.delete(e)
			self.response.out.write('1')
		else:
			self.response.out.write('0')

class Image(webapp.RequestHandler):
	def get(self):
		key = self.request.get('key')
		if key:
			e = db.get(key)
			#img = images.Image(e.image)
			#img.resize(width=400, height=300)
			#tumbimg = img.execute_transforms(output_encoding=images.JPEG)
			self.response.headers['Content-Type'] = 'image/jpeg'
			self.response.out.write(e.image)
		else:
			self.redirect('/media/logo.gif')

application = webapp.WSGIApplication([
	('/', Index),
	('/search', Index),
	('/tag/(.*)', Index),
	('/(note|pic){1}/(.*)', TypeIndex),
	('/add', AddForm),
	('/submit', AddAction),
	('/delkey', DelKey),
	('/tag', TagList),
	('/img', Image)
	],debug=True)

def main():
	run_wsgi_app(application)

if __name__ == "__main__":
	main()