<!DOCTYPE html>
<html>
	<head>
		<title>ProTrack Student Log In</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
	</head>
	<body style="background-color: darkseagreen">
		<?php
    require('db.php');
    session_start();
    // When form submitted, check and create user session.
    if (isset($_POST['username'])) {
        $username = stripslashes($_REQUEST['username']);    // removes backslashes
        $username = mysqli_real_escape_string($con, $username);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        // Check user is exist in the database
        $query    = "SELECT * FROM `students` WHERE username='$username'
                     AND password='" . md5($password) . "'";
        $result = mysqli_query($con, $query) or die(mysql_error());
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            $_SESSION['username'] = $username;
            // Redirect to user dashboard page
            header("Location: dashboard.php");
        } else {
            echo "<div class='form'>
                  <h3>Incorrect Username/password.</h3><br/>
                  <p class='link'>Click here to <a href='student_login.php'>Login</a> again.</p>
                  </div>";
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
                                            <h1 style="text-align: center; padding-bottom: 50px;">Student Login</h1>
                                        </div>
                                        <div class="col-md-2">

                                        </div>
                                        <div class="col-md-8" style="text-align: center; padding: 50px; text-decoration: none; color: black;">
											<form class="form" method="post" name="login">
												<input type="text" class="login-input" name="username" placeholder="Username" autofocus="true"/><br><br>
												<input type="password" class="login-input" name="password" placeholder="Password"/><br><br>
												<input type="submit" value="Login" name="submit" class="login-button"/>
												<p class="link"><a href="student_registration.php">New Registration</a></p>
											</form>
                                        </div>
                                        <div class="row" style='padding-top: 50px;'>
											<p><a href='instructor_login.php'>Login</a> or <a href='instructor_registration.php'>register</a> as an instructor
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
