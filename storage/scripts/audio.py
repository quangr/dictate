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
	with open("/home/ftp/www/storage/audio/"+name+".mp3", "rb") as audio_file:
		encoded_string = base64.b64encode(audio_file.read())
	return encoded_string
#print(len(sys.argv))
if len(sys.argv) > 1:
	data = base64.b64decode(sys.argv[1])
	conn = sqlite3.connect('/home/ftp/www/database/database.sqlite')
	c = conn.cursor()
	once=[]
	twice=[]
	dates=json.loads(data)
	for date in dates:
		if date=='0':
			words = c.execute("SELECT word from dictates where userid=? order by score+?-last_dictate_date DESC ",(sys.argv[2],datetime.date.today().strftime('%Y%m%d'),))
			for word in words:
				twice.append(word[0])
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
		print consist(twice,sys.argv[2])
	if once!=[]:
		print consist(once,sys.argv[2])
