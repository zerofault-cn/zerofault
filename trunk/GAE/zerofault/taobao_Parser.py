#encoding=gb2312

import os
import re
import urllib2
from BeautifulSoup import BeautifulSoup


class ItemParser:
    def __init__(self, html):
        self.html = html
        self.ParseItem()
        
        
    def printItemInfo(self):
        print "Name   = ", self.itemName
        print "Price  = ", self.itemPrice
        print "ImgUrl = ", self.itemImageUrl
        

    def ParseItem(self):
        #feeding the html
        soup = BeautifulSoup(self.html, fromEncoding="gb2312")
        #getting Name of the item
        self.itemName = unicode(soup.find('h1')).split('>')[1]
        self.itemName = self.itemName.split('<')[0]
        self.itemName = re.sub("\n", "", self.itemName)
        self.itemName = re.sub("\t", "", self.itemName)
        #getting Price of the item
        self.itemPrice = float(unicode(soup('input')[16]['value']))
        #getting image address of the item
        for str in self.html.split("\n"):
            if "var l1" in str:
                url = str.split('"')[1]
                break
        imghtml = urllib2.urlopen(url).read()
        soup = BeautifulSoup(imghtml, fromEncoding="gb2312")
        self.itemImageUrl = (soup('img')[0])['src']
        
        

                                  

if __name__ == '__main__':
   # import urllib2
    html = urllib2.urlopen("http://auction1.taobao.com/auction/item_detail-0db1-1f57a6442c686999d619a2b2b9d7df5a.jhtml").read()
   # print html
   # html = open('D:\\workspace\\ItemParser\\src\\res\\item_6.htm', 'r').read()
    Item = ItemParser(html)
    Item.printItemInfo()
    
    