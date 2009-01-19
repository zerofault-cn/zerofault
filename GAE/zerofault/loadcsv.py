# -*- coding: utf-8 -*-
import logging

import csv,os,datetime

from google.appengine.ext import webapp
from google.appengine.ext.webapp.util import run_wsgi_app
from google.appengine.ext import db

from model import Entry,Link,Tag

class Index(webapp.RequestHandler):
	def get(self):
		i=0
		n = self.request.get('n')
		if not n:
			n='1'
		csvfile='data/data'+n+'.csv'
		
		self.response.headers['Content-Type'] = 'text/html'
		csvreader = csv.reader(file(os.path.join(os.path.dirname(__file__),csvfile))) 
		for line in csvreader:
			e = Entry()
			e.title = line[0].decode('utf-8')
			e.url = line[1].decode('utf-8')
			e.content = line[2].decode('utf-8')
			e.private = False

			tag_name=line[3].decode('utf-8')
			t_q = Tag.all()
			t_q = t_q.filter('name =',tag_name)
			if(t_q.count(1)>0):
				t = t_q.get()
				t.count_link+=1
				t.usetime=datetime.datetime.now()
				t.put()
			else:
				t = Tag()
				t.name = tag_name
				t.count_link=1
				t.usetime=datetime.datetime.now()
				t.put()
			e.tags.append(db.Category(tag_name))
			
			e.put()
			i +=1
			self.response.out.write('%d ' % i)
			self.response.out.write('%s ' % e.key())
			self.response.out.write('%s <br />' % line[0])
		
application = webapp.WSGIApplication([
	('/loadcsv', Index),
	],debug=True)

def main():
	run_wsgi_app(application)

if __name__ == "__main__":
	main()