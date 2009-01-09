#coding=utf-8
from djangoprj.favorites.models import Link,Tag,User
from django.core.exceptions import ObjectDoesNotExist
from django.http import HttpResponse,HttpResponseRedirect
from django.shortcuts import render_to_response
from django.template import loader, Context
import datetime

from django.core.paginator import Paginator, InvalidPage, EmptyPage

def index(request,tag_name=''):
	link_list=[]
	if (tag_name):
		link_all=Link.objects.filter(private=False).filter(tag__name__exact=tag_name).order_by("-id")
	else:
		link_all=Link.objects.filter(private=False).order_by("-id")
	paginator = Paginator(link_all, 20)

	try:
		page = int(request.GET.get('page', '1'))
	except ValueError:
		page = 1
	try:
		link = paginator.page(page)
	except (EmptyPage, InvalidPage):
		link = paginator.page(paginator.num_pages)

	for link_item in link.object_list:
		#link_list.append({'user':link_item.user,'tag':link_item.tag,'info':link_item})
		link_list.append({
						'user':link_item.user,
						'tag':link_item.tag.all(),
						'info':link_item})

	return render_to_response('favorites/index.html', {
		'link_list': link_list,
		'tag_list': Tag.objects.values('name').exclude(name='').distinct(),
		'is_paginated': paginator.num_pages > 1,
		'has_next': link.has_next(),
		'has_previous': link.has_previous(),
		'current_page': page,
		'next_page': page + 1,
		'previous_page': page - 1,
		'pages': paginator.num_pages,
		'page_numbers': paginator.page_range,
		'count': paginator.count
	})


def add(request):
	return render_to_response('favorites/add.html',{'tag_list':Tag.objects.values('name').distinct()})

def add_submit (request):
	user_name  = request.POST['user_name']
	try:
		u=User.objects.get(name__exact=user_name)
	except User.DoesNotExist:
		u = User(name=user_name,passwd='',email='')
		u.save()

	title = request.POST['title']
	url   = request.POST['url']
	descr = request.POST['descr']
	private=request.POST['private']
	tags  = request.POST['tags']
	#tag_name= request.POST['tags']

	#Tag.objects.all().update(hit=0)
	
	#oTag=Tag.objects.filter(name=tag_name)
	#if(oTag.count()>0):
		#tag_id=oTag
	#else:
	#	tag_id=Tag(name=tag_name,num=1,hit=1)
	#	tag_id.save()

	#oLink = Link(user=user_id,tag=tag_id,title=title,url=url,descr=descr,addtime=datetime.datetime.now(),private=int(private))
	l = Link(user=u,title=title,url=url,descr=descr,addtime=datetime.datetime.now(),private=int(private))
	l.save()

	tag_names = tags.split();
	for tag_name in tag_names:
		t = Tag.objects.create(name=tag_name,num=1,hit=1)
		l.tag.add(t)
		
	return HttpResponseRedirect("../../")

