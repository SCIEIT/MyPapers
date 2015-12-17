# -*- coding: UTF-8 -*-
import Reader
import Zip
if __name__ == '__main__':
    reader=Reader.Reader()
    (errarr,undifinedlist,newlist)=reader.run()
    if(len(undifinedlist)>0):
        reader.addField(undifinedlist)
    if len(newlist)>0:
        compresser=Zip.Zip()
        compresser.run(newlist)