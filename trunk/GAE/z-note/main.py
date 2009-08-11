#coding=utf-8
import logging
import os
import math
import datetime
import csv

from google.appengine.api import users
from google.appengine.api import urlfetch
from google.appengine.api import images
from google.appengine.api import memcache
from google.appengine.ext import webapp
from google.appengine.ext import search
from google.appengine.ext.webapp import template
from google.appengine.ext.webapp.util import run_wsgi_app
from google.appengine.ext import db

from model import Track,TrackPoint


#---------------------------------------------------------------#
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
#---------------------------------------------------------------#

class Index(webapp.RequestHandler):
	def get(self):
		
		user = users.get_current_user()
		nickname = ''
		user_track = {}
		if user:
			nickname=user.nickname()
			user_track = Track.all().filter('user',user)
			
			auth_url = users.create_logout_url(self.request.uri)
			auth_text= 'signout'
		else:
			auth_url = users.create_login_url(self.request.uri)
			auth_text= 'signin'

		template_values = {
			'nickname' : nickname,
			'user_track': user_track,
			'ip': self.request.remote_addr,
			'auth_url' : auth_url,
			'auth_text': auth_text
			}
		path = os.path.join(os.path.dirname(__file__),'templates/base.html')
		self.response.out.write(template.render(path,template_values))


class Upload(webapp.RequestHandler):
	def post(self):
		user = users.get_current_user()
		if user:
			data = self.request.get("data")
			if not data:
				self.response.out.write( 'No file specified!')
				return
			t = Track()
			i=0
			
			self.response.headers['Content-Type'] = 'text/html'
			#self.response.out.write(len(data))
			lines = data.splitlines()
			for line in lines:
				i += 1
				if i<3:
					continue
				tp = TrackPoint()
				fields = line.split(',')
				begin = fields[0]+fields[1]
				if i==3:
					t.upload_time += datetime.timedelta(hours=+8)
					t.begin_time   = datetime.datetime.strptime(begin,'%Y%m%d%H%M%S')
					t.put()
					key = t.key()
				tp.trackid   = t.key()
				tp.time  = datetime.datetime.strptime(fields[0]+fields[1],'%Y%m%d%H%M%S')
				tp.point     = db.GeoPt(fields[2], fields[3])
				tp.elevation = float(fields[4])
				tp.pdop      = float(fields[9])
				tp.put()
				end = fields[0]+fields[1]
			t = db.get(key)
			t.end_time = datetime.datetime.strptime(end,'%Y%m%d%H%M%S')
			t.put()
			self.redirect('/')
		else:
			self.redirect(users.create_login_url(self.request.uri))

class loadTrack(webapp.RequestHandler):
	def get (self):
		key = self.request.get('key')
		if key:
			tp = memcache.get(key)
			if tp is None:
				tp = TrackPoint.all().filter('trackid',db.Key(key)).order("time")
				memcache.add(key, tp, 30*24*3600)
			self.response.headers['Content-Type'] = 'application/json'
			result = '['
			i = 0
			for item in tp:
				if i>0:
					result += ','
				result += '{' 
				result += '"time":"'+str(item.time)+'",'
				result += '"position":{"lat":"'+str(item.point.lat)+'","lon":"'+str(item.point.lon)+'"},'
				result += '"elevation":"'+str(item.elevation)+'",'
				result += '"pdop":"'+str(item.pdop)+'"'
				result += '}'
				i += 1
			result += ']'
			#[{"name":"niaochao","point":{"lat":"39.990","lng":"116.397"},"desc":"aoyunhuizhuchangdi"},
			self.response.out.write(result)
		
	
application = webapp.WSGIApplication([
	('/', Index),
	('/upload', Upload),
	('/load', loadTrack)
	],debug=True)

def main():
	run_wsgi_app(application)

if __name__ == "__main__":
	main()