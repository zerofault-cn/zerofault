from django.conf.urls.defaults import *


urlpatterns = patterns('',
	(r'^register/$', 'newtest.user.views.register'),
)

