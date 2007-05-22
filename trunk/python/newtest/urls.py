from django.conf.urls.defaults import *
from django.conf import settings

urlpatterns = patterns('',
    # Example:
    # (r'^newtest/', include('newtest.apps.foo.urls.foo')),
	(r'^python/$', 'newtest.helloworld.index'),
	(r'^python/add/$', 'newtest.add.index'),
	(r'^python/list/$', 'newtest.list.index'),
	(r'^python/csv/(?P<filename>\w+)/$', 'newtest.csv_test.output'),
	(r'^python/login/$', 'newtest.login.login'),
	(r'^python/logout/$', 'newtest.login.logout'),
	(r'^python/wiki/$', 'newtest.wiki.views.index'),
	(r'^python/wiki/(?P<pagename>\w+)/$', 'newtest.wiki.views.index'),
	(r'^python/wiki/(?P<pagename>\w+)/edit/$', 'newtest.wiki.views.edit'),
	(r'^python/wiki/(?P<pagename>\w+)/save/$', 'newtest.wiki.views.save'),
	(r'^python/address/', include('newtest.address.urls')),
    (r'^python/user/', include('newtest.user.urls')),
	(r'^python/site_media/(?P<path>.*)$', 'django.views.static.serve',{'document_root': settings.STATIC_PATH}),
	(r'^python/fileinfo/$', 'newtest.fileinfo.index'),


    # Uncomment this for admin:
	(r'^python/admin/', include('django.contrib.admin.urls')),

)
