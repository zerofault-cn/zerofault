from django.conf.urls.defaults import *

from newtest.user.models import user_info

info_dict = {
    'queryset': user_info.objects.all()
}
urlpatterns = patterns('',
    (r'^/?$', 'django.views.generic.list_detail.object_list',dict(paginate_by=5, **info_dict)),
    (r'^register/$', 'newtest.user.views.register'),
    (r'^submit/$', 'newtest.user.views.submit'),
    (r'^checkUsername/$', 'newtest.user.views.checkUsername'),
)

