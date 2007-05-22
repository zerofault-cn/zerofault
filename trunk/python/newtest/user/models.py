#coding=utf-8
from django.db import models

# Create your models here.

class user_info(models.Model):
    username = models.CharField('用户名',maxlength=20,unique=True)
    password = models.CharField('密码', maxlength=32)
    nickname=models.CharField('昵称',maxlength=32)
    email = models.CharField('E-mail', maxlength=32)

    def __str__(self):
        return self.username

    class Admin: pass
