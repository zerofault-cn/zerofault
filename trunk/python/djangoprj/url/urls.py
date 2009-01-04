from django.conf.urls.defaults import *

urlpatterns = patterns('',
    (r'^/?$', 'djangoprj.url.views.index'),
)
