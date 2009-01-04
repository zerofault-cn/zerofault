#!d:/Python25/python.exe
"""
jngo -- The world's ugliest Django application.

Usage: ./jngo.py

Assuming a working install of Django (http://djangoproject.com/) and SQLite
(http://sqlite.org), this script can be executed directly without any other 
preparations -- you don't have to do `setup.py install`, it doesn't 
need to be on your Python path, you don't need to set DJANGO_SETTINGS_MODULE,
you don't need a webserver. You don't even need content -- the first time it's 
run, it will create a SQLite database in the same directory as the script 
and populate it with sample pages.

Features:

* Editable content on all pages
* Dynamically generated navigation buttons
* Optional private-access pages
* Optional per-page comments
* RSS feed of latest comments, with autodiscovery

Author: Paul Bissex <pb@e-scribe.com>
URL: http://news.e-scribe.com/395
License: MIT

FAQS: 

Q: Should I use this as an example of excellent Django coding practices?
A: Um, no. This is pretty much the opposite of excellent Django coding practices.

Q: Why did you do such a terrible thing?
A: At first, it was just a perverse experiment. It ended up being a
good way to refresh my memory on some Django internals, by trying all
kinds of things that broke in weird ways.
"""

#--- Settings ---
NAME = ROOT_URLCONF = "jngo"
DEBUG = TEMPLATE_DEBUG = True
SITE_ID = 3000
HOSTNAME_AND_PORT = "127.0.0.1:8000"
DATABASE_ENGINE = "sqlite3"
DATABASE_NAME = NAME + ".db"
INSTALLED_APPS = ["django.contrib.%s" % app for app in "auth admin contenttypes sessions sites flatpages comments".split()]
TEMPLATE_LOADERS = ('django.template.loaders.app_directories.load_template_source', NAME + '.template_loader')
MIDDLEWARE_CLASSES = ('django.contrib.sessions.middleware.SessionMiddleware', 'django.contrib.auth.middleware.AuthenticationMiddleware', 
'django.contrib.flatpages.middleware.FlatpageFallbackMiddleware')
TEMPLATE_CONTEXT_PROCESSORS = (NAME + '.context_processor', "django.core.context_processors.auth", "django.core.context_processors.request")

#--- Template loader and templates ---
def template_loader(t, _):
    from django.template import TemplateDoesNotExist
    try:
        return {
            'base.html': """<html><head><title>{{ flatpage.title }}</title><link rel='alternate' type='application/rss+xml' href='/feed/'><style type="text/css">body { margin: 15px 50px; background: #eee; color: #343; font-family: sans-serif; } ul { padding: 0; } li { display: inline; background: #383; padding: 4px 8px; margin: 3px; } li:hover { background: #252; } dd { border-bottom: 1px dotted #666; } a { color: #383; text-decoration: none; } li a { color: #fff; } .anav { background: #141; } .rnav a { color: #ff4; } .error { color: #e22; } #footer { border-top: 1px dotted #555; font-size: 80%; color: #555; margin-top: 15px } #comments { background: #ddd; margin-top: 20px; padding: 10px; } dt { font-weight: bold; margin-top: 1em; }</style></head><body><ul>{% for nav in navs %}<li class="{% ifequal nav.url flatpage.url %}anav {% endifequal %}{% if nav.registration_required %}rnav {% endif %}"><a href="{{ nav.url }}">{{ nav.title }}</a></li>{% endfor %}</ul>{% block content %}{% endblock %}<div id="footer">{% if request.user.is_staff %}<a href="javascript:(function(){if(typeof%20ActiveXObject!='undefined'){var%20x=new%20ActiveXObject('Microsoft.XMLHTTP')}else%20if(typeof%20XMLHttpRequest!='undefined'){var%20x=new%20XMLHttpRequest()}else{return;}x.open('GET',location.href,false);x.send(null);try{var%20type=x.getResponseHeader('x-object-type');var%20id=x.getResponseHeader('x-object-id');}catch(e){return;}document.location='/admin/'+type.split('.').join('/')+'/'+id+'/';})()">Edit this page</a> (as staff user <a href="/admin/">{{ request.user }}</a>)<br>{% endif %}Powered by <a href="http://djangoproject.com/">Django</a> {{ version }}<br></div></body></html>""",
            'flatpages/default.html': """{% extends "base.html" %}{% load comments %}{% block content %}<h1>{{ flatpage.title }}</h1>{{ flatpage.content }}{% if flatpage.enable_comments %}<div id="comments">{% get_free_comment_list for flatpages.flatpage flatpage.id as comments %}<h3>Comments!</h3><dl>{% for comment in comments %}{% include "comment.html" %}{% endfor %}</dl>{% free_comment_form for flatpages.flatpage flatpage.id %}</div>{% endif %}{% endblock %}""",
            'comments/free_preview.html': """{% extends "base.html" %}{% block content %}<h1>Comment preview</h1><dl>{% include "comment.html" %}</dl><form action='.' method='post'><input type='hidden' name='gonzo' value='{{ hash }}'><input type='hidden' name='options' value='{{ options }}'><input type='hidden' name='comment' value='{{ comment.comment }}'><input type='hidden' name='person_name' value='{{ comment.person_name }}'><input type='hidden' name='target' value='{{ target }}'><input type='submit' name='post' value='Post comment'></form>{% endblock %}""", 
            'comments/posted.html': """{% extends "base.html" %}{% block content %}<h1>Comment posted</h1><p>Thanks for posting!</p> <p><a href='{{ object.get_absolute_url }}'>Continue</a></p>{% endblock %}""",
            'comment.html': """<dt>{{ comment.person_name }} said:</dt> <dd>{{ comment.comment }}</dd>""",
            'registration/login.html': """{% extends "base.html" %}{% block content %}{% if form.has_errors %}<h2 class="error">Wrong!</h2>{% endif %}<p>This page is top secret, so you need to log in.</p><form method="post" action=".">Username: {{ form.username }}<br>Password: {{ form.password }}<br><input type="submit" value="login"><input type="hidden" name="next" value="{{ next }}"></form>{% endblock %}"""
            }[t], ''
    except KeyError:
        raise TemplateDoesNotExist
template_loader.is_usable = True

#--- Context processor ---
def context_processor(request):
    from django.contrib.flatpages.models import FlatPage
    navs = FlatPage.objects.all().values("url", "title", "registration_required")
    from django import get_version
    return { 'navs': navs, 'version': get_version() }

#--- RSS Feed (hacky wrapper function needed because of jngo's one-file setup) ---
def feed(*args, **kwargs):
    from django.contrib.comments.feeds import LatestFreeCommentsFeed
    return LatestFreeCommentsFeed(*args, **kwargs)

#--- URLconf ---
from django.conf.urls.defaults import *
urlpatterns = patterns("", 
    (r"^admin/", include("django.contrib.admin.urls")), 
    (r"^comments/", include("django.contrib.comments.urls.comments")), 
    (r"^accounts/login/$", "django.contrib.auth.views.login"),
    (r"^(feed)/$", "django.contrib.syndication.views.feed", {'feed_dict': {'feed': feed}}),
    )

#--- Execution ---
if __name__ == "__main__":
    import os, sys
    from django.core.management import call_command
    here = os.path.dirname(__file__)
    sys.path.append(here)
    os.environ["DJANGO_SETTINGS_MODULE"] = NAME
    if not os.path.isfile(os.path.join(here, DATABASE_NAME)):
        from django.contrib.auth.create_superuser import createsuperuser
        from django.contrib.flatpages.models import FlatPage
        from django.contrib.sites.models import Site
        call_command("syncdb")
        createsuperuser()
        site_obj = Site.objects.create(id=SITE_ID, domain=HOSTNAME_AND_PORT)
        FlatPage.objects.create(url="/", title="Home", content="Welcome to %s!" % NAME).sites.add(site_obj)
        FlatPage.objects.create(url="/stuff/", enable_comments=True, title="Stuff", content="This is a page about stuff.").sites.add(site_obj)
        FlatPage.objects.create(url="/topsecret/", title="Top Secret", content="Now you know.", registration_required=True).sites.add(site_obj)
    call_command("runserver", HOSTNAME_AND_PORT)

