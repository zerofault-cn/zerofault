#coding=utf-8
import logging
import csv
import os
import datetime

from google.appengine.ext import webapp
from google.appengine.ext.webapp.util import run_wsgi_app
from google.appengine.ext import db

from model import Entry,Link,Tag

class fix1(webapp.RequestHandler):
	def get (self):
		
		for tag in Tag.all():
			tag.type ='link'
			tag.count_link=tag.num
			tag.count_note=0
			tag.count_pic=0
			tag.put()
		#	del tag.num
		


class fix2(webapp.RequestHandler):
	def get (self):
	#	e0=Entry().all()
	#	del e0
		p=self.request.get('p')
		p = int(p)
		link=Link.all()
		link=link.fetch(60,80+60*p)
		for l in link:
			e = Entry()
			e.title = l.title
			e.url   = l.url
			e.content=l.descr
			e.image = ''
			e.addtime=l.addtime
			e.private=l.private
			e.type='link'
			e.comment=[]
			e.dig=0

			for t in db.get(l.tag):
				if t:
					e.tags.append(t.name)
			e.put()
		#	del link_item.tag
			
	
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
			self.response.out.write('"\r\n')

class rss(webapp.RequestHandler):
	def get(self):
		self.response.headers['Content-Type'] = 'text/xml'

		link = Link.all().order("-addtime")
		
		self.response.out.write('<?xml version="1.0" encoding="UTF-8"?>\r\n')
		#self.response.out.write('<?xml-stylesheet type="text/xsl" href="/css/rss_xml_style.css"?>\r\n')
		self.response.out.write('<rss version="2.0">\r\n')
		self.response.out.write('\t<channel>\r\n')
		self.response.out.write('\t\t<title>MyFavorites</title>\r\n')
		self.response.out.write('\t\t<image>\r\n')
		self.response.out.write('\t\t\t<title>MyFavorites</title>\r\n')
		self.response.out.write('\t\t\t<link>http://zerofault.appspot.com/</link>\r\n')
		self.response.out.write('\t\t\t<url>http://zerofault.appspot.com/media/logo.jpg</url>\r\n')
		self.response.out.write('\t\t</image>\r\n')
		self.response.out.write('\t\t<description>My Favorites at Google App Engine</description>\r\n')
		self.response.out.write('\t\t<link>http://zerofault.appspot.com/</link>\r\n')
		self.response.out.write('\t\t<copyright>Copyright 2009 zerofault. All Rights Reserved</copyright>\r\n')
		self.response.out.write('\t\t<language>zh-cn</language>\r\n')
		self.response.out.write('\t\t<generator>python @ google app engine</generator>\r\n')
		i=0
		for link_item in link:
			i +=1
			self.response.out.write('\t\t<item>\r\n')
			self.response.out.write('\t\t\t<title>%s</title>\r\n' % (link_item.title) )
			self.response.out.write('\t\t\t<link>%s</link>\r\n' % link_item.url)
			self.response.out.write('\t\t\t<author>zerofault@gmail.com</author>\r\n')
			tag_names = ''
			for tag_item in db.get(link_item.tag):
				if tag_item:
					tag_names = tag_names+tag_item.name+' '
				
			self.response.out.write('\t\t\t<category>%s</category>\r\n' % tag_names.strip())
			self.response.out.write('\t\t\t<pubDate>%s</pubDate>\r\n' % link_item.addtime)
			comment = ''
			self.response.out.write('\t\t\t<comments>%s</comments>\r\n' % comment)
			if link_item.descr:
				descr = '<![CDATA[\n' + link_item.descr + '\n]]>'
			else:
				descr = ''
			self.response.out.write('\t\t\t<description>%s</description>\r\n' % link_item.descr)
			self.response.out.write('\t\t</item>\r\n')
		self.response.out.write('\t</channel>\r\n')
		self.response.out.write('</rss>\r\n')
	
application = webapp.WSGIApplication([
	('/dump/csv', csv),
	('/dump/rss', rss),
	('/dump/fix1', fix1),
	('/dump/fix2', fix2),
	],debug=True)

def main():
	run_wsgi_app(application)

if __name__ == "__main__":
	main()