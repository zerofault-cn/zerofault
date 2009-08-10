import datetime
from google.appengine.ext import db 
from google.appengine.tools import bulkloader 
import model

class TrackLoader(bulkloader.Loader):
	def __init__(self):
		bulkloader.Loader.__init__(self, 'Track',[
								('tdate', lambda x: datetime.datetime.strptime(x,'%Y%m%d').date()),
								('ttime', lambda x: datetime.datetime.strptime(x,'%H%M%S').time()), 
								('lat', float), 
								('lon', float),
								('ele', float),
								('sat_level', int),
								('sat_count', int),
								('speed', float),
								('ori', float),
								('pdop', float)
								])

loaders = [TrackLoader]