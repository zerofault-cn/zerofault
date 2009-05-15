import logging
import re
from BeautifulSoup import BeautifulSoup

from google.appengine.ext import webapp
from google.appengine.ext.webapp.util import run_wsgi_app
from google.appengine.api import urlfetch


class Parse(webapp.RequestHandler):
	def get(self):
		url = "http://www.baidu.com/"
		try:
			result = urlfetch.fetch(url)
			if result.status_code == 200:
				#self.response.headers['charset'] = 'gb2312'
				html = result.content
				#soup = BeautifulSoup(html, fromEncoding="gb2312")
				#title = soup.find('title').split('>')[1]
				self.response.out.write(html)
		except:
			self.response.out.write('error:获取数据超时！')
			return



application = webapp.WSGIApplication([
	('/parse', Parse)
	],debug=True)

def main():
	run_wsgi_app(application)

if __name__ == "__main__":
	main()