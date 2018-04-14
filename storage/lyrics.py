#coding=utf-8
import json
import requests
from bs4 import BeautifulSoup
import sys
import sqlite3
from bs4 import SoupStrainer
def downloadlyric(listid):
	headers={'User-Agent': 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/61.0.3163.79 Chrome/61.0.3163.79 Safari/537.36'}
	a=requests.get("https://music.163.com/"+listid,headers=headers)
	s=BeautifulSoup(a.text,'lxml')
	aa=s.find('ul',class_="f-hide")
	#f = open('a.txt', 'w')
	#b=requests.get("http://music.163.com/api/song/media?id=411315441").text
	#print json.loads(b)['lyric']
	conn = sqlite3.connect('../database/test.db')
	c = conn.cursor()
	for ss in aa.find_all('a'):
		b=json.loads(requests.get("http://music.163.com/api/song/media?id="+ss['href'][9:]).text)
		if b.has_key('lyric'):
			c.execute('INSERT INTO lyrics (name, lyrics) VALUES (?, ?)',(ss.string,b['lyric']))
			conn.commit()
	conn.close()
def findword(word):
	conn = sqlite3.connect('../database/test.db')
	c = conn.cursor()
	word1="%"+word+"%"
	words = c.execute("SELECT * from lyrics where lyrics LIKE ?",(word1,))
	for bb in words:
		print bb[1]
		str1=bb[2].encode('utf-8')
		n=str1[0:str1.find(word)].count('\n')
		str1=str1.splitlines()
		if n>0 :
			print str1[n-1]
		print str1[n]
		if n<len(str1)-1:
			print str1[n+1]
	conn.close()
#f.close
reload(sys)
sys.setdefaultencoding('utf-8')
if len(sys.argv) > 1:
	findword(sys.argv[1])
	only_a_tags = SoupStrainer("pre")
	payload = {'Form': 'Dict1', 'Query': sys.argv[1],'Strategy':'*','Database':'gcide','submit':'Submit+query'}
	r = requests.post("http://www.dict.org/bin/Dict", data=payload)
	s=BeautifulSoup(r.text,'lxml',parse_only=only_a_tags)
	aa=s.get_text()
	print aa