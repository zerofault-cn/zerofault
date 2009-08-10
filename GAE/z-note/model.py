from google.appengine.ext import db

class Track(db.Model):
	date   = db.DateProperty()
	time   = db.TimeProperty()
	lat    = db.FloatProperty()
	lon    = db.FloatProperty()
	ele    = db.FloatProperty()
	sat_level = db.IntegerProperty()
	sat_count = db.IntegerProperty()
	speed  = db.FloatProperty()
	ori    = db.FloatProperty()
	pdop   = db.FloatProperty()