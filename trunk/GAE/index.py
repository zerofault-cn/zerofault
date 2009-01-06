import cgi
import os

from google.appengine.api import users
from google.appengine.ext import webapp
from google.appengine.ext.webapp.util import run_wsgi_app
from google.appengine.ext import db
from google.appengine.ext.webapp import template



class User(db.Model):
	name   = db.StringProperty()
	passwd = db.StringProperty()
	email  = db.EmailProperty()
	

class Tag(db.Model):
	name = db.StringProperty()
	num  = db.IntegerProperty()
	hit  = db.BooleanProperty()

class Link(db.Model):
	user  = db.ReferenceProperty(User)
	tag   = db.ReferenceProperty(Tag)
	title = db.StringProperty()
	url   = db.LinkProperty()
	descr = db.StringProperty(multiline=True)
	addtime=db.DateTimeProperty(auto_now_add=True)
	private=db.BooleanProperty()



class MainPage(webapp.RequestHandler):
	def get(self):
		
		link_query = Link.all().order("-addtime")
		link_list = link_query.fetch(1000)

		if users.get_current_user():
			url = users.create_logout_url(self.request.uri)
			url_linktext = 'LogOut'
		else:
			url = users.create_login_url(self.request.uri)
			url_linktext = 'Login'
		
		template_values = {
			'link_list': link_list,
			'url': url,
			'url_linktext': url_linktext
			}
		path = os.path.join(os.path.dirname(__file__),'index.html')
		self.response.out.write(template.render(path,template_values))
	
			

class AddForm(webapp.RequestHandler):
	def get(self):

		tag_query = Tag.all();
		tag_list = tag_query.fetch(1000)

		template_values = {
			'tag_list': tag_list
			}
		path = os.path.join(os.path.dirname(__file__),'add.html')
		self.response.out.write(template.render(path,template_values))
		
	

class AddAction(webapp.RequestHandler):
	def post(self):
		google_user = users.get_current_user()

		u = User()
		t = Tag()
		l = Link()

		query = u.all()
		query = query.filter('email=',google_user.email())
		if(query.count(1000)>0):
			u = query.get()
		else:
			u.name = google_user.nickname()
			u.passwd = '123456'
			u.email = google_user.email()
			u.put()

		t.name = self.request.get('tags')
		t.num=1
		t.hit=True
		t.put()

		l.user = u
		l.tag = t
		l.title = self.request.get('title')
		l.url = self.request.get('url')
		l.descr = self.request.get('descr')
		l.private = bool(self.request.get('private'))
		l.put()
		self.redirect('/')

application = webapp.WSGIApplication(
                                     [('/', MainPage),
                                      ('/add', AddForm),
									  ('/submit', AddAction)],
                                     debug=True)

def main():
	run_wsgi_app(application)

if __name__ == "__main__":
	main()