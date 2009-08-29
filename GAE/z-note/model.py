from google.appengine.ext import db


class Track(db.Model):
	user        = db.UserProperty(auto_current_user_add=True)
	upload_time = db.DateTimeProperty(auto_now_add=True)
	begin_time  = db.DateTimeProperty()
	end_time    = db.DateTimeProperty()
	private     = db.BooleanProperty(default=True)

class TrackPoint(db.Model):
	trackid   = db.ReferenceProperty(Track)
	time      = db.DateTimeProperty()
	point     = db.GeoPtProperty()
	elevation = db.FloatProperty()
	speed     = db.FloatProperty()
	pdop      = db.FloatProperty()