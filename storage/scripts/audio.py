#coding=utf-8
import os
import json
from gtts import gTTS
from pydub import AudioSegment
import sys, base64
import sqlite3
import datetime
def wts(word):
	tts = gTTS(text=word, lang='en', slow=False)
	tts.save("/home/ftp/www/storage/audio/"+word+".mp3")
def consist(wordlist,name):
	silence = AudioSegment.silent(duration=4000)
	word=AudioSegment.silent(duration=0)
	for a in wordlist:
		if os.path.isfile("/home/ftp/www/storage/audio/"+a+".mp3")==False:
			wts(a)
		word += AudioSegment.from_mp3('/home/ftp/www/storage/audio/'+a.encode('utf-8')+".mp3")
		word +=silence
	word.export("/home/ftp/www/storage/audio/"+name+".mp3", format="mp3")
	return "/home/ftp/www/storage/audio/"+name+".mp3"
#print(len(sys.argv))
if len(sys.argv) > 1:
	data = base64.b64decode(sys.argv[1])
	conn = sqlite3.connect('/home/ftp/www/database/database.sqlite')
	c = conn.cursor()
	once=[]
	twice=[]
	dates=json.loads(data)
	for date in dates:
		if date==datetime.date.today().strftime('%Y%m%d'):
			words = c.execute("SELECT word  from words where date=? and userid=?",(date,sys.argv[2],))
			for word in words:
				twice.append(word[0])
		else:
			#print date
			words = c.execute("SELECT word from words where date=? and userid=?",(date,sys.argv[2],))
			for word in words:
				once.append(word[0])
	conn.close()
	if twice!=[]:
		print consist(twice,"twice")
	if once!=[]:
		print consist(once,"once")
