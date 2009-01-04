#coding=utf-8
from djangoprj.user.models import info
from django.http import HttpResponse,HttpResponseRedirect
from django.shortcuts import render_to_response
from django.template import loader, Context

def register(request):
    return render_to_response('user/register.html')

def submit (request):
    username=request.POST['username']
    password=request.POST['password']
    nickname=request.POST['nickname']
    email   =request.POST['email']
    page = info(username=username,password=password,nickname=nickname,email=email)
    page.save()
    return HttpResponseRedirect("../")

def checkUsername(request):
    r=info.objects.filter(username=request.REQUEST['username']).count()
    return HttpResponse("%d" % r)

