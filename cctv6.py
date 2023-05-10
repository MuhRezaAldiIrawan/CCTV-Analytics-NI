import cv2
import dlib
import time
import threading
import math
import telepot
import mysql.connector
import smtplib
import ssl
from email.message import EmailMessage
import imghdr
from flask import Flask, render_template, Response, flash
from datetime import date, datetime
# Flask

app = Flask(__name__)
mysql = mysql.connector.connect(user='root',
                                password='',
                                host='localhost',
                                database='jalan_toll')
mysqlCursor = mysql.cursor()


token = '5782342813:AAEkQNNXJexUi71sHE_Jkw-kJMHQN8iJFrE' # telegram token
receiver_id = [320851322, 664202412] # https://api.telegram.org/bot<TOKEN>/getUpdates
bot = telepot.Bot(token)

@app.route('/')
def index():
    return render_template("index.html")

def estimateSpeed(location1, location2):
    d_pixels = math.sqrt(math.pow(
        location2[0] - location1[0], 2) + math.pow(location2[1] - location1[1], 2))
    # ppm = location2[2] / carWidht
    ppm = 8.8
    d_meters = d_pixels / ppm
    #print("d_pixels=" + str(d_pixels), "d_meters=" + str(d_meters))
    fps = 8
    speed = d_meters * fps * 3.6
    return speed
def trackMultipleObjects():
    carCascade = cv2.CascadeClassifier('templates/myhaar.xml')
    video = cv2.VideoCapture('rtsp://admin:admin123@192.168.3.12:554/live1s3.sdp')
    # video.set(cv2.CAP_PROP_FPS, 10)   
    WIDTH = 1280
    HEIGHT = 720
    # # buat koneksi Mysql
    
    # # Define email sender and receiver
    # email_sender = 'cctvtollmakassar@gmail.com'  # email pengirim dan password
    # email_password = 'jziydfjhjwcfxzpj'
    # email_receiver = 'taufikwitri@gmail.com'  # email penerima

    rectangleColor = (0, 255, 0)
    frameCounter = 0
    currentCarID = 0
    fps = 0

    carTracker = {}
    carNumbers = {}
    carLocation1 = {}
    carLocation2 = {}
    speed = [None] * 1000

    # Write output to video file
    # out = cv2.VideoWriter('outpy.avi', cv2.VideoWriter_fourcc(
    #     'M', 'J', 'P', 'G'), 10, (WIDTH, HEIGHT))

    while True:
        start_time = time.time()
        rc, image = video.read()
        if type(image) == type(None):
            break
        image = image[60:800,50:800]
        image = cv2.resize(image, (WIDTH, HEIGHT))
        resultImage = image.copy()

        frameCounter = frameCounter + 1

        carIDtoDelete = []

        for carID in carTracker.keys():
            trackingQuality = carTracker[carID].update(image)

            if trackingQuality < 7:
                carIDtoDelete.append(carID)

        for carID in carIDtoDelete:
            # print('Removing carID ' + str(carID) + ' from list of trackers.')
            # print('Removing carID ' + str(carID) + ' previous location.')
            # print('Removing carID ' + str(carID) + ' current location.')
            carTracker.pop(carID, None)
            carLocation1.pop(carID, None)
            carLocation2.pop(carID, None)

        if not (frameCounter % 10):
            gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
            cars = carCascade.detectMultiScale(gray, 1.1, 13, 18, (24, 24))

            for (_x, _y, _w, _h) in cars:
                x = int(_x)
                y = int(_y)
                w = int(_w)
                h = int(_h)

                x_bar = x + 0.5 * w
                y_bar = y + 0.5 * h

                matchCarID = None

                for carID in carTracker.keys():
                    trackedPosition = carTracker[carID].get_position()

                    t_x = int(trackedPosition.left())
                    t_y = int(trackedPosition.top())
                    t_w = int(trackedPosition.width())
                    t_h = int(trackedPosition.height())

                    t_x_bar = t_x + 0.5 * t_w
                    t_y_bar = t_y + 0.5 * t_h

                    if ((t_x <= x_bar <= (t_x + t_w)) and (t_y <= y_bar <= (t_y + t_h)) and (x <= t_x_bar <= (x + w)) and (y <= t_y_bar <= (y + h))):
                        matchCarID = carID

                if matchCarID is None:
                    # print('Creating new tracker ' + str(currentCarID))

                    tracker = dlib.correlation_tracker()
                    tracker.start_track(
                        image, dlib.rectangle(x, y, x + w, y + h))

                    carTracker[currentCarID] = tracker
                    carLocation1[currentCarID] = [x, y, w, h]

                    currentCarID = currentCarID + 1

        # cv2.line(resultImage,(0,480),(1280,480),(255,0,0),5)

        for carID in carTracker.keys():
            trackedPosition = carTracker[carID].get_position()

            t_x = int(trackedPosition.left())
            t_y = int(trackedPosition.top())
            t_w = int(trackedPosition.width())
            t_h = int(trackedPosition.height())

            # cv2.rectangle(resultImage, (t_x, t_y),
            #               (t_x + t_w, t_y + t_h), rectangleColor, 4)

            # speed estimation
            carLocation2[carID] = [t_x, t_y, t_w, t_h]

        end_time = time.time()

        if not (end_time == start_time):
             fps = 1.0/(end_time - start_time)
            # fps = int(video.get(cv2.CAP_PROP_FPS))
        # cv2.putText(resultImage, 'FPS: ' + str(int(fps)), (620, 30),cv2.FONT_HERSHEY_SIMPLEX, 0.75, (0, 0, 255), 2)

        for i in carLocation1.keys():
            if frameCounter % 1 == 0:
                [x1, y1, w1, h1] = carLocation1[i]
                [x2, y2, w2, h2] = carLocation2[i]

                # print 'previous location: ' + str(carLocation1[i]) + ', current location: ' + str(carLocation2[i])
                carLocation1[i] = [x2, y2, w2, h2]
                auxFrame = resultImage.copy()
                persona = auxFrame[y-20:y+h+20 ,x-20:x+h+20 ]
                # print 'new previous location: ' + str(carLocation1[i])
                if [x1, y1, w1, h1] != [x2, y2, w2, h2]:
                    if (speed[i] == None or speed[i] == 0) and y1 >= 265 and y1 <= 285:
                        speed[i] = estimateSpeed(
                            [x1, y1, w1, h1], [x2, y2, w2, h2])

                    # if y1 > 275 and y1 < 285:
                    if speed[i] != None and y1 >= 50:
                        cv2.putText(resultImage, str(int(speed[i])) + " km/hr", (int(x1 + w1/2), int(
                            y1-5)), cv2.FONT_HERSHEY_SIMPLEX, 0.75, (255, 255, 255), 2)
                        if speed[i] >= 110 and y1 >= 265 and y1 <= 275:
                            
                            
                            
                            # membuat query untuk insert data ke mysql
                             # Set the subject and body of the email
                            # subject = 'Terjadi Pelanggaran di Jalan Toll !!'

                            # body = """
                            # Telah terjadi Pelanggaran Lalu Lintas!!!
                            # Over Speed """""+str(round(speed[i]))+""" km/h
                            # MOHON SEGERA DI TINDAK
                            # """

                            # em = EmailMessage()
                            # em['From'] = email_sender
                            # em['To'] = email_receiver
                            # em['Subject'] = subject
                            # em.set_content(body)

                            # s = smtplib.SMTP('smtp.gmail.com', 587)
                            # # start TLS for security
                            # s.starttls()
                            # s.login(email_sender, email_password)

                            # Add SSL (layer of security)
                            context = ssl.create_default_context()

                            # mengeksekusi commit biar permanen
                            
                            
                            curr_datetime = datetime.now().strftime('%Y-%m-%d %H-%M-%S')
                            cv2.imwrite("static/pelanggaran/Over_speed-"+str(curr_datetime)+".png", persona)
                            # with open("static/pelanggaran/Over_speed-"+str(curr_datetime)+".png", 'rb') as f:
                            #         image_data = f.read()
                            #         image_type = imghdr.what(f.name)
                            #         image_name = f.name
                            # em.add_attachment(
                            # image_data, maintype='image', subtype=image_type, filename=image_name)
                            # s.sendmail(
                            #         email_sender, email_receiver, em.as_string())
                            gambar = "Over_speed-" +str(curr_datetime)+".png"
                            lokasi = 'Tol Layang'
                            for x in receiver_id:
                                bot.sendPhoto(x, photo=open('static/pelanggaran/Over_speed-'+str(curr_datetime)+'.png', 'rb')) # send message to telegram
                                bot.sendMessage(x, 'Pelanggaran Over Speed di toll layang dengan kecepatan '+str(round(speed[i]))+' km/hr') 
                            # bot.sendPhoto(receiver_id[0], photo=open('static/pelanggaran/Over_speed-'+str(curr_datetime)+'.png', 'rb')) # send message to telegram
                            # bot.sendMessage(receiver_id[0], 'Pelanggaran Over Speed di toll layang dengan kecepatan '+str(round(speed[i]))+' km/hr') # send a activation message to telegram receiver id
                            # bot.sendPhoto(receiver_id[1], photo=open('static/pelanggaran/Over_speed-'+str(curr_datetime)+'.png', 'rb')) # send message to telegram
                            # bot.sendMessage(receiver_id[1], 'Pelanggaran Over Speed di toll layang dengan kecepatan '+str(round(speed[i]))+' km/hr') # send a activation message to telegram receiver id
                             
                            
                            sql = "INSERT INTO data_pelanggaran(JENIS_PELANGGARAN, WAKTU,GAMBAR, LOKASI, project) VALUES ('Over Speed', now(),'"+gambar + "',  '"+lokasi + "', '-')"
                            # flash('Ada Pelanggaran') 
                            # untuk memasukkan variabel int kedalam sql, maka tidak diperlukan petik satu. hanya untuk data string yang memerlukan double petik
                            print(sql)

                            mysqlCursor.execute(sql)
                            mysql.commit()
                           
                        # if speed[i] == 0 and y1 >= 265 and y1 <= 275 :
                        #     curr_datetime = datetime.now().strftime('%Y-%m-%d %H-%M-%S')
                        #     cv2.imwrite("static/pelanggaran/KendaraanDiam-"+str(curr_datetime)+".png", persona) 
                        #     for x in receiver_id:
                        #         bot.sendPhoto(x, photo=open('static/pelanggaran/KendaraanDiam-'+str(curr_datetime)+'.png', 'rb')) # send message to telegram
                        #         bot.sendMessage(x, 'Kendaraan diam'+str(round(speed[i]))+' km/hr') 
                            
                        # cv2.putText(resultImage, str(int(carID)), (int(x1 + w1/16), int(
                        #     y1-5)), cv2.FONT_HERSHEY_SIMPLEX, 0.75, (255, 255, 0), 2)
                    #print ('CarID ' + str(i) + ': speed is ' + str("%.2f" % round(speed[i], 0)) + ' km/h.\n')

                    # else:
                    #	cv2.putText(resultImage, "Far Object", (int(x1 + w1/2), int(y1)),cv2.FONT_HERSHEY_SIMPLEX, 0.5, (255, 255, 255), 2)

                        #print ('CarID ' + str(i) + ' Location1: ' + str(carLocation1[i]) + ' Location2: ' + str(carLocation2[i]) + ' speed is ' + str("%.2f" % round(speed[i], 0)) + ' km/h.\n')
        # cv2.imshow('result', resultImage)
        frame = cv2.imencode('.jpg', resultImage)[1].tobytes()
        yield (b'--frame\r\n'b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n')
        # Write the frame into the file 'output.avi'
        # out.write(resultImage)

        # if cv2.waitKey(33) == 27:
        # 	break
    video.release()
    cv2.destroyAllWindows()


@app.route('/video_feed')
def video_feed():
    """Video streaming route. Put this in the src attribute of an img tag."""
    return Response(trackMultipleObjects(),
                    mimetype='multipart/x-mixed-replace; boundary=frame')


if __name__ == '__main__':
    app.run(host='0.0.0.0', threaded=True, port=5000, debug=True)