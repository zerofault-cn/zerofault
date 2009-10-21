import urllib
import urllib2
import time
import md5
from xml.dom import minidom
 
t = time.localtime()

paramArray = {
	'app_key':'test',
	'method':'taobao.taobaoke.items.get',
	'format':'xml',
	'v':'1.0',
	'timestamp':time.strftime('%Y-%m-%d %X', t),
	'fields':'title,nick,pic_url,price,click_url',
	'pid':'mm_5410_0_0',
	'cid':'1512',
	'page_no':'1',
	'page_size':'6'
}

def _sign(param,sercetCode):
	src = sercetCode + ''.join(["%s%s" % (k, v) for k, v in sorted(param.items())])
	return md5.new(src).hexdigest().upper()
 
def get_taobao_data():

    # generate sign
    sign = _sign(paramArray, 'test');
    paramArray['sign'] = sign

    form_data = urllib.urlencode(paramArray)
    #print form_data

    urlopen = urllib2.urlopen('http://gw.sandbox.taobao.com/router/rest', form_data)
     
    rsp = urlopen.read();
    xmldoc = minidom.parseString(rsp)

    # parse output
    #print "--------------------------------------------------------------------------------"
    taobaokeItem = xmldoc.getElementsByTagName('taobaokeItem')
    return taobaokeItem

def dump_data(data):

    taobaokeItem = data
    product_list = []
    for i in range(0, taobaokeItem.length):
        #print taobaokeItem[i].toxml()
        #print "###########################################"

        attr = taobaokeItem[i].attributes
        for (key, value) in attr.items():
            #print key, "=>", value
            pass

        nodes = taobaokeItem[i].childNodes
        product = {}
        for j in range(0, nodes.length):
            name = nodes[j].nodeName
            value = nodes[j].childNodes[0].nodeValue
            product[name] = value
            #print name, "=>", value

        # add a new product to this list
        product_list.append(product)

    return product_list

if __name__ == "__main__":
    data = get_taobao_data()
    print dump_data(data)


