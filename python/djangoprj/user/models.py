#coding=utf-8
from django.db import models

class info(models.Model):
    username = models.CharField('用户名',max_length=20,unique=True)
    password = models.CharField('密码', max_length=32)
    nickname=models.CharField('昵称',max_length=32)
    email = models.CharField('E-mail', max_length=32)

    def __unicode__(self):
        return self.username
