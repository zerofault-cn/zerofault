#coding=utf-8
import logging

import csv,os,datetime

from google.appengine.ext import webapp
from google.appengine.ext.webapp.util import run_wsgi_app
from google.appengine.ext import db

class Link(db.Model):
	title = db.StringProperty()
	url   = db.LinkProperty()
	descr = db.TextProperty()
	addtime=db.DateTimeProperty(auto_now_add=True)
	private=db.BooleanProperty()
	tag   = db.ListProperty(db.Key)

class Tag(db.Expando):
	name = db.StringProperty()
	num  = db.IntegerProperty()
	usetime  = db.DateTimeProperty(auto_now_add=True)

class csv(webapp.RequestHandler):
	def get(self):
		i=0
		
		self.response.headers['Content-Type'] = 'text/csv'
		self.response.headers['Content-Disposition'] = 'attachment; filename="Link_Tag.csv"'
		self.response.headers['Cache-Control'] = 'must-revalidate, post-check=0'
		self.response.headers['Expires'] = '0'
		self.response.headers['Pragma']  = 'public'
		
		link = Link.all().order("-addtime")

		for link_item in link:
			i +=1
			self.response.out.write('"%d","%s","%s","%s","%s","' %(i, link_item.title, link_item.url, link_item.descr, link_item.private))
				
			#tags =db.get(link_item.tag)
			tag_names = ''
			for tag_item in db.get(link_item.tag):
				if tag_item:
					tag_names = tag_names+tag_item.name+' '
			self.response.out.write('%s' % tag_names.strip())
			self.response.out.write('"\n')

class rss(webapp.RequestHandler):
	def get(self):
		self.response.headers['Content-Type'] = 'text/xml'

		link = Link.all().order("-addtime")
		
		self.response.out.write('<?xml version="1.0" encoding="UTF-8"?>\n')
		#self.response.out.write('<?xml-stylesheet type="text/xsl" href="/css/rss_xml_style.css"?>\n')
		self.response.out.write('<rss version="2.0">\n')
		self.response.out.write('<channel>\n')
		self.response.out.write('<title>MyFavorites</title>\n')
		self.response.out.write('<image>\n')
		self.response.out.write('<title>MyFavorites</title>\n')
		self.response.out.write('<link>http://zerofault.appspot.com/</link>\n')
		self.response.out.write('<url>http://zerofault.appspot.com/media/logo.jpg</url>\n')
		self.response.out.write('</image>\n')
		self.response.out.write('<description>My Favorites at Google App Engine</description>\n')
		self.response.out.write('<link>http://zerofault.appspot.com/</link>\n')
		self.response.out.write('<copyright>Copyright 2009 zerofault. All Rights Reserved</copyright>\n')
		self.response.out.write('<language>zh-cn</language>\n')
		self.response.out.write('<generator>python @ google app engine</generator>\n')
		i=0
		for link_item in link:
			i +=1
			self.response.out.write('<item>\n')
			self.response.out.write('<title>%s</title>\n' % (link_item.title) )
			self.response.out.write('<link>%s</link>\n' % link_item.url)
			self.response.out.write('<author>zerofault@gmail.com</author>\n')
			tag_names = ''
			for tag_item in db.get(link_item.tag):
				if tag_item:
					tag_names = tag_names+tag_item.name+' '
				
			self.response.out.write('<category>%s</category\n>' % tag_names.strip())
			self.response.out.write('<pubDate>%s</pubDate>\n' % link_item.addtime)
			comment = ''
			self.response.out.write('<comments>%s</comments>\n' % comment)
			self.response.out.write('<description>%s</description>\n' % link_item.descr)
			self.response.out.write('</item>\n')
		self.response.out.write('</channel>\n')
		self.response.out.write('</rss>\n')
	
application = webapp.WSGIApplication([
	('/dump/csv', csv),
	('/dump/rss', rss)
	],debug=True)

def main():
	run_wsgi_app(application)

if __name__ == "__main__":
	main()