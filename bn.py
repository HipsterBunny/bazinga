#!/usr/bin/python

import urllib2
from urllib import urlretrieve
import os
import sys
import re
import string
from BeautifulSoup import BeautifulSoup
import urlparse
import MySQLdb
tocrawl = set([sys.argv[1]])
crawled = set([])
booklinks = set([])
keywordregex = re.compile('<meta\sname=["\']keywords["\']\scontent=["\'](.*?)["\']\s/>')
linkregex = re.compile('<a\s*href=[\'|"](.*?)[\'"].*?>')


def fetch_book(bookUrl):
	book = {}
	img_folder=os.path.abspath(os.curdir)+"/covers/"
	try:
		soup = BeautifulSoup(urllib2.urlopen(bookUrl).read())
	except:
		return
	if len(soup.findAll(attrs={'property':"og:type",'content':"book"})) != 1:
		return

	try:
		book['title'] =  soup.findAll(attrs={"itemprop" : "name"})[0].text.replace('\n','').replace('\r','').replace('\t','')
	except:
		return
	book['type'] = soup.find("div", { "class" : "product-pod wgt-product-core" }).h2.text
	try:
		book['description'] =  soup.findAll(attrs={"itemprop" : "description"})[0].text.replace('\n','').replace('\r','').replace('\t','')
		book['rating'] =  soup.findAll(attrs={"itemprop" : "rating"})[0]['content']
		book['author'] = soup.h1.findNextSibling('span').text[2:].replace('\n','').replace('\r','').replace('\t','')
		book['price'] =  soup.findAll(attrs={"itemprop" : "price"})[0].text
		book['listprice'] =  soup.find("div", { "class" : "product-listprice" }).span.text
	except:
		return
	try:
		book['reviewer'] = soup.find("div", { "class" : "review first" }).h4.text
		book['review'] = soup.find("div", { "class" : "review first" }).find("div", { "class" : "full-review" }).text
	except:
		pass
	try:
		image = soup.find("img", {"itemprop":"photo"})
		cover = image["src"].split("/")[-1]
		book['image'] = cover

		outpath = os.path.join(img_folder, cover)
		if image["src"].lower().startswith("http"):
			urlretrieve(image["src"], outpath)
		else:
			urlretrieve(urlparse.urlunparse(parsed), outpath)
	except:
		return

	lis = soup.find("div", { "class" : "w-box wgt-product-details product-pod" }).findAll('li')
	for line in lis:
		#print line.text + '\n'
		if line.text.startswith("Pub. Date: "):
			book['pub_date'] = line.text[11:].replace('\n','').replace('\r','').replace('\t','')
		if line.text.startswith("Publisher: "):
			book['publisher'] = line.text[11:].replace('\n','').replace('\r','').replace('\t','')
		if line.text.startswith("Format: "):
			book['format'] = line.text[8:].replace('\n','').replace('\r','').replace('\t','')
		if line.text.startswith("Age Range: "):
			book['age_range'] = line.text[11:].replace('\n','').replace('\r','').replace('\t','')
		if line.text.startswith("ISBN-13:"):
			book['isbn13'] = line.text[8:].replace('\n','').replace('\r','').replace('\t','')
		if line.text.startswith("ISBN:"):
			book['isbn'] = line.text[5:].replace('\n','').replace('\r','').replace('\t','')
	#print book['reviewer'] + " \n\n " + book['review'] + "\n-------------------\n"
	return book

def save_book(book):
	if book == None:
		return
	# Open database connection
	try:
		db = MySQLdb.connect("localhost","root","mTon!13uv","bazinga" )
	except:
		print "Error: Unable to connect to MySQL server"

	# prepare a cursor object using cursor() method
	cursor = db.cursor()

	# Prepare SQL query to INSERT a record into the database.
	
	columns = "isbn"
	values = '"' + book.pop('isbn') + '"'
	for column in book.keys():
		columns = columns + ', ' + column
		values = values + ', "' + book[column].replace('"','\'') + '"'
	sql = "INSERT INTO books (" + columns + ") VALUES (" + values + ")"
	#print sql

	try:
		#Execute the SQL command
		cursor.execute(sql)
		db.commit()

		#fetch image
		print "added: "+book['title']
	except:
		print "Warning: Duplicate Entry"
		#print sql

	# disconnect from server
	db.close()

def contains(theString, theQueryValue):
  return theString.find(theQueryValue) > -1

#save_book(fetch_book('http://search.barnesandnoble.com/The-Silent-Girl/Tess-Gerritsen/e/9780345515506/'))
#print '\n\n' + title +'\n' + author + '\n'+ isbn +'\n'+ cover +'\n' + format


while len(tocrawl) != 0:
	try:
		crawl = BeautifulSoup(urllib2.urlopen(tocrawl.pop()).read())
	except:
		pass
	for tag in crawl.findAll('a', href=True):
		link = tag['href']
		#print link
		if contains(link,"http://search.barnesandnoble.com") or contains(link,"barnesandnoble.com/w/"):
			if not contains(link,"/booksearch/results.asp?"):
				if link not in booklinks:
					print ".....scrubbing: "+link
					save_book(fetch_book(link))
					booklinks.add(link)
		#elif contains(link,"barnesandnoble.com/u/") and link not in crawled:
		#	crawled.add(link)
		#	tocrawl.add(link)
		elif  contains(link,"browse.barnesandnoble.com/browse/nav.asp") and link not in crawled:
			crawled.add(link)
			tocrawl.add(link)

