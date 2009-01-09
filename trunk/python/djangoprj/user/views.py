#coding=utf-8
from djangoprj.user.models import Info
from django.http import HttpResponse,HttpResponseRedirect
from django.shortcuts import render_to_response
from django.template import loader, Context

def register(request):
    return render_to_response('user/register.html')

def submit (request):
    u = request.POST['username']
    p = request.POST['password']
    n = request.POST['nickname']
    e = request.POST['email']
    p = Info(username=u,password=p,nickname=n,email=e)
    p.save()
    return HttpResponseRedirect("../")

def checkUsername(request):
    r=info.objects.filter(username=request.REQUEST['username']).count()
    return HttpResponse("%d" % r)

