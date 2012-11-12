#!/usr/bin/python

import urllib2
import json
import MySQLdb
import os

#isbn13 = str(9781932664089)
#bookUrl = 'http://openlibrary.org/api/books?bibkeys=ISBN:'+isbn13+'&jscmd=data&format=json'
#bookJson = urllib2.urlopen(bookUrl).read()

def extendInfo(book):
	isbn13 = str(book['isbn13'])
	bookUrl = 'http://openlibrary.org/api/books?bibkeys=ISBN:'+isbn13+'&jscmd=data&format=json'
	bookJson = urllib2.urlopen(bookUrl).read()
	print isbn13
	try:
		db2 = MySQLdb.connect("localhost","root","mTon!13uv","bazinga" )
		cursor2 = db2.cursor(MySQLdb.cursors.DictCursor)
	except:
		print "Error: Unable to connect to MySQL server"

	try:
		openLibrary = json.loads(bookJson)['ISBN:'+isbn13]
	except:
		return book
	#print openLibrary

	try:
		book['subjects'] = []
		for subject in openLibrary['subjects']:
			book['subjects'].append({'name':subject['name']})
			addCategory = "INSERT INTO categories (isbn, category) VALUES ('"+book['isbn']+"', '"+subject['name']+"')"
			cursor2.execute(addCategory)
			#print subject['name']
	except:
		pass

	db2.commit()
	return book


# create json file for every category
try:
	db = MySQLdb.connect("localhost","root","mTon!13uv","bazinga" )
except:
	print "Error: Unable to connect to MySQL server"

cursor = db.cursor(MySQLdb.cursors.DictCursor)
sql = "SELECT * FROM categories"
try:
	cursor.execute(sql)
	results = cursor.fetchall()
except:
	print "Error: unable to fetch books from database"

categories = {}
for instance in results:
	try:
		categories[instance['category']].append(instance['isbn'])
	except:
		categories[instance['category']] = []
		categories[instance['category']].append(instance['isbn'])

# disconnect from server
db.close()

for category in categories.keys():
	jsonfile = open(os.path.abspath(os.curdir)+'/json/category/'+category.replace(' ','_'), 'w')
	jsonfile.write(json.dumps(categories[category], sort_keys=True, indent=4))
	jsonfile.close

print category

