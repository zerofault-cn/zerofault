#coding=utf-8
# Create your views here.
from newtest.address.models import Address
from django.http import HttpResponse,HttpResponseRedirect
from django.shortcuts import render_to_response
from django.template import loader, Context

def upload(request):
    file_obj = request.FILES.get('file', None)
    if file_obj:
        import csv
        import StringIO
        buf = StringIO.StringIO(file_obj['content'])
        try:
            reader = csv.reader(buf)
        except:
            return render_to_response('address/error.html',
                {'message':'你需要上传一个csv格式的文件！'})
        for row in reader:
#            objs = Address.objects.get_list(name__exact=row[0])
            objs = Address.objects.filter(name=row[0])
            if not objs:
                obj = Address(name=row[0], gender=row[1],
                    telphone=row[2], mobile=row[3], room=row[4])
            else:
                obj = objs[0]
                obj.gender = row[1]
                obj.telphone = row[2]
                obj.mobile = row[3]
                obj.room = row[4]
            obj.save()

        return HttpResponseRedirect('../')
    else:
        return render_to_response('address/error.html',
            {'message':'你需要上传一个文件！'})

def output(request):
    response = HttpResponse(mimetype='text/csv')
    response['Content-Disposition'] = 'attachment; filename=%s' % 'address.csv'
    t = loader.get_template('csv.html')
#    objs = Address.objects.get_list()
    objs = Address.objects.all()
    d = []
    for o in objs:
        d.append((o.name, o.gender, o.telphone, o.mobile, o.room))
    c = Context({
        'data': d,
    })
    response.write(t.render(c))
    return response
