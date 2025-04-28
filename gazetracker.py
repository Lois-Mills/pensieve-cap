from flask import Flask, render_template, Response, redirect
import cv2
import mediapipe as mp
import time
import simpleaudio as sa  

app = Flask(__name__)

@app.route('/')
def index():
    return redirect('/track_gaze')

@app.route('/track_gaze')
def track_gaze():
    return render_template('gaze_tracker.html')

# MediaPipe FaceMesh Setup
mp_drawing = mp.solutions.drawing_utils
mp_face_mesh = mp.solutions.face_mesh
mp_drawing_styles = mp.solutions.drawing_styles

face_mesh = mp_face_mesh.FaceMesh(
    static_image_mode=False,
    max_num_faces=1,
    refine_landmarks=True,
    min_detection_confidence=0.5,
    min_tracking_confidence=0.5
)

# Region of interest for attention
roi_x1, roi_y1 = 0, 15
roi_x2, roi_y2 = 600, 380

# Eye landmark indices
EYE_INDICES = [33, 133, 160, 144, 145, 153, 154, 155]

# ✅ simpleaudio for alert
wave_obj = sa.WaveObject.from_wave_file("alert.wav")
play_obj = None

def play_alert_sound():
    global play_obj
    if not play_obj or not play_obj.is_playing():
        play_obj = wave_obj.play()

def stop_alert_sound():
    global play_obj
    if play_obj:
        play_obj.stop()

# Eye position tracking
def get_average_eye_position(face_landmarks, image_shape):
    eye_points = [face_landmarks.landmark[i] for i in EYE_INDICES]
    x_coords = [int(point.x * image_shape[1]) for point in eye_points]
    y_coords = [int(point.y * image_shape[0]) for point in eye_points]
    avg_x = sum(x_coords) // len(x_coords)
    avg_y = sum(y_coords) // len(y_coords)
    print(f"Average X: {avg_x}, Average Y: {avg_y}")
    return avg_x, avg_y

def is_looking_at_roi(face_landmarks, image_shape):
    avg_x, avg_y = get_average_eye_position(face_landmarks, image_shape)
    in_roi = roi_x1 <= avg_x <= roi_x2 and roi_y1 <= avg_y <= roi_y2
    print(f"Is looking at ROI: {in_roi}") 
    return in_roi

# OpenCV capture
cap = cv2.VideoCapture(0)

def generate_frames():
    attention_lost_time = None
    attention_threshold = 5  # Seconds of lost attention
    sound_played = False

    while True:
        success, image = cap.read()
        if not success:
            break

        image_height, image_width, _ = image.shape
        image = cv2.cvtColor(cv2.flip(image, 1), cv2.COLOR_BGR2RGB)
        results = face_mesh.process(image)
        image = cv2.cvtColor(image, cv2.COLOR_RGB2BGR)

        if results.multi_face_landmarks:
            face_landmarks = results.multi_face_landmarks[0]
            looking_at_roi = is_looking_at_roi(face_landmarks, (image_height, image_width))

            if looking_at_roi:
                if attention_lost_time is not None:
                    cv2.putText(image, 'Good focus!', (50, 50), cv2.FONT_HERSHEY_SIMPLEX, 1, (0, 255, 0), 2)
                attention_lost_time = None
                if sound_played:
                    stop_alert_sound()
                    sound_played = False
            else:
                if attention_lost_time is None:
                    attention_lost_time = time.time()
                elif time.time() - attention_lost_time > attention_threshold:
                    cv2.putText(image, 'Focus on reading!', (50, 50), cv2.FONT_HERSHEY_SIMPLEX, 1, (0, 0, 255), 2)
                    if not sound_played:
                        play_alert_sound()
                        sound_played = True

            for face_landmark in results.multi_face_landmarks:
                mp_drawing.draw_landmarks(
                    image=image,
                    connections=mp_face_mesh.FACEMESH_TESSELATION,
                    landmark_list=face_landmark,
                    landmark_drawing_spec=None,
                    connection_drawing_spec=mp_drawing_styles.get_default_face_mesh_tesselation_style()
                )
                mp_drawing.draw_landmarks(
                    image=image,
                    landmark_list=face_landmark,
                    connections=mp_face_mesh.FACEMESH_CONTOURS,
                    landmark_drawing_spec=None,
                    connection_drawing_spec=mp_drawing_styles.get_default_face_mesh_contours_style()
                )
                mp_drawing.draw_landmarks(
                    image=image,
                    landmark_list=face_landmark,
                    connections=mp_face_mesh.FACEMESH_IRISES,
                    landmark_drawing_spec=None,
                    connection_drawing_spec=mp_drawing_styles.get_default_face_mesh_iris_connections_style()
                )

        ret, buffer = cv2.imencode('.jpg', image)
        frame = buffer.tobytes()

        yield (b'--frame\r\n'
               b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n')

@app.route('/video_feed')
def video_feed():
    return Response(generate_frames(), mimetype='multipart/x-mixed-replace; boundary=frame')

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5002, debug=True)
