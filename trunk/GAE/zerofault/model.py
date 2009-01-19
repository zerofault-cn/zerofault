from google.appengine.ext import db

class Entry(db.Expando):
	pageid= db.IntegerProperty(default=0)
	title = db.StringProperty()
	url   = db.LinkProperty()
	content = db.TextProperty()
	image = db.BlobProperty()
	addtime=db.DateTimeProperty(auto_now_add=True)
	private=db.BooleanProperty()
	tags  = db.ListProperty(db.Category)
	type  = db.StringProperty(default='link',choices=['link','note','pic'])
	comment=db.ListProperty(db.Key)
	dig   = db.IntegerProperty(default=0)

class Link(db.Expando):
	title = db.StringProperty()
	url   = db.LinkProperty()
	descr = db.TextProperty()
	addtime=db.DateTimeProperty(auto_now_add=True)
	private=db.BooleanProperty()
	tag   = db.ListProperty(db.Key)

class Tag(db.Expando):
	name = db.StringProperty()
	type = db.StringProperty()
	num  = db.IntegerProperty()
	count_link  = db.IntegerProperty(default=0)
	count_note  = db.IntegerProperty(default=0)
	count_pic   = db.IntegerProperty(default=0)
	usetime  = db.DateTimeProperty(auto_now_add=True)
