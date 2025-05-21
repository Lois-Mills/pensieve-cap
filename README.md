Github Repository link: https://github.com/Lois-Mills/pensieve-cap 
Project Name: Pensieve
Project Authors: Lois Mills & Joana Aba Mensah


Project Description
Pensieve is a web-based application that has been created to mainly help curb certain reading challenges that individuals with Attention Deficit/Hyperactivity Disorder face. The platform 
has gamification features such as streaks, leaderboards, xp points and badges. It also incorporates an embedded gaze tracker to monitor users attention whilts reading. This platform
seeks to motivate readers and also keep them attentive.

Platform Setup
Web Platform (PHP + MySQL)
The main website is built using PHP, HTML, CSS, and JavaScript. It connects to a database to store user data, books, streaks, etc.
To set it up:
Use a PHP-compatible server like XAMPP or host it on Google Cloud.
Place the project files into server’s public folder (e.g., htdocs for XAMPP).
Import the file adhdplatform.sql into phpMyAdmin.
Set up the database login in settings/db_cred.php.

Gaze Tracker (Python + Flask)
This tool tracks the user's gaze using the webcam and helps check if they are paying attention while reading.
To set it up: Make sure Python 3.11 is installed.
Open terminal and install the needed Python libraries with this command: pip install -r requirements.txt
Inorder to install the required dependiencies.

Frontend
All the page styles and interactivity are handled with the files in the css/ and js/ folders.
Users can register, log in, and upload books to read.
The gaze tracker is embedded into the platform using an HTML iframe element

Deployment
The full application was deployed on Google Cloud Platform.
