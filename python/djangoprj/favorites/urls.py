from django.conf.urls.defaults import *

urlpatterns = patterns('',
	(r'^/?$', 'djangoprj.favorites.views.index'),
	(r'^add/$', 'djangoprj.favorites.views.add'),
	(r'^add/submit/$', 'djangoprj.favorites.views.add_submit'),
)

