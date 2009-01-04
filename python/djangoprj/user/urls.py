from django.conf.urls.defaults import *

from djangoprj.user.models import info

info_dict = {
    'queryset': info.objects.all()
}
urlpatterns = patterns('',
    (r'^/?$', 'django.views.generic.list_detail.object_list',dict(paginate_by=5, **info_dict)),
    (r'^register/$', 'djangoprj.user.views.register'),
    (r'^submit/$', 'djangoprj.user.views.submit'),
    (r'^checkUsername/$', 'djangoprj.user.views.checkUsername'),
)

