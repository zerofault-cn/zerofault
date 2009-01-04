from django.conf.urls.defaults import *

from djangoprj.favorites.models import Link,Tag

mydict = {
    'queryset': Link.objects.all()
}
urlpatterns = patterns('',
    (r'^/?$', 'django.views.generic.list_detail.object_list',dict(paginate_by=5, **mydict)),
    (r'^add/$', 'djangoprj.favorites.views.add'),
    (r'^add/submit/$', 'djangoprj.favorites.views.add_submit'),
)

