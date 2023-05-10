from flask_mysqldb import MySQL
import MySQLdb.cursors
from flask import Flask

app = Flask(__name__)
# buat koneksi Mysql
app.config['MYSQL_HOST'] = 'localhost'
# MySQL username
app.config['MYSQL_USER'] = 'root'
# MySQL password here in my case password is null so i left empty
app.config['MYSQL_PASSWORD'] = ''
# Database name In my case database name is projectreporting
app.config['MYSQL_DB'] = 'jalan_toll'
mysql = MySQL(app)