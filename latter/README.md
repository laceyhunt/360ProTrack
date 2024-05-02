# Apps
Current apps: 

`@app.route('/run_script', methods=['POST'])`

`@app.route('/run_test_code', methods=['GET'])`

`@app.route('/project',methods=['POST'])`


# Ideas
Vision: to make another app that can handle running code...

student uploads c, c++... file

system checks filetype and calls `app` which has different methods for different types

runs some `.php` file to save code to temporary directory (to save memory? save by file type?)

executes `subprocess.run(['<compiler-tag>', '<filename>', > , <output-file>])`

then save the `<output-file>` to the temp dir and display it? or convert it to json object and display pure string?


# Commands
In terminal, start python virtual environment: `.venv\Scripts\activate`

To deactivate venv: `deactivate`
