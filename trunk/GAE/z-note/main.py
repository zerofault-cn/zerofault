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
from xml2dict import XML2Dict


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
		if user:
			nickname=user.nickname()
			auth_url = users.create_logout_url(self.request.uri)
			auth_text= 'signout'
		else:
			auth_url = users.create_login_url(self.request.uri)
			auth_text= 'signin'

		template_values = {
			'nickname' : nickname,
			'ip': self.request.remote_addr,
			'auth_url' : auth_url,
			'auth_text': auth_text
			}
		path = os.path.join(os.path.dirname(__file__),'templates/index.html')
		self.response.out.write(template.render(path,template_values))

class mobile(webapp.RequestHandler):
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
		pub_track  = {}
		pub_track_count = 0
		if user:
			user_track = Track.all().filter('user',user).order('begin_time')
		else:
			pub_track = Track.all().filter('private', False).order('begin_time')
			pub_track_count = pub_track.count()
		template_values = {
			'user_track': user_track,
			'pub_track' : pub_track,
			'pub_track_count' : pub_track_count
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
			
			if data[0:5] == '<?xml':
				logging.info('upload file type: gpx')
				obj = XML2Dict()
				rs = obj.fromstring(data)
				section_count = len(rs.gpx.trk)
				logging.info(100000+section_count)
				#self.response.out.write(rs)
				for trk in rs.gpx.trk:
					point_count = len(trk.trkseg.trkpt)
					#logging.info(2000+point_count)
				
					begin_dt = trk.trkseg.trkpt[0]['time'].value
					tmp = begin_dt[0:-1].split('T')
					begin_time = tmp[0]+tmp[1]
					
					end_dt = trk.trkseg.trkpt[-1]['time'].value
					tmp = end_dt[0:-1].split('T')
					end_time = tmp[0]+tmp[1]
				
					tt = Track.all().filter('user', user).filter('begin_time',datetime.datetime.strptime(begin_time,'%Y-%m-%d%H:%M:%S')).filter('end_time',datetime.datetime.strptime(end_time,'%Y-%m-%d%H:%M:%S'))
					if tt and tt.count()>0:
						continue
					t = Track()
					t.upload_time += datetime.timedelta(hours=+8)
					t.begin_time   = datetime.datetime.strptime(begin_time,'%Y-%m-%d%H:%M:%S')
					t.end_time   = datetime.datetime.strptime(end_time,'%Y-%m-%d%H:%M:%S')
					t.put()
					key = t.key()
					i = 0
					step = int(math.ceil(point_count/618.0))
					logging.info('point_count:'+str(point_count))
					logging.info('step:'+str(step))
					for trkpt in trk.trkseg.trkpt:
						i += 1
						if i!= point_count and (i+step-1)%step != 0:
							continue
						dt = trkpt['time'].value
						tmp = dt[0:-1].split('T')
						time = tmp[0]+tmp[1]
						ele = trkpt['ele'].value
						lon = trkpt['lon'].value
						lat = trkpt['lat'].value
						pdop = trkpt['pdop'].value

						tp = TrackPoint()
						tp.trackid   = key
						tp.time      = datetime.datetime.strptime(time,'%Y-%m-%d%H:%M:%S')
						tp.point     = db.GeoPt(lat, lon)
						if ele=='NaN':
							ele = 0
						tp.elevation = float(ele)
						tp.speed     = 0.0
						tp.pdop      = float(pdop)
						tp.put()
				
			else:
				logging.info('upload file type: csv')
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
					step = int(math.ceil((len(lines)-1)/618.0))
					logging.info('point_count:'+str(len(lines)))
					logging.info('step:'+str(step))
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

class setPrivate(webapp.RequestHandler):
	def get (self):
		key = self.request.get('key')
		user = users.get_current_user()
		if key and user:
			t = db.get(key)
			if t:
				t.private = bool(int(self.request.get('private')))
				t.put()
				self.response.out.write('1')
			else:
				self.response.out.write('0')
		else:
			self.response.out.write('0')

application = webapp.WSGIApplication([
	('/', Index),
	('/upload', Upload),
	('/load', loadTrack),
	('/delete', delTrack),
	('/getlist', showTrackList),
	('/set', setPrivate),
	('/m' ,mobile)
	],debug=True)

def main():
	run_wsgi_app(application)

if __name__ == "__main__":
	main()