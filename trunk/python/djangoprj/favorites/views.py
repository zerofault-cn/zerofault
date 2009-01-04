#coding=utf-8
from djangoprj.favorites.models import Link,Tag,User
from django.http import HttpResponse,HttpResponseRedirect
from django.shortcuts import render_to_response
from django.template import loader, Context
import datetime

def add(request):
	return render_to_response('favorites/add.html')

def add_submit (request):
	user_name  = request.POST['user_name']
	user=User.objects.get(name__exact=user_name)

	title = request.POST['title']
	url   = request.POST['url']
	descr = request.POST['descr']
	private=request.POST['private']
	tags  = request.POST['tags']
	obj = Link(user=user,title=title,url=url,descr=descr,addtime=datetime.datetime.now(),private=private)
	obj.save()
	return HttpResponseRedirect("../../")



