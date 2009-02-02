#coding=utf-8
from google.appengine.ext import db

class User(db.Model):
	email = db.EmailProperty()
	nickname= db.StringProperty()

class Entry(db.Model):
	userid= db.ReferenceProperty(User)
	pageid= db.IntegerProperty(default=0)
	title = db.StringProperty()
	url   = db.StringProperty()
	content = db.TextProperty()
	image = db.BlobProperty()
	addtime=db.DateTimeProperty(auto_now_add=True)
	private=db.BooleanProperty()
	tags  = db.ListProperty(db.Category)
	type  = db.StringProperty(default='link',choices=['link','note','pic'])
	comment=db.ListProperty(db.Key)
	dig   = db.IntegerProperty(default=0)

class Tag(db.Model):
	userid= db.ReferenceProperty(User)
	name = db.StringProperty()
	#type = db.StringProperty()
	#num  = db.IntegerProperty()
	count_link  = db.IntegerProperty(default=0)
	count_note  = db.IntegerProperty(default=0)
	count_pic   = db.IntegerProperty(default=0)
	usetime  = db.DateTimeProperty(auto_now_add=True)
