#coding=utf-8
from newtest.user.models import user_info
from django.http import HttpResponse,HttpResponseRedirect
from django.shortcuts import render_to_response
from django.template import loader, Context

def register(request):
    return render_to_response('user/register.html')

