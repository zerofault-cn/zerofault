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
		path = os.path.join(os.path.dirname(__file__),'templates/index.html')
		self.response.out.write(template.render(path,template_values))

class showTrackList(webapp.RequestHandler):
	def get(self):
		user = users.get_current_user()
		user_track = {}
		if user:
			user_track = Track.all().filter('user',user).order('begin_time')
		else:
			return
		template_values = {
			'user_track': user_track
			}
		path = os.path.join(os.path.dirname(__file__),'templates/list.html')
		self.response.out.write(template.render(path,template_values))


class Upload(webapp.RequestHandler):
	def post(self):
		user = users.get_current_user()
		if user:
			data = self.request.get("data")
			if not data:
				self.response.out.write('No data received!')
				return
			
			sections = data.split('-')
			for section in sections[1:]:
				lines = section.splitlines()
				first = lines[1].split(',')
				begin_time = first[0]+first[1]

				last = lines[-1].split(',')
				end_time = last[0]+last[1]

				tt = Track.all().filter('user', user).filter('begin_time',datetime.datetime.strptime(begin_time,'%Y%m%d%H%M%S')).filter('end_time',datetime.datetime.strptime(end_time,'%Y%m%d%H%M%S'))
				if tt and tt.count()>0:
					continue
				t = Track()
				t.upload_time += datetime.timedelta(hours=+8)
				t.begin_time   = datetime.datetime.strptime(begin_time,'%Y%m%d%H%M%S')
				t.end_time   = datetime.datetime.strptime(end_time,'%Y%m%d%H%M%S')
				t.put()
				key = t.key()
				i = 0
				step = int(math.ceil((len(lines)-1)/1000.0))
				logging.info(step)
				for line in lines[1:]:
					i += 1
					if (i+1)!= len(lines) and (i+step-1)%step != 0:
						continue
					#logging.info(line)
					fields = line.split(',')
					tp = TrackPoint()
					tp.trackid   = key
					tp.time      = datetime.datetime.strptime(fields[0]+fields[1],'%Y%m%d%H%M%S')
					tp.point     = db.GeoPt(fields[2], fields[3])
					if fields[4]=='NaN':
						ele = 0
					else:
						ele =  fields[4]
					tp.elevation = float(ele)
					tp.speed     = float(fields[7])
					tp.pdop      = float(fields[9])
					tp.put()

			self.response.out.write('1')
		else:
			self.response.out.write('Not Login')
			

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
			logging.info(tp.count())
			for item in tp:
				if i>0:
					result += ','
				result += '{' 
				result += '"time":"'+str(item.time)+'",'
				result += '"point":{"lat":"'+str(item.point.lat)+'","lon":"'+str(item.point.lon)+'"},'
				result += '"elevation":"'+str(item.elevation)+'",'
				result += '"speed":"'+str(item.speed)+'",'
				result += '"pdop":"'+str(item.pdop)+'"'
				result += '}'
				i += 1
			result += ']'
			#[{"name":"niaochao","point":{"lat":"39.990","lng":"116.397"},"desc":"aoyunhuizhuchangdi"},
			self.response.out.write(result)

class delTrack(webapp.RequestHandler):
	def get (self):
		key = self.request.get('key')
		user = users.get_current_user()
		if key and user:
			t = db.get(key)
			if t:
				db.delete(t)
				tp = TrackPoint.all().filter('trackid',db.Key(key))
				for item in tp:
					item.delete()
				self.response.out.write('1')

application = webapp.WSGIApplication([
	('/', Index),
	('/upload', Upload),
	('/load', loadTrack),
	('/delete', delTrack),
	('/getlist', showTrackList)
	],debug=True)

def main():
	run_wsgi_app(application)

if __name__ == "__main__":
	main()