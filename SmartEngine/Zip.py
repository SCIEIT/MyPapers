# -*- coding: UTF-8 -*-
import MySQLdb
import re
import sys
import zipfile
import os
from cStringIO import StringIO
from multiprocessing.dummy import Pool as ThreadPool
import multiprocessing

class mysql:
    def connect(self):
        self.conn = MySQLdb.connect(host='localhost', user='sciecxnk_scieit', passwd='scieit123',
                                    db='sciecxnk_mypapers', port=3306, charset='utf8')
        self.cur = self.conn.cursor()

    def close(self):
        self.cur.close()
        self.conn.close()

    def sql(self, string):
        try:
            self.cur.execute(string)
            self.conn.commit()
        except MySQLdb.Error, e:
            print "Mysql Error %d: %s" % (e.args[0], e.args[1])

    def getAll(self, string):
        self.sql(string)
        return self.cur.fetchall()

class Zip:
    def run(self,newlist):
        print('compressing...')
        db=mysql()
        db.connect()
        arr=[]
        pool = ThreadPool(multiprocessing.cpu_count())
        for subject in newlist:
            arr.append([subject,[x[0] for x in db.getAll("SELECT paper_name FROM papers WHERE subject_code=\""+subject+"\"")]])
        pool.map(self.compress, arr)
        pool.close()
        pool.join()
    def compress(self,arr):
        subject=arr[0]
        paperarr=arr[1]
        zfile=zipfile.ZipFile('../Papers_DIR/packed/'+subject+'tmp.zip','w',zipfile.ZIP_DEFLATED)
        for paper in paperarr:
            zfile.write('../Papers_DIR/unpacked/'+paper,paper)
        zfile.close()
        try:
            os.remove('../Papers_DIR/packed/'+subject+'.zip')
        except:
            pass
        os.rename('../Papers_DIR/packed/'+subject+'tmp.zip','../Papers_DIR/packed/'+subject+'.zip')