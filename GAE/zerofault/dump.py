#coding=utf-8
import logging
import csv
import os
import datetime

from google.appengine.ext import webapp
from google.appengine.api import urlfetch
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

class export(webapp.RequestHandler):
	def get (self):
		offset = self.request.get('offset')
		if not offset:
			offset = 0
		e = Entry.all().order('addtime')
		e = e.fetch(10,int(offset))
		path = os.path.join(os.path.dirname(__file__),'templates/export.tpl')
		self.response.out.write(template.render(path,{'e':e}))	

class trigger(webapp.RequestHandler):
	def get (self):
		urlfetch.fetch('http://zerofault.oxyhost.com/5dnote/scripts/import.php')
	
class csv(webapp.RequestHandler):
	def get(self):
		i=0
		
		self.response.headers['Content-Type'] = 'text/csv'
		self.response.headers['Content-Disposition'] = 'attachment; filename="Link_Tag.csv"'
		self.response.headers['Cache-Control'] = 'must-revalidate, post-check=0'
		self.response.headers['Expires'] = '0'
		self.response.headers['Pragma']  = 'public'
		
		entry = Entry.all().order("-addtime")

		for item in entry:
			i +=1
			self.response.out.write('"%d","%s","%s","%s","%s","' %(i, item.title, item.url, item.content, item.private))
				
			tag_names =','.join(tag for tag in item.tags)

			self.response.out.write('%s' % tag_names)
			self.response.out.write('"\r\n')

class rss(webapp.RequestHandler):
	def get(self,req_tag=''):
		entry = Entry.all().order("-addtime")
		if req_tag:
			entry = entry.filter("tags =", unquote(req_tag).decode('utf-8'))

		self.response.headers['Content-Type'] = 'text/xml'
		self.response.out.write('<?xml version="1.0" encoding="UTF-8"?>\r\n')
		#self.response.out.write('<?xml-stylesheet type="text/xsl" href="/css/rss_xml_style.css"?>\r\n')
		self.response.out.write('<rss version="2.0">\r\n')
		self.response.out.write('\t<channel>\r\n')
		self.response.out.write('\t\t<title>zerofault.appspot.com</title>\r\n')
		self.response.out.write('\t\t<image>\r\n')
		self.response.out.write('\t\t\t<title>Link/Note/Pic @GAE</title>\r\n')
		self.response.out.write('\t\t\t<link>http://zerofault.appspot.com/</link>\r\n')
		self.response.out.write('\t\t\t<url>http://zerofault.appspot.com/media/logo.jpg</url>\r\n')
		self.response.out.write('\t\t</image>\r\n')
		self.response.out.write('\t\t<description>My Favorites at Google App Engine</description>\r\n')
		self.response.out.write('\t\t<link>http://zerofault.appspot.com/</link>\r\n')
		self.response.out.write('\t\t<copyright>Copyright 2009 zerofault. All Rights Reserved</copyright>\r\n')
		self.response.out.write('\t\t<language>zh-cn</language>\r\n')
		self.response.out.write('\t\t<generator>python @ google app engine</generator>\r\n')
		i=0
		for item in entry:
			i +=1
			self.response.out.write('\t\t<item>\r\n')
			self.response.out.write('\t\t\t<title>%s</title>\r\n' % (item.title) )
			self.response.out.write('\t\t\t<link>%s</link>\r\n' % item.url)
			self.response.out.write('\t\t\t<author>zerofault@gmail.com</author>\r\n')

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
	('/rss/', rss),
	('/rss/(.*)', rss),
	('/dump/csv', csv),
	('/dump/rss', rss),
	('/dump/trigger', trigger),
	('/dump/export', export)
	],debug=True)

def main():
	run_wsgi_app(application)

if __name__ == "__main__":
	main()