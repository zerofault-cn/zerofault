#coding=utf-8
import logging
import os
import math
import datetime


from google.appengine.api import users
from google.appengine.api import urlfetch
from google.appengine.api import images
from google.appengine.api import memcache
from google.appengine.ext import webapp
from google.appengine.ext import search
from google.appengine.ext.webapp import template
from google.appengine.ext.webapp.util import run_wsgi_app
from google.appengine.ext import db
from model import Track


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

class Index(webapp.RequestHandler):
	def get(self):

		path = os.path.join(os.path.dirname(__file__),'templates/base.html')
		self.response.out.write(template.render(path,{}))


application = webapp.WSGIApplication([
	('/', Index)
	],debug=True)

def main():
	run_wsgi_app(application)

if __name__ == "__main__":
	main()