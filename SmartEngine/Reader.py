# -*- coding: UTF-8 -*-
import MySQLdb
import re
import sys
import zipfile
import os

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

class Reader:
    def run(self):
        print('Reading...')
        db=mysql()
        db.connect()
        undifinedlist=[]
        errarr=[]
        subjectlist=[x[0] for x in db.getAll("SELECT subject_code FROM subjects")]
        paperlist=[x[0] for x in db.getAll("SELECT paper_name FROM papers")]
        filelist=self.getFileList("../Papers_DIR/unpacked")
        newlist=[]
        for paper in filelist:
            jump=True
            try:
                paperlist.index(paper)
            except:
                jump=False
            if jump:
                continue
            m = re.findall('(?:\D|^)(\d{4})(?=\D)', paper)
            code=False
            for i in m:
                if not i[0:2]=='20' and len(i)==4:
                    code=i
            if not m or len(m)==0 or not code:
                errarr.append(paper)
                print("fail to read"+paper)
                continue
            try:
                newlist.index(code)
            except:
                newlist.append(code)
            try:
                subjectlist.index(code)
            except:
                try:
                    undifinedlist.index(code)
                except:
                    undifinedlist.append(code)
            date=re.findall("([SsWw]\d{2})", paper)
            if len(date)==0:
                year=''
                month=''
            else:
                date=date[0]
                year=date[1:]
                month=date[0]
            Type=re.findall("([a-zA-Z]{2}_[\d+]+)",paper)
            if len(Type)>0:
                num=Type[0].split('_')[1]
                Type=Type[0].split('_')[0]
            else:
                Type=re.findall("([a-zA-Z]{2})",paper)[0]
                num=''
            db.sql("INSERT INTO `papers`(`paper_name`, `subject_code`, `paper_year`, `paper_month`, `paper_type`, `paper_num`) VALUES (\""+paper+"\",\""+code+"\",\""+year+"\",\""+month+"\",\""+Type+"\",\""+num+"\")")
        db.close()
        return errarr,undifinedlist,newlist
    def addField(self,fieldlist):
        db=mysql()
        db.connect()
        for subject in fieldlist:
            if int(subject[0])>4:
                grade='1'
            else:
                grade='0'
            db.sql("INSERT INTO `subjects`(`subject_code`, `subject_grade`, `subject_name`) VALUES (\""+subject+"\",\""+grade+"\",\"UNDIFINED\")")
        db.close()
    def getFileList(self,p ):
        p = str( p )
        if p=="":
              return [ ]
        #p = p.replace( "/","\\")
        if p[ -1] != "/":
             p = p+"/"
        a = os.listdir( p )
        b = [ x   for x in a if os.path.isfile( p + x ) ]
        return b
