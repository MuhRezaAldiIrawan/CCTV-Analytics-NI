from importlib import import_module
import os
import subprocess as sp
from pickle import TRUE
from unittest import result
from urllib import response
from flask import Flask, render_template, Response, jsonify, url_for
import time
from config.getData import getdata
from flask_mysqldb import MySQL
import MySQLdb.cursors
from cctv1 import *
from cctv2 import * 
from cctv3 import *
from cctv4 import *
from cctv5 import *
# from cctv6 import *
import argparse
from datetime import datetime
# from config.getData import *
# from config.connection import mysql

# firebase
# import pyrebase
# config = {
#     "apiKey": "AIzaSyDQQWt7aehDJmvkvn9YnFxAERrzWbvupqQ",
#     "authDomain": "cctv-e9876.firebaseapp.com",
#     "databaseURL": "https://cctv-e9876-default-rtdb.asia-southeast1.firebasedatabase.app",
#     "projectId": "cctv-e9876",
#     "storageBucket": "cctv-e9876.appspot.com",
#     "messagingSenderId": "721812131041",
#     "appId": "1:721812131041:web:bd73d4855c19b64f807ba0",
#     "measurementId": "G-B7C9X1VH7D"
# }
# firebase = pyrebase.initialize_app(config)

# db = firebase.database()

#sql
app = Flask(__name__)
# buat koneksi Mysql
app.config['MYSQL_HOST'] = '192.168.0.66'
# MySQL username
app.config['MYSQL_USER'] = 'admin'
# MySQL password here in my case password is null so i left empty
app.config['MYSQL_PASSWORD'] = 'a1b2c3d4'
# Database name In my case database name is projectreporting
app.config['MYSQL_DB'] = 'jalan_toll'
mysql = MySQL(app)


@app.route('/', methods=['GET', 'POST'])
def index():
    """Video streaming home page."""
    # cur = mysql.connection.cursor()
    # cur.execute('''SELECT * FROM data_pelanggaran ORDER BY id DESC LIMIT 5 ''')
    # rv = cur.fetchall()
    return render_template("index2.html")
@app.route('/getdata', methods=['GET'])
def query():
    cur = mysql.connection.cursor()
    cur.execute('''SELECT * FROM data_pelanggaran ORDER BY id DESC LIMIT  5''')
    data = cur.fetchall()
    plg = []
    for row in data:
        plg.append({
            'jp' : row[1],  
            'time' : row[2],
            'gambar':row[3],
            'lokasi':row[4],
            'dir':row[5]
        })
    if len(plg):
        response = jsonify({
            "result" : plg,
            "status" : 200,
        })
    else:
        response = jsonify({
            "result" :[],
            "status" : 400,
        })
    return response
@app.route('/getjumlah', methods=['GET'])
def getjumlah():
    cur = mysql.connection.cursor()
    cur.execute('''SELECT * FROM data_pelanggaran ''')
    hasil = cur.rowcount
    return jsonify({'jumlah':hasil})
@app.route('/data_pelanggaran', methods=['GET', 'POST'])
def data_pelanggaran():
    out = sp.run(["php", "templates/index.php"], stdout=sp.PIPE)
    return out.stdout
@app.route('/data_traffic', methods=['GET', 'POST'])
def data_traffic():
    # Untuk menjalankan file php
    out = sp.run(["php", "templates/data_traffic.php"], stdout=sp.PIPE)
    return out.stdout
@app.route('/maps', methods=['GET', 'POST'])
def maps():
    # Untuk menjalankan file php
    out = sp.run(["php", "templates/maps.php"],  shell=True, stdout=sp.PIPE)
    return out.stdout
@app.route('/detail_data', methods=['GET', 'POST'])
def detail_data():

    # Untuk menjalankan file php
    out = sp.run(["php", "templates/detail_pelanggaran.php"], stdout=sp.PIPE)
    return out.stdout
    
    
@app.route('/video_feed5')
def video_feed5():
    """Video streaming route. Put this in the src attribute of an img tag."""
    return Response(gen(opt),
                    mimetype='multipart/x-mixed-replace; boundary=frame')
@app.route('/video_feed1')
def video_feed1():
    """Video streaming route. Put this in the src attribute of an img tag."""
    return Response(gen1(opt),
                    mimetype='multipart/x-mixed-replace; boundary=frame')
    


if __name__ == "__main__":
    parser = argparse.ArgumentParser()
    parser.add_argument('--yolo_model', nargs='+', type=str,
                        default='yolov5s.pt', help='model.pt path(s)')
    parser.add_argument('--deep_sort_model', type=str, default='osnet_x0_25')
    parser.add_argument('--source', type=str, default='rtsp://admin:admin123@192.168.1.127:554/live4.sdp', help='source')# file/folder, 0 for webcam
    parser.add_argument('--source1', type=str,
                        default='rtsp://admin:admin123@192.168.3.15:554/live1s2.sdp', help='source')
    parser.add_argument('--source2', type=str,
                        default='rtsp://admin:admin123@192.168.22.8:554/live1s3.sdp', help='source')
    parser.add_argument('--source3', type=str,
                        default='rtsp://admin:admin123@192.168.3.19:554/live1s2.sdp', help='source')
    parser.add_argument('--output', type=str, default='inference/output',
                        help='output folder')  # output folder
    parser.add_argument('--imgsz', '--img', '--img-size', nargs='+',
                        type=int, default=[480], help='inference size h,w')
    parser.add_argument('--conf-thres', type=float,
                        default=0.5, help='object confidence threshold')
    parser.add_argument('--iou-thres', type=float,
                        default=0.5, help='IOU threshold for NMS')
    parser.add_argument('--fourcc', type=str, default='mp4v',
                        help='output video codec (verify ffmpeg support)')
    parser.add_argument('--device', default='',
                        help='cuda device, i.e. 0 or 0,1,2,3 or cpu')
    parser.add_argument('--show_vid', action='store_false',
                        help='display tracking video results')
    parser.add_argument('--save_vid', action='store_true',
                        help='save video tracking results')
    parser.add_argument('--save_txt', action='store_true',
                        help='save MOT compliant results to *.txt')
    # class 0 is person, 1 is bycicle, 2 is car... 79 is oven
    parser.add_argument('--classes', nargs='+', type=int,
                        help='filter by class: --class 0, or --class 16 17')
    parser.add_argument('--agnostic-nms', action='store_true',
                        help='class-agnostic NMS')
    parser.add_argument('--augment', action='store_true',
                        help='augmented inference')
    parser.add_argument('--evaluate', action='store_true',
                        help='augmented inference')
    parser.add_argument("--config_deepsort", type=str,
                        default="deep_sort/configs/deep_sort.yaml")
    parser.add_argument("--half", action="store_true",
                        help="use FP16 half-precision inference")
    parser.add_argument('--visualize', action='store_true',
                        help='visualize features')
    parser.add_argument('--max-det', type=int, default=1000,
                        help='maximum detection per image')
    parser.add_argument('--dnn', action='store_true',
                        help='use OpenCV DNN for ONNX inference')
    parser.add_argument('--project', default=ROOT /
                        'static/counting000', help='save results to project/name')
    parser.add_argument('--name', default='cctv',
                        help='save results to project/name')
    parser.add_argument('--exist-ok', action='store_true',
                        help='existing project/name ok, do not increment')
    opt = parser.parse_args()
    opt.imgsz *= 2 if len(opt.imgsz) == 1 else 1  # expand
    app.run(host='0.0.0.0', threaded=True, port=5000, debug=TRUE)
