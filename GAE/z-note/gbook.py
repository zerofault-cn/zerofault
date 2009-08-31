import cgi 
 
from google.appengine.api import users 
from google.appengine.ext import webapp 
from google.appengine.ext.webapp.util import run_wsgi_app 
from google.appengine.ext import db 

class gbook(db.Model): 
	author = db.UserProperty() 
	content = db.StringProperty(multiline=True) 
	date = db.DateTimeProperty(auto_now_add=True) 

class MainPage(webapp.RequestHandler): 
	def get(self): 
		self.response.out.write('<html><body>') 

		greetings = db.GqlQuery("SELECT * FROM gbook ORDER BY date DESC LIMIT 10") 

		for greeting in greetings: 
			if greeting.author: 
				self.response.out.write('<b>%s</b> wrote:' % greeting.author.nickname()) 
			else: 
				self.response.out.write('An anonymous person wrote:') 
				self.response.out.write('<blockquote>%s</blockquote>' % cgi.escape(greeting.content)) 

			# Write the submission form and the footer of the page 
		self.response.out.write(""" 
			<form action="/gbook/post" method="post"> 
				<div><textarea name="content" rows="3" cols="60"></textarea></div> 
				<div><input type="submit" value="Sign Guestbook"></div> 
			</form> 
			</body> 
			</html>""") 

class Guestbook(webapp.RequestHandler): 
	def post(self): 
		greeting = gbook() 

		if users.get_current_user(): 
			greeting.author = users.get_current_user() 
 
		greeting.content = self.request.get('content') 
		greeting.put() 
		self.redirect('/gbook/') 

application = webapp.WSGIApplication( 
                                     [('/gbook/', MainPage), 
                                      ('/gbook/post', Guestbook)], 
                                     debug=True) 
 
def main(): 
  run_wsgi_app(application) 
 
if __name__ == "__main__": 
  main()