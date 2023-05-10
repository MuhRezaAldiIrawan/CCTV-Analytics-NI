from config.connection import *

class getdata(object):
    def __init__(self):
        self.cursor = mysql.connection.cursor()

    def getAlldata(self):
        self.cursor.execute("SELECT * FROM data_pelanggaran ORDER BY id DESC LIMIT 5")
        res = self.cursor.fetchall()
        return res