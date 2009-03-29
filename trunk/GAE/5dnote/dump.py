#coding=utf-8
import logging
import csv
import os
import datetime

from google.appengine.ext import webapp
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

class csv(webapp.RequestHandler):
	def get(self):
		i=0
		
		self.response.headers['Content-Type'] = 'text/csv'
		self.response.headers['Content-Disposition'] = 'attachment; filename="Link_Tag.csv"'
		self.response.headers['Cache-Control'] = 'must-revalidate, post-check=0'
		self.response.headers['Expires'] = '0'
		self.response.headers['Pragma']  = 'public'
		
		entry = Entry.all().filter("private", False).order("-addtime")

		for item in entry:
			i +=1
			self.response.out.write('"%d","%s","%s","%s","%s","' %(i, item.title, item.url, item.content, item.private))
				
			tag_names =','.join(tag for tag in item.tags)

			self.response.out.write('%s' % tag_names)
			self.response.out.write('"\r\n')

class rss(webapp.RequestHandler):
	def get(self,req_user='',req_tag=''):
		entry = Entry.all().filter("private", False).order("-addtime")
		if req_user != '' and req_user!='all':
			entry = entry.filter("user", req_user)
		if req_tag:
			entry = entry.filter("tags", unquote(req_tag).decode('utf-8'))

		self.response.headers['Content-Type'] = 'text/xml'
		self.response.out.write('<?xml version="1.0" encoding="UTF-8"?>\r\n')
		#self.response.out.write('<?xml-stylesheet type="text/xsl" href="/css/rss_xml_style.css"?>\r\n')
		self.response.out.write('<rss version="2.0">\r\n')
		self.response.out.write('\t<channel>\r\n')
		self.response.out.write('\t\t<title>%s - http://5dnote.appspot.com</title>\r\n' % req_user)
		self.response.out.write('\t\t<image>\r\n')
		self.response.out.write('\t\t\t<title>5dnote.appspot.com</title>\r\n')
		self.response.out.write('\t\t\t<link>http://5dnote.appspot.com/</link>\r\n')
		self.response.out.write('\t\t\t<url>http://5dnote.appspot.com/media/logo.jpg</url>\r\n')
		self.response.out.write('\t\t</image>\r\n')
		self.response.out.write('\t\t<description>%s @ http://5dnote.appspot.com</description>\r\n' % req_user)
		self.response.out.write('\t\t<link>http://5dnote.appspot.com/</link>\r\n')
		self.response.out.write('\t\t<copyright>Copyright 2009 5dnote.appspot.com All Rights Reserved</copyright>\r\n')
		self.response.out.write('\t\t<language>zh-cn</language>\r\n')
		self.response.out.write('\t\t<generator>Google App Engine</generator>\r\n')
		i=0
		for item in entry:
			i +=1
			self.response.out.write('\t\t<item>\r\n')
			self.response.out.write('\t\t\t<title>%s</title>\r\n' % (item.title) )
			self.response.out.write('\t\t\t<link>%s</link>\r\n' % item.url)
			self.response.out.write('\t\t\t<author>%s</author>\r\n' % item.user)

			#for tag in item.tags:
			tag_names =','.join(tag for tag in item.tags)
				
				
			self.response.out.write('\t\t\t<category>%s</category>\r\n' % tag_names)
			self.response.out.write('\t\t\t<pubDate>%s</pubDate>\r\n' % item.addtime)
			comment = ''
			self.response.out.write('\t\t\t<comments>%s</comments>\r\n' % comment)
			if item.content:
				content = '<![CDATA[\n' + item.content + '\n]]>'
			else:
				content = ''
			self.response.out.write('\t\t\t<description>%s</description>\r\n' % content)
			self.response.out.write('\t\t</item>\r\n')
		self.response.out.write('\t</channel>\r\n')
		self.response.out.write('</rss>\r\n')
	
application = webapp.WSGIApplication([
	('/rss/(.*)/(.*)', rss),
	('/rss/(.*)', rss),
	('/dump/csv', csv),
	('/dump/rss', rss)
	],debug=True)

def main():
	run_wsgi_app(application)

if __name__ == "__main__":
	main()