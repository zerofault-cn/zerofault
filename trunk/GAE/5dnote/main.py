#coding=utf-8
import logging
import os
import math
import datetime
import Cookie

from google.appengine.api import users
from google.appengine.api import urlfetch
from google.appengine.api import images
from google.appengine.api import memcache
from google.appengine.ext import webapp
from google.appengine.ext import search
from google.appengine.ext.webapp import template
from google.appengine.ext.webapp.util import run_wsgi_app
from google.appengine.ext import db

from model import Entry,Tag,User

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

class Main(webapp.RequestHandler):
	def get(self,req_type='link',req_user='',req_tag=''):

		user_lang = 'en'
		#********************** User Auth **************************#

		user = users.get_current_user()
		nickname = ''
		if user:
			nickname=user.nickname()
		if nickname:
			user_info = User.all().filter('user',nickname)
			if user_info.count(1)>0:
				user_info = user_info.get()
				user_lang = user_info.lang
			auth_url = users.create_logout_url(self.request.uri)
			auth_text= 'signout'
		else:
			auth_url = users.create_login_url(self.request.uri)
			auth_text= 'signin'

		#********************** Pagenator init**************************#
		limit = 20;
		p = self.request.get('p')
		if not p:
			p=1
		else:
			p = int(p)
		offset = (p-1)*limit
		
		#********************** Query **************************#
		e = Entry.all().filter('type',req_type).order("-addtime")
		if req_user == 'all':
			req_user = ''
		if req_user:
			e = e.filter("user",req_user)
		if req_tag:
			e = e.filter("tags", unquote(req_tag).decode('utf-8'))
		if not nickname:
			e = e.filter("private", False)

		if e and e.count()>0:
			cur_pageid = e.get().pageid
		else:
			cur_pageid = 0
		item_count = 0
		while cur_pageid>=0:
			entry=Entry.all().filter('type',req_type)
			if req_user:
				entry = entry.filter("user",req_user)
			if req_tag:
				entry = entry.filter('tags',unquote(req_tag).decode('utf-8'))
			if not nickname:
				entry = entry.filter("private", False)
			
			item_count += entry.filter('pageid',cur_pageid).count()
			cur_pageid -=1

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
		
		if req_user:
			tag_list = Tag.all().filter("user",req_user).order("usetime")
		else:
			tag_list = Tag.all().order("-count_"+req_type)
		
		template_values = {
			'nickname' : nickname,
			'req_type' : req_type,
			'req_user' : req_user,
			'auth_url' : auth_url,
			'auth_text': auth_text,
			'entry_list': e,
			'tag_list' : tag_list,
			'is_paginated':  page_count> 1,
			'has_next': p*limit < item_count,
			'has_previous': p > 1,
			'current_page': p,
			'next_page': p + 1,
			'previous_page': p - 1,
			'pages': page_count,
			'page_numbers': page_numbers,
			'count': item_count,
			'uri' : self.request.uri
			}
		path = os.path.join(os.path.dirname(__file__),'templates/'+user_lang+'/'+req_type+'.html')
		self.response.out.write(template.render(path,template_values))

class TagList(webapp.RequestHandler):
	def get(self,req_user=''):
		user_lang = 'en'
		#********************** User Auth **************************#
		user = users.get_current_user()
		nickname = ''
		if user:
			nickname=user.nickname()
		if nickname:
			user_info = User.all().filter('user',nickname)
			if user_info.count(1)>0:
				user_info = user_info.get()
				user_lang = user_info.lang
			auth_url = users.create_logout_url(self.request.uri)
			auth_text= 'signout'
		else:
			auth_url = users.create_login_url(self.request.uri)
			auth_text= 'signin'
		
		entry_count =Entry.all().count(1000)
		if req_user:
			tag_user = req_user
			tags = Tag.all().filter("user",req_user)
		else:
			tag_user = 'all'
			tags = Tag.all()
		tags_count = tags.count(1000)
		tag_list=[]
		for tag in tags:
			tag_count=tag.count_link + tag.count_note + tag.count_pic
			if tag.count_link >= tag.count_note:
				if tag.count_link >= tag.count_pic:
					max_type = 'link'
				else:
					max_type = 'pic'
			else:
				if tag.count_pic >= tag.count_note:
					max_type = 'pic'
				else:
					max_type = 'note'
			#logging.info(tag_count)
			#logging.info(entry_count)
			#logging.info(tags_count)
			tag_list.append({
				"info":tag,
				"type":max_type,
				"level":int(round(tag_count/(float(entry_count)/tags_count)))
				})
		template_values = {
			'nickname' : nickname,
			'req_user' : req_user,
			'auth_url' : auth_url,
			'auth_text': auth_text,
			'tag_user' : tag_user,
			'tags'     : tag_list,
			'uri'      : self.request.uri
			}
		path = os.path.join(os.path.dirname(__file__),'templates/'+user_lang+'/tag.html')
		self.response.out.write(template.render(path,template_values))

class AddForm(webapp.RequestHandler):
	def get(self):
		user_lang = 'en'
		#********************** User Auth **************************#
		user = users.get_current_user()
		nickname = ''
		if user:
			nickname=user.nickname()
		if nickname:
			user_info = User.all().filter('user',nickname)
			if user_info.count(1)>0:
				user_info = user_info.get()
				user_lang = user_info.lang
			auth_url = users.create_logout_url(self.request.uri)
			auth_text= 'signout'

			key = self.request.get('key')
			if key:
				e = db.get(key)
				title = e.title
				url   = e.url
				purl  = ''
				content = e.content
				type  = e.type
				tags  = ' '.join(tag for tag in e.tags)
				tags +=' '
			else:
				title = unescape(self.request.get('title'))
				url   = unescape(self.request.get('url'))
				purl  = unescape(self.request.get('purl'))
				content = unescape(self.request.get('content'))
				type= self.request.get('type')
				if not type:
					type = 'link'
				tags  = ''
			
			template_values = {
				'nickname' : nickname,
				'auth_url' : auth_url,
				'auth_text': auth_text,
				'type'    : type,
				'key'     : key,
				'tag_list': Tag.all().filter("user",nickname).order('usetime'),
				'title'   : title,
				'url'     : url,
				'purl'    : purl,
				'content' : content,
				'tags'    : tags
				}
			path = os.path.join(os.path.dirname(__file__),'templates/'+user_lang+'/add.html')
			self.response.out.write(template.render(path,template_values))
		else:
			self.redirect(users.create_login_url(self.request.uri))

class AddAction(webapp.RequestHandler):
	def post(self):
		#********************** User Auth **************************#
		user = users.get_current_user()
		nickname = ''
		if user:
			nickname=user.nickname()
		if nickname:
			key  = self.request.get('key')
			if key :
				e = db.get(key)
				if e.user != nickname:
					e = Entry()
					e.user = nickname
			else:
				e = Entry()
				e.user = nickname
			type = self.request.get('type')
			if not type:
				type = 'link'
			tz = self.request.get('tz')
			if tz[0:1]=='-':
				tz = int(tz[1:])
				tz = -tz
			else:
				tz = int(tz[1:])
				tz = +tz
			
			title = self.request.get('title')
			e.title = title.replace('&','&amp;').replace('<','&lt;').replace('>','&gt;')
			url = self.request.get('url')
			purl= self.request.get('purl')
			if type == 'pic' and not key:
				e.url = purl.replace('&','&amp;').replace('<','&lt;').replace('>','&gt;')
			else:
				e.url = url.replace('&','&amp;').replace('<','&lt;').replace('>','&gt;')
			content = self.request.get('content')
			e.content = content
			if not key:
				e.addtime +=datetime.timedelta(hours=tz)
			e.private = bool(int(self.request.get('private')))
			e.type = type
			if type =='pic' and not key:
				if url:
					try:
						result = urlfetch.fetch(url)
						if result.status_code == 200:
							e.image = db.Blob(result.content)
					except :
						self.response.out.write('Fetch picture fail! You can <a href="/add?type=pic">upload</a> it manually')
						return
				else:
					myfile = self.request.get("myfile")
					if not myfile:
						self.response.out.write( 'No file specified!')
						return
					try:
						e.image = db.Blob(myfile)
					except :
						self.response.out.write( 'Uploading fail!')
						return

			if key:#更新数据
				for oldtag in e.tags:
					tag = Tag.all().filter("user",nickname).filter('name',oldtag)
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
				if entry.count()>0:
					cur_pageid = entry.get().pageid
				else:
					cur_pageid = 0
				
				cur_pageCount = entry.filter('pageid =',cur_pageid).count(1000)
				
				if cur_pageCount>=max_pageCount:
					e.pageid = cur_pageid+1
				else:
					e.pageid = cur_pageid
				
			e.tags = []
			tag_names = self.request.get('tags').split()
			for tag_name in tag_names:
				tag = Tag.all().filter("user",nickname).filter('name',tag_name)
				if(tag.count(1)>0):
					t = tag.get()
					if type == 'link':
						t.count_link +=1
					if type == 'note':
						t.count_note +=1
					if type == 'pic':
						t.count_pic +=1
					t.user = nickname
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
					t.user = nickname
					t.usetime = datetime.datetime.now()
					t.put()
				e.tags.append(db.Category(tag_name))
			e.put()
			self.redirect('/'+type+'/'+nickname)
		else:
			self.redirect(users.create_login_url(self.request.uri))

class DelKey(webapp.RequestHandler):
	def get(self):
		user = users.get_current_user()
		key = self.request.get('key')
		if key and user:
			e = db.get(key)
			if e:
				nickname = user.nickname()
				if e.user == nickname:
					if e.tags:
						for tag_name in e.tags:
							tag = Tag.all().filter("user",nickname).filter('name',tag_name)
							if(tag.count(1)>0):
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
					self.response.out.write('-1')
			else:
				self.response.out.write('0')
			memcache.delete(key)
		else:
			self.response.out.write('0')

class Image(webapp.RequestHandler):
	def get(self):
		key = self.request.get('key')
		if key:
			data = memcache.get(key)
			if data is None:
				e = db.get(key)
				data = e.image
				memcache.add(key, data, 30*24*3600)
			#img = images.Image(e.image)
			#img.resize(width=400, height=300)
			#tumbimg = img.execute_transforms(output_encoding=images.JPEG)
			self.response.headers['Content-Type'] = 'image/jpeg'
			self.response.out.write(data)
		else:
			self.redirect('/media/logo.gif')

class Set(webapp.RequestHandler):
	def get(self):
		lang = self.request.get('lang')
		if not lang:
			lang ='en'
		#********************** User Auth **************************#
		user = users.get_current_user()
		nickname = ''
		if user:
			nickname=user.nickname()
		if nickname:
			user_info = User.all().filter('user',nickname)
			if user_info.count(1)>0:
				user_info = user_info.get()
				user_info.lang = lang
				user_info.put()
			else:
				user_info =User();
				user_info.user = nickname
				user_info.lang = lang
				user_info.put()
			self.redirect('/link/'+nickname)
		uri = self.request.get('uri')
		if uri:
			self.redirect(unquote(uri).encode('utf-8'))
		else:
			self.redirect('/')

class Help(webapp.RequestHandler):
	def get(self):
		user_lang = 'en'
		#********************** User Auth **************************#
		user = users.get_current_user()
		nickname = ''
		if user:
			nickname=user.nickname()
		if nickname:
			user_info = User.all().filter('user',nickname)
			if user_info.count(1)>0:
				user_info = user_info.get()
				user_lang = user_info.lang
			auth_url = users.create_logout_url(self.request.uri)
			auth_text= 'signout'
		else:
			auth_url = users.create_login_url(self.request.uri)
			auth_text= 'signin'
		template_values = {
			'nickname' : nickname,
			'auth_url' : auth_url,
			'auth_text': auth_text
			}
		path = os.path.join(os.path.dirname(__file__),'templates/'+user_lang+'/help.html')
		self.response.out.write(template.render(path,template_values))

application = webapp.WSGIApplication([
	('/', Main),
	('/set', Set),
	('/add', AddForm),
	('/submit', AddAction),
	('/delkey', DelKey),
	('/tag/(.*)', TagList),#所有用户：/tag/；单个用户：/tag/username
	('/help',Help),
	('/img', Image),
	('/(link|note|pic){1}/(.*)/(.*)', Main),	#所有用户：/note/all/tag；单个用户：/note/user/tag
	('/(link|note|pic){1}/(.*)', Main)			#所有用户：/note/；单个用户：/note/user
	],debug=True)

def main():
	run_wsgi_app(application)

if __name__ == "__main__":
	main()