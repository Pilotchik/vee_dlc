#!/usr/local/bin/python
#!/usr/local/bin/python/Lib
# -*- coding: utf-8 -*-

import os
#import MySQLdb

print("Content-type: text/html\n\n")
#%s""" % os.environ
#print(os.environ)
query = os.environ["QUERY_STRING"].split("&")

print(int(query[0].split("=")[1])*2)

try:
    import mysql.connector
except ImportError:
    print("module asdf not available")
else :
    print("module asdf available for loading")

'''
con = mdb.connect(user='root', password='',
                              host='127.0.0.1',
                              database='exam');
cur = con.cursor()
cur.execute("SELECT id,lastname FROM new_persons WHERE id<50")
for (id,lastname) in cur:
    print("<b>"+str(id)+str(lastname)+"<b><br>")
con.close()
'''
