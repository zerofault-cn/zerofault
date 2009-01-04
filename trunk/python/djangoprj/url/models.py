#coding=utf-8
from django.db import models

class Category(models.Model):
    name = models.CharField(max_length=16)
    descr = models.CharField(max_length=255)
    sort=models.IntegerField()
    flag = models.BooleanField()

    def __unicode__(self):
        return self.name


class Website(models.Model):
    cate = models.ForeignKey(Category)
    name    = models.CharField(max_length=64)
    url    = models.CharField(max_length=255)
    descr    = models.CharField(max_length=255)
    sort=models.IntegerField()
    flag = models.BooleanField()
    
    def __unicode__(self):
        return self.name



