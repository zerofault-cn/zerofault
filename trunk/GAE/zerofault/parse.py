import xml.dom.minidom


from google.appengine.ext import webapp
from google.appengine.ext.webapp.util import run_wsgi_app


class Parse(webapp.RequestHandler):
	def get(self):
		doc = xml.dom.minidom.parse('http://www.baidu.com')



application = webapp.WSGIApplication([
	('/parse', Parse)
	],debug=True)

def main():
	run_wsgi_app(application)

if __name__ == "__main__":
	main()