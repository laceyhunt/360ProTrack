# 360ProTrack

## Running Instructions:
1. Open Xampp control panel as admin
2. Start Apache and MySQL servers
3. Ensure `db.php` as well as the php files in the `student` and `instructor` directories contain correct db infprmation
4. Navigate to `360ProTrack/latter/student/pert_gantt` and start the Python virtual environment with the command `> .venv\Scripts\activate`
5. Start the Python server located in `360ProTrack/latter/student` with the command `> python pert_app.py`
6. Open the project in a localhost browser window (the code uses localhost/360ProTrack, Flask server runs by default on port 5000)

## To stop running:
1. Ctrl+C to stop Python server
2. Deactivate virtual environment with `> deactivate`
3. Stop Apache and MySQL


### Miscellaneous Notes:
The original project used a windows terminal to run the Flask server. You may run into issues if you do not have all the necessary packages and dependencies installed. All of these issues will be displayed in the terminal in which you run the Python app.
