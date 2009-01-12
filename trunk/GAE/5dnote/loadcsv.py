# -*- coding: utf-8 -*-
import logging

import csv,os,datetime

from google.appengine.ext import webapp
from google.appengine.ext.webapp.util import run_wsgi_app
from google.appengine.ext import db

class Tag(db.Model):
	name = db.StringProperty()
	num  = db.IntegerProperty()
	usetime=db.DateTimeProperty(auto_now_add=True)

class Link(db.Model):
	title = db.StringProperty()
	url   = db.LinkProperty()
	descr = db.TextProperty()
	addtime=db.DateTimeProperty(auto_now_add=True)
	private=db.BooleanProperty()
	tag   = db.ListProperty(db.Key)

class Index(webapp.RequestHandler):
	def get(self):
		t = Tag()
		l = Link()
		
		self.response.headers['Content-Type'] = 'text/html'
		csvreader = csv.reader(file(os.path.join(os.path.dirname(__file__),'data1.csv'))) 
		for line in csvreader:
			#logging.debug(line[0])
			
			l = Link()
			l.title = line[0].decode('utf-8')
			l.url = line[1].decode('utf-8')
			l.descr = line[2].decode('utf-8')
			l.private = False

			tag_name=line[3].decode('utf-8')
			t_q = t.all()
			t_q = t_q.filter('name =',tag_name)
			if(t_q.count(1000)>0):
				t = t_q.get()
				t.num=t.num+1
				t.usetime=datetime.datetime.now()
				t.put()
			else:
				t = Tag()
				t.name = tag_name
				t.num=1
				#t.usetime=datetime.datetime.now()
				t.put()
			l.tag.append(t.key())
			
			l.put()
			self.response.out.write('%s ' % l.key())
			self.response.out.write('%s <br />' % line[0])
		
application = webapp.WSGIApplication([
	('/loadcsv', Index),
	],debug=True)

def main():
	run_wsgi_app(application)

if __name__ == "__main__":
	main()