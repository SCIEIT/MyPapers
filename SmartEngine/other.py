# -*- coding: UTF-8 -*-
import MySQLdb
import re
import sys
import zipfile
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

    def escape(self, string):
        string = MySQLdb.escape_string(standardise(string).decode('gbk').encode('utf-8'))
        return string


def printResult(pnum, qnum, string, pos):
    print('\n=====================================================\n')
    print('Page: ' + str(pnum) + '   Question: ' + str(qnum) + '\n')
    print('Position Found: ' + str(pos) + ':\n')
    print(string[pos:pos + 20])
    print('\n-----------------------------------\n')
    print(standardise(string[pos:]))


def get_num_page(path):
    path = open(path, 'rb')
    pdf = PyPDF2.PdfFileReader(path)
    return pdf.getNumPages()


def convert_pdf_to_txt(path, page=set()):
    rsrcmgr = PDFResourceManager()
    retstr = StringIO()
    codec = 'gbk'
    laparams = LAParams()
    device = TextConverter(rsrcmgr, retstr, codec=codec, laparams=laparams)
    fp = file(path, 'rb')
    interpreter = PDFPageInterpreter(rsrcmgr, device)
    password = ""
    maxpages = 0
    caching = True
    pagenos = page
    pages = PDFPage.get_pages(fp, pagenos, maxpages=maxpages, password=password, caching=caching,
                              check_extractable=True)
    for page in pages:
        interpreter.process_page(page)
    fp.close()
    device.close()
    string = retstr.getvalue()
    retstr.close()
    return string


def standardise(string):
    resultSTR = re.sub('For\s+Examiner.*\s+Use', '', string)
    resultSTR = re.sub('\[Turn\s+over', '', string)
    resultSTR = re.sub('UCLES\s+[12]\d{2,3}', '', resultSTR)
    resultSTR = re.sub('\d{4}/\d{2}/[OM]/[NJ]/\d{2}', '', resultSTR)
    resultSTR = re.sub('[\n\r]+', '\n', resultSTR)
    resultSTR = re.sub('[ ]+', ' ', resultSTR)
    resultSTR = re.sub('\s{2,}', '\n', resultSTR)
    # resultSTR=re.sub('[~!@#$%\^\+\*&\\\/\|:{}()\'"]','',resultSTR)
    return resultSTR


def fixArr(array, path, offset, qnum):
    a = 0
    while a < len(array):
        i = array[a]
        string = convert_pdf_to_txt(path, [i[0]])
        string = re.sub('(^|([\r\n]+[\s]*))' + str(i[0] + 1 + offset), '', string, 1)
        position = len(re.findall('(?:(?:[\r\n]+[\s]*)|^)(\d+)(?=\s+[\D])', string[:i[1]]))
        arr = re.findall('(?:(?:[\r\n]+[\s]*)|^)(\d+)(?=\s+[\D])', string)
        nearestArr = []
        fnear = ''
        bnear = ''
        if i[3]:
            if a == 0:
                fnear = string[:i[1]]
                bnear = string[i[1]:]
            elif i[1] == 0:
                # nearSTR==re.sub('(^|([\r\n]+[\s]*))'+str(i[0]+offset), '', convert_pdf_to_txt(path,[i[0]-1]),1)[-20:]
                # nearSTR=nearSTR+string[:min([i[1]+20,len(string)])]
                fnear = re.sub('(^|([\r\n]+[\s]*))' + str(i[0] + offset), '', convert_pdf_to_txt(path, [i[0] - 1]), 1)
                bnear = string
            else:
                # nearSTR=string[max([0,i[1]-20]):min([i[1]+20,len(string)])]
                fnear = string[:i[1]]
                bnear = string[i[1]:]
            fnear = re.sub('[a-zA-Z]+', 'a', re.sub('\s+', '\n', fnear))[max(-10, -len(fnear)):]
            bnear = re.sub('[a-zA-z]+', 'a', re.sub('\s+', '\n', bnear))[:min(10, len(bnear))]
            nearestArr = re.findall('(?:(?:[\r\n]+[\s]*)|^)(\d{1,4})(?=\s+)', fnear + bnear)
            nearestPos = len(re.findall('(?:(?:[\r\n]+[\s]*)|^)(\d{1,4})(?=\s+)', fnear))
        strlen=string.rfind(arr[-1])-string.find(arr[0])
        j0 = int(arr[0])
        tmp = [arr[0]]
        p = 0
        modified = False
        for j in range(1, len(arr)):
            if int(arr[j]) - j0 == 1:
                j0 = int(arr[j])
                tmp.append(arr[j])
            else:
                j0 = int(arr[j])
                tmp = [arr[j]]
                p = j
            if j >= position and len(tmp) - 1 > j - position and p <= position and len(tmp) >= max(5,math.ceil(10*strlen/len(string))):
                # if arr.index(array[2])<=i[2]:
                if not i[3]:
                    del array[a]
                    qnum = qnum - 1
                    a = a - 1
                else:
                    array[a] = i[3]
                modified = True
                break
        if i[3] and not modified:
            if len(nearestArr) >= 3 and nearestPos >= 1:
                array[a] = i[3]
                break
        a = a + 1
    return array, qnum


def learnArr(array, path, offset, qnum):
    arr0 = array[0]
    global diff
    for i in range(1, len(array)):
        arr = array[i]
        if arr0[0] == arr[0] and abs(arr0[1] - arr[1]) <= diff:
            (array, qnum) = fixArr(array, path, offset, qnum)
            break
        arr0 = arr
    return array, qnum


def reader(path, instructionpage=0, offset=0):
    quesarr = []
    pnum = instructionpage + 1
    qnum = 1
    pos = 0
    jump = False
    changeJump = False
    p0 = []
    while (pnum < get_num_page(path)-1):
        string = convert_pdf_to_txt(path, [pnum])
        string = re.sub('(([\r\n]+[\s]*)|(^))' + str(pnum + 1 - offset) + '(?=\s+[\D])', '', string, 1)
        TMPpos = pos
        TMP = re.search('(([\r\n]+[\s]*)|(^))' + str(qnum) + '(?=\s+[\D])', string[TMPpos:])
        if qnum > 1 and not jump:
            temp = re.search('(([\r\n]+[\s]*)|(^))' + str(qnum - 1) + '(?=\s+[\D])', string[TMPpos:])
            if temp:
                if not TMP:
                    qnum = qnum - 1
                    # print('jump back')
                    # print(string)
                    p0 = quesarr[qnum - 1]
                    del quesarr[qnum - 1]
                    jump = True
                    continue
                if string[TMPpos:].find(temp.group(0)) < string[TMPpos:].find(TMP.group(0)):
                    qnum = qnum - 1
                    # print('jump back')
                    # print(string)
                    p0 = quesarr[qnum - 1]
                    del quesarr[qnum - 1]
                    jump = True
                    continue
        else:
            changeJump = True
        if TMP:
            qTMP = TMP.group(0)
            exclude = re.search('\s+', qTMP)
            if exclude:
                TMPlen = len(exclude.group(0))
            else:
                TMPlen = 0
            qPosTMP = string[TMPpos:].find(qTMP) + TMPlen + TMPpos
            pos = qPosTMP + len(str(qnum))
            qnum = qnum + 1
            if jump:
                quesarr.append([pnum, qPosTMP, qnum - 1, p0])
            else:
                quesarr.append([pnum, qPosTMP, qnum - 1, False])
            quesarr, qnum = learnArr(quesarr, path, offset, qnum)
            # if(string[qPosTMP:qPosTMP+len(str(qnum))]==str(qnum)):
            #     print(qnum)
            # printResult(pnum,qnum-1,string,pos)
        else:
            pnum = pnum + 1
            pos = 0
                # qPos=re.search(str(qnum),str[numPos+len(pnum):])
        if changeJump:
            quesarr, qnum = fixArr(quesarr, path, offset, qnum)
            jump = False
            changeJump = False
    return quesarr


def readOne(path, instructionpage=0, offset=0):
    print('\n\nREADING' + path + ':...................................................')
    result = reader(path, instructionpage, offset)
    page = result[0][0]
    arr = []
    print(str(len(result)) + ' fond in ' + path + '  Processing...')
    for i in range(0, len(result)):
        SET = result[i]
        string = ''
        if i == len(result) - 1:
            string = ''.join([convert_pdf_to_txt(path, [x])[SET[1]:] for x in range(SET[0], get_num_page(path))])
        elif result[i + 1][0] == SET[0]:
            string = re.sub('(([\r\n]+[\s]*)|(^))' + str(SET[0]+1 - offset) + '(?=\s+[\D])', '', convert_pdf_to_txt(path, [SET[0]]), 1)[SET[1]:result[i + 1][1]]
        else:
            string = re.sub('(([\r\n]+[\s]*)|(^))' + str(SET[0]+1 - offset) + '(?=\s+[\D])', '', convert_pdf_to_txt(path, [SET[0]]), 1)[SET[1]:]
            for a in range(SET[0] + 1, result[i + 1][0]):
                string = string + convert_pdf_to_txt(path, [a])
            string = string + convert_pdf_to_txt(path, [result[i + 1][0]])[:result[i + 1][1]]
        standardString = standardise(string)
        arr.append(standardString)
    return arr


# './0420_s06_qp_1.pdf'
# print(convert_pdf_to_txt('./0460_s04_qp_2.pdf',[6]))
# print(re.search('(([\r\n]+[\s]*)|(^))40(?=\s+[\D])',string).group(0))
# readOne('./0460_s04_qp_2.pdf')

def identifyoffset(path):
    pnum = 0
    while (pnum < get_num_page(path)):
        string = convert_pdf_to_txt(path, [pnum])
        TMP = re.search('READ.+THESE.+INSTRUCTIONS.+FIRST', string)
        if TMP:
            return pnum, pnum
        pnum += 1
    return False


def paperReader(path, ms):
    if not ms:
        return convert_pdf_to_txt(path, [i for i in range(0, get_num_page(path) - 1)])
    else:
        return convert_pdf_to_txt(path, [i for i in range(0, get_num_page(path))])


def update(arr):
    global count
    global total
    path = arr[0]
    id = arr[1]
    ms = arr[2]
    print 'READING:' + path
    db = mysql()
    db.connect()
    try:
        db.sql("UPDATE papers SET paper_content='" + db.escape(paperReader(path, ms)) + "' WHERE paper_id =\"" + str(
            id) + "\"")
    except:
        print 'Error:' + path
        errArr.append(path)
        return False
    db.close()
    print 'Done:' + path
    print str(round(float(count) * 100.00 / float(total), 2)) + '% Finished'
    count = count + 1


def sreader(arr):
    global count
    global total
    try:
        path = arr[0]
        id = arr[1]
    except:
        print 'value Error'
    try:
        instructionpage, offset = identifyoffset(path)
    except:
        print 'FAIL to read:' + path
        errArr.append(path)
        return
    print('READING' + path + ':...................................................')
    result = reader(path, instructionpage, offset)
    arr = []
    print(str(len(result)) + ' fond in ' + path + '  Processing...')
    for i in range(0, len(result)):
        SET = result[i]
        string = ''
        if i == len(result) - 1:
            string = ''.join([convert_pdf_to_txt(path, [x])[SET[1]:] for x in range(SET[0], get_num_page(path))])
        elif result[i + 1][0] == SET[0]:
            string = convert_pdf_to_txt(path, [SET[0]])[SET[1]:result[i + 1][1]]
        else:
            string = convert_pdf_to_txt(path, [SET[0]])[SET[1]:]
            for a in range(SET[0] + 1, result[i + 1][0]):
                string = string + convert_pdf_to_txt(path, [a])
            string = string + convert_pdf_to_txt(path, [result[i + 1][0]])[:result[i + 1][1]]
        standardString = standardise(string)
        arr.append(standardString)
    result=arr
    db = mysql()
    db.connect()
    for i in range(0, len(result) - 1):
        try:
            db.sql("insert INTO questions (paper_id,question_content,question_num) VALUES (\"" + str(id) + "\",\"" +db.escape(result[i]) + "\",\"" + str(i + 1) + "\")")
        except:
            print 'Error:' + path + str(i)
            i = i - 1
    db.close()
    print 'Done:' + path
    print str(round(float(count) * 100.00 / float(total), 2)) + '% Finished'
    count = count + 1


def paperIterater(folderPath):
    global total
    db = mysql()
    db.connect()
    result = db.getAll("select * from papers where paper_type='qp' or paper_type='ms'")
    db.close()
    pool = ThreadPool(8)
    # pool=multiprocessing.Pool(8)
    arr = []
    total = len(result)
    for i in result:
        id = i[0]
        name = i[1]
        if i[5] == 'qp':
            ms = False
        else:
            ms = True
        path = folderPath + '/' + name
        arr.append((path, id, ms))
        # pool.apply_async(update,(id,name,))
    pool.map(update, arr)
    pool.close()
    pool.join()
    # length=len(result)
    # print(arr)
    # for res in arr:
    #     print str(round(count*100/length,2))+'% Finished'
    #     res.get()
    #     count=count+1
    print "Sub-process(es) done."


def paperRefresher(folderPath):
    global total
    db = mysql()
    db.connect()
    result = db.getAll("select * from papers where (paper_type='qp' or paper_type='ms') AND paper_content=''")
    db.close()
    pool = ThreadPool(8)
    # pool=multiprocessing.Pool(8)
    arr = []
    total = len(result)
    for i in result:
        id = i[0]
        name = i[1]
        if i[5] == 'qp':
            ms = False
        else:
            ms = True
        path = folderPath + '/' + name
        arr.append((path, id, ms))
        # pool.apply_async(update,(id,name,))
    pool.map(update, arr)
    pool.close()
    pool.join()
    # length=len(result)
    # print(arr)
    # for res in arr:
    #     print str(round(count*100/length,2))+'% Finished'
    #     res.get()
    #     count=count+1
    print "Sub-process(es) done."


def questionReader(folderPath):
    global total
    db = mysql()
    db.connect()
    result = db.getAll("select paper_id, paper_name from papers where paper_type='qp'")
    db.close()
    pool = ThreadPool(8)
    #pool=multiprocessing.Pool(8)
    arr = []
    total = len(result)
    print total
    for i in result:
        id = i[0]
        name = i[1]
        path = folderPath + '/' + name
        tmp=[path, id]
        arr.append(tmp)
        # pool.apply_async(sreader,[path, id])'
    pool.map(sreader, arr)
    pool.close()
    pool.join()
    # length=len(result)
    # print(arr)
    # for res in arr:
    #     print str(round(count*100/length,2))+'% Finished'
    #     res.get()
    #     count=count+1
    print "Sub-process(es) done."

def questionRefresher(folderPath):
    global total
    db = mysql()
    db.connect()
    result = db.getAll("select papers.paper_id, paper_name from papers LEFT JOIN questions ON papers.paper_id=questions.paper_id where papers.paper_type='qp' and questions.question_id is NULL")
    db.close()
    pool = ThreadPool(8)
    #pool=multiprocessing.Pool(8)
    arr = []
    total = len(result)
    print total
    for i in result:
        id = i[0]
        name = i[1]
        path = folderPath + '/' + name
        tmp=[path, id]
        arr.append(tmp)
        # pool.apply_async(sreader,[path, id])'
    pool.map(sreader, arr)
    pool.close()
    pool.join()
    # length=len(result)
    # print(arr)
    # for res in arr:
    #     print str(round(count*100/length,2))+'% Finished'
    #     res.get()
    #     count=count+1
    print "Sub-process(es) done."


if __name__ == '__main__':
    errArr = []
    count = 1
    # paperIterater('./pdf')
    # paperRefresher('./pdf')
    questionRefresher('./pdf')
    print(errArr)
    # string=paperReader('./pdf/0400_w07_ms_4.pdf')
    # db=mysql()
    # print(db.escape(string))
# pool=multiprocessing.Pool(multiprocessing.cpu_count())
# arr=[]
# print pool.map(convert_pdf_to_txt,range(0,get_num_page('./pdf/0460_s04_qp_2.pdf')))
# for i in range(0,get_num_page('./pdf/0460_s04_qp_2.pdf')):
#     arr.append(pool.apply_async(convert_pdf_to_txt,('./pdf/0460_s04_qp_2.pdf',[i])))
# pool.close()
# pool.join()
# sreader(('./pdf/0420_w10_qp_11.pdf',2))

# print(readOne('./pdf/9697_s03_qp_6.pdf'))
