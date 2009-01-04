#coding=utf-8
from django.db import models

class Tag(models.Model):
	name = models.CharField('标签',max_length=20)
	num  = models.IntegerField('使用次数')
	hit = models.BooleanField('使用')

	def __unicode__(self):
		return self.name
	
class User(models.Model):
	name = models.CharField('用户名',max_length=32)
	passwd = models.CharField('密码',max_length=32)
	
	def __unicode__(self):
		return self.name

class Link(models.Model):
	user  = models.ForeignKey(User)
	title = models.CharField('标题',max_length=64)
	url   = models.CharField('链接',max_length=255)
	descr = models.CharField('描述',max_length=255)
	addtime=models.DateTimeField('添加时间')
	private=models.BooleanField('私有')
	tags  = models.ManyToManyField(Tag)

	def __unicode__(self):
		return self.title

