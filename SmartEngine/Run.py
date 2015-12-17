# -*- coding: UTF-8 -*-
import Reader
import Zip
if __name__ == '__main__':
    reader=Reader.Reader()
    (errarr,undifinedlist,newlist)=reader.run()
    if len(newlist)>0:
        compresser=Zip.Zip()
        compresser.run(newlist)