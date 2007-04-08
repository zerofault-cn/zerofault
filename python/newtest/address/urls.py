from django.conf.urls.defaults import *
from newtest.address.models import Address

info_dict = {
#    'model': Address,
    'queryset': Address.objects.all(),
}
urlpatterns = patterns('',
	(r'^/?$', 'django.views.generic.list_detail.object_list',dict(paginate_by=3, **info_dict)),
	(r'^upload/$', 'newtest.address.views.upload'),
	(r'^output/$', 'newtest.address.views.output'),

)

