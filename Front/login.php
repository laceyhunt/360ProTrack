<!DOCTYPE html>
<html>
<head>
		<title>ProTrack Log In</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
	</head>
<body style="background-color: lightskyblue">
<?php
    require('db.php');
    session_start();
    // When form submitted, check and create user session.
    if (isset($_POST['email'])) {
		$type=$_REQUEST['usertype'];
        $email = stripslashes($_REQUEST['email']);    // removes backslashes
        $email = mysqli_real_escape_string($con, $email);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        // Check user is exist in the database
		if($type==1){
			$query    = "SELECT * FROM `users` WHERE email='$email'
					 AND type='$type'
                     AND password='" . md5($password) . "'";
			$result = mysqli_query($con, $query) or die(mysql_error());
			$rows = mysqli_num_rows($result);
			if ($rows == 1) {
				$_SESSION['email'] = $email;
				// Redirect to user dashboard page
				header("Location: ../latter/instructor/instructor_home.php");
			} else {
				echo "<div class='form'>
					  <h3>Incorrect Email/password.</h3><br/>
					  <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
					  </div>";
			}
		}else if ($type==2){
			$query    = "SELECT * FROM `users` WHERE email='$email'
					 AND type='$type'
                     AND password='" . md5($password) . "'";
			$result = mysqli_query($con, $query) or die(mysql_error());
			$rows = mysqli_num_rows($result);
			if ($rows == 1) {
				$_SESSION['email'] = $email;
				// Redirect to user dashboard page
				header("Location: ../latter/student/student_home.html");
			} else {
				echo "<div class='form'>
					  <h3>Incorrect Email/password.</h3><br/>
					  <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
					  </div>";
			}
		}
        
    } else {
?>
	<div class="row" style="padding=200px">
                <div class="row" style='padding-bottom: 100px'></div>
                <div class="row">
                                <div class="col-md-2" style="padding-top: 100px;"></div>
                                <div class="col-md-8" style="background-color: whitesmoke; padding-top: 100px; padding-bottom: 100px">
                                    <div class="row" style="text-align: center;">
                                        <div class="row">
                                            <h1 style="text-align: center; padding-bottom: 50px;">Log in</h1>
                                        </div>
                                        <div class="col-md-2">

                                        </div>
                                        <div class="col-md-8" style="text-align: center; padding: 50px; text-decoration: none; color: black;">
											<form class="form" method="post" name="login">
												<input type="text" class="login-input" name="email" placeholder="Email" autofocus="true"/><br><br>
												<input type="password" class="login-input" name="password" placeholder="Password"/><br><br>
												<input type="radio" class="login-input" name="usertype" value="1" required>Instructor
												<input type="radio" class="login-input" name="usertype" value="2" required>Student<br><br>
												<input type="submit" value="Login" name="submit" class="login-button"/>
											</form>
                                        </div>
                                        <div class="row" style='padding-top: 50px;'>
											<p><a href='registration.php'>Register here!</a>
                                            <p><a href='landing.php'>Back to Home</a>
                                        </div>
                                    </div>
                                </div>
				<div class="col-md-2"></div>
                </div>
                <div class="row"></div>
    </div>
<?php
    }
?>
</body>
</html>