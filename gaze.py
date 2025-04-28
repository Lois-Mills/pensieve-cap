from flask import Flask, render_template, request, jsonify
import mysql.connector
import time

app = Flask(__name__, static_folder='static', template_folder='templates')
@app.route('/')
def index():
    return render_template('gaze_tracker.html')

@app.route('/track_gaze')
def track_gaze():
    return render_template('gaze_tracker.html')


@app.route('/end_session', methods=['POST'])
def end_session():
    data = request.get_json()
    user_id = data.get('user_id', 1)
    alert_count = data.get('alert_count', 0)
    timestamp = time.strftime('%Y-%m-%d %H:%M:%S')

    try:
        conn = mysql.connector.connect(
            host="34.30.26.22",
            user="millsdarlyn",
            password="Madara",
            database="adhdplatform"
        )
        cursor = conn.cursor()
        cursor.execute(
            "INSERT INTO user_alerts (user_id, alert_count, timestamp) VALUES (%s, %s, %s)",
            (user_id, alert_count, timestamp)
        )
        conn.commit()
        cursor.close()
        conn.close()
        print(f"✅ Session ended — {alert_count} alerts logged at {timestamp}")
    except Exception as e:
        print("❌ DB Error (end_session):", e)

    return jsonify({'status': 'ok'})
if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000, ssl_context=("ssl/gaze.crt", "ssl/gaze.key"))

