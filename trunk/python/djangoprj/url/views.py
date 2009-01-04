#coding=utf-8
from django.shortcuts import get_object_or_404, render_to_response
from django.http import HttpResponse, HttpResponseRedirect
from djangoprj.url.models import Category,Website
from datetime import datetime

def index(request):
	category_list=[]
	category=Category.objects.all()
	for cate_item in category:
		category_list.append({'info':cate_item,'site':Website.objects.filter(cate__id=cate_item.id)})
	return render_to_response('url/index.html', {'category_list': category_list,})
