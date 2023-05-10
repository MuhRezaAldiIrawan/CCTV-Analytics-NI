from importlib import import_module
import os
import subprocess as sp
from pickle import TRUE
from unittest import result
from urllib import response
from flask import Flask, render_template, Response, jsonify, url_for, redirect
import time
from config.getData import getdata
from flask_mysqldb import MySQL
import MySQLdb.cursors
# from cctv1 import *
from cctv2 import *
# from cctv3 import *
from cctv4 import *
from cctv5 import *
# from cctv6 import *
from cctv7 import *
from test_melawan_arus import *
# from cctv_gerbang import *
# from cctv_GTO5 import *
import argparse
from datetime import datetime

# # firebase
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
t2 = int(datetime.now().second) + 5

#sql
app = Flask(__name__)
# buat koneksi Mysql
app.config['MYSQL_HOST'] = 'localhost'
# MySQL username
app.config['MYSQL_USER'] = 'root'
# MySQL password here in my case password is null so i left empty
app.config['MYSQL_PASSWORD'] = ''
# Database name In my case database name is projectreporting
app.config['MYSQL_DB'] = 'web_mks'
mysql = MySQL(app)

try:
    @app.route('/', methods=['GET', 'POST'])
    def index():
        """Video streaming home page."""
        # cur = mysql.connection.cursor()
        # cur.execute('''SELECT * FROM data_pelanggaran ORDER BY id DESC LIMIT 5 ''')
        # rv = cur.fetchall()
        # rv =  db.child("Pelanggaran").get()
        return render_template("content.html")

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
        # proc = sp.Popen("php templates/maps.php", shell=True, stdout=sp.PIPE)
        # script_response = proc.stdout.read()
        # return script_response
        out = sp.run(['php', 'templates/maps.php'], stdout=sp.PIPE)
        return out.stdout

    @app.route('/detail_data', methods=['GET', 'POST'])
    def detail_data():
        # Untuk menjalankan file php
        out = sp.run(["php", "templates/detail_pelanggaran.php"], stdout=sp.PIPE)
        return out.stdout

    @app.route('/video_feed')
    def video_feed():
        """Video streaming route. Put this in the src attribute of an img tag."""
        with torch.no_grad():
            return Response(gen(opt),
                            mimetype='multipart/x-mixed-replace; boundary=frame')

    @app.route('/video_feed1')
    def video_feed1():
        """Video streaming route. Put this in the src attribute of an img tag."""
        with torch.no_grad():
            return Response(gen1(opt),
                        mimetype='multipart/x-mixed-replace; boundary=frame')

    # @app.route('/video_feed2')
    # def video_feed2():
    #     """Video streaming route. Put this in the src attribute of an img tag."""
    #     with torch.no_grad():
    #         return Response(gen2(opt),
    #                     mimetype='multipart/x-mixed-replace; boundary=frame')

    @app.route('/video_feed3')
    def video_feed3():
        """Video streaming route. Put this in the src attribute of an img tag."""
        with torch.no_grad():
            return Response(current(opt),
                        mimetype='multipart/x-mixed-replace; boundary=frame')
    @app.route('/video_feed4')
    def video_feed4():
        """Video streaming route. Put this in the src attribute of an img tag."""
        with torch.no_grad():
            return Response(gen3(opt),
                        mimetype='multipart/x-mixed-replace; boundary=frame')
    # @app.route('/video_feed5')
    # def video_feed5():
    #     """Video streaming route. Put this in the src attribute of an img tag."""
    #     with torch.no_grad():
    #         return Response(detect1(opt),
    #                     mimetype='multipart/x-mixed-replace; boundary=frame')
except:
    pass
    
# @app.route('/video_feed4')
# def video_feed4():
#     """Video streaming route. Put this in the src attribute of an img tag."""
#     with torch.no_grad():
#         return Response(detect(opt),
#                     mimetype='multipart/x-mixed-replace; boundary=frame')
        
# @app.route('/video_feed5')
# def video_feed5():
#     """Video streaming route. Put this in the src attribute of an img tag."""
#     with torch.no_grad():
#         return Response(gerbang(opt),
#                     mimetype='multipart/x-mixed-replace; boundary=frame')
    
# @app.route('/video_feed5')
# def video_feed5():
#     """Video streaming route. Put this in the src attribute of an img tag."""
#     return Response(trackMultipleObjects(),
#                     mimetype='multipart/x-mixed-replace; boundary=frame')


if __name__ == "__main__":
    parser = argparse.ArgumentParser()
    parser.add_argument('--yolo_model', nargs='+', type=str,
                        default='yolov5s.pt', help='model.pt path(s)')
    parser.add_argument('--yolo_model2', nargs='+', type=str,
                        default='yolov5s.pt', help='model.pt path(s)')
    parser.add_argument('--deep_sort_model', type=str, default='osnet_x0_25')
    # parser.add_argument('--source', type=str, default='rtsp://admin:admin123@192.168.1.127:554/live4.sdp', help='source')
    # file/folder, 0 for webcam
    parser.add_argument('--source1', type=str,
                        default='rtsp://admin:admin123@192.168.3.15:554/live1s2.sdp', help='source')
    parser.add_argument('--source2', type=str,
                        default='rtsp://admin:admin123@192.168.22.8:554/live1s3.sdp', help='source')
    parser.add_argument('--source3', type=str,
                        default='rtsp://admin:admin123@192.168.3.19:554/live1s2.sdp', help='source')
    parser.add_argument('--source4', type=str,
                        default='rtsp://admin:admin123@192.168.3.24:554/live1s2.sdp', help='source')
    parser.add_argument('--source5', type=str,
                        default='rtsp://admin:admin123@192.168.3.22:554/live1s2.sdp', help='source')
    
    parser.add_argument('--source6', type=str,
                        default='rtsp://admin:admin123@192.168.22.12/live1s3.sdp', help='source')
    parser.add_argument('--source7', type=str,
                        default='rtsp://admin:admin123@192.168.22.13:554/live1s3.sdp', help='source')
    parser.add_argument('--output', type=str, default='inference/output',
                        help='output folder')  # output folder
    parser.add_argument('--imgsz', '--img', '--img-size', nargs='+',
                        type=int, default=[480], help='inference size h,w')
    parser.add_argument('--conf-thres', type=float,
                        default=0.56, help='object confidence threshold')
    parser.add_argument('--iou-thres', type=float,
                        default=0.56, help='IOU threshold for NMS')
    # parser.add_argument('--conf-thres2', type=float,
    #                     default=0.51, help='object confidence threshold')
    # parser.add_argument('--iou-thres2', type=float,
    #                     default=0.51, help='IOU threshold for NMS')
    parser.add_argument('--fourcc', type=str, default='mp4v',
                        help='output video codec (verify ffmpeg support)')
    parser.add_argument('--device', default='cuda',
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

    app.run(host='0.0.0.0', port=5000, debug=TRUE)
