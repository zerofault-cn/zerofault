{% for i in e %}{{ i.key }}|{{ i.title }}|{{ i.url }}|{{ i.content }}|{{ i.addtime }}|{{ i.private }}|{% for t in i.tags %}{{ t }} {% endfor %}|{{ i.type }}$
{% endfor %}