from flask import Flask, render_template  #, request, send_file
from flask_cors import CORS
import subprocess
import sqlite3

app = Flask(__name__)
CORS(app)  # Add this line to enable CORS for all routes

@app.route('/run_script', methods=['POST'])
def run_script():
    print("hello from post")
    # Execute the Python script
    subprocess.run(['python3', 'pert.py'])
    # Optionally, you can send a response back to the web page
    return 'Script executed successfully'

@app.route('/project',methods=['POST'])
def project():
    print("hello from project")
    # Connect to your database and fetch necessary data
    conn = sqlite3.connect('protrack_db.db')
    cursor = conn.cursor()

    # Fetch project title
    cursor.execute("SELECT project_name FROM projects WHERE PID=?", (4,))
    project_title = cursor.fetchone()[0]

    # Fetch team members
    cursor.execute("SELECT first_name, last_name, email FROM users WHERE CID IN (SELECT CID FROM projects WHERE PID=?)", (4,))
    team_members = cursor.fetchall()

    # Fetch deliverables
    cursor.execute("SELECT description, image FROM tasks WHERE PID=?", (4,))
    deliverables = cursor.fetchall()

    conn.close()

    # Render the HTML template with the fetched data
    return render_template('project.html', project_title=project_title, team_members=team_members, deliverables=deliverables)

if __name__ == '__main__':
    app.run(debug=False)

