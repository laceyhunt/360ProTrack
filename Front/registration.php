<!DOCTYPE html>
<html>
<head>
		<title>ProTrack Registration</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
	</head>
<body style="background-color: lightskyblue">
<?php
    require('db.php');
    // When form submitted, insert values into the database.
    if (isset($_REQUEST['email'])) {
        // removes backslashes
        $first_name = stripslashes($_REQUEST['first_name']);
        //escapes special characters in a string
        $first_name = mysqli_real_escape_string($con, $first_name);
		$last_name = stripslashes($_REQUEST['last_name']);
        $last_name = mysqli_real_escape_string($con, $last_name);
		$email = stripslashes($_REQUEST['email']);
        $email = mysqli_real_escape_string($con, $email);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
		$type = $_REQUEST['usertype'];
        $query    = "INSERT into `users` (first_name,last_name, email, type, password)
                     VALUES ('$first_name','$last_name', '$email', $type, '" . md5($password) . "')";
        $result   = mysqli_query($con, $query);
        if ($result) {
            echo "<div class='form'>
                  <h3>You are registered successfully.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>Required fields are missing.</h3><br/>
                  <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
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
                                            <h1 style="text-align: center; padding-bottom: 50px;">Registration</h1>
                                        </div>
                                        <div class="col-md-2">

                                        </div>
                                        <div class="col-md-8" style="text-align: center; padding: 50px; text-decoration: none; color: black;">
											<form class="form" action="" method="post">
												<input type="text" class="login-input" name="first_name" placeholder="First name" required /><br><br>
												<input type="text" class="login-input" name="last_name" placeholder="Last name" required /><br><br>
												<input type="text" class="login-input" name="email" placeholder="Email" required /><br><br>
												<input type="password" class="login-input" name="password" placeholder="Password"><br><br>
												<input type="radio" class="login-input" name="usertype" value="1" required>Instructor
												<input type="radio" class="login-input" name="usertype" value="2" required>Student<br><br>
												<input type="submit" name="submit" value="Register" class="login-button">
											 </form>
                                        </div>
                                        <div class="row" style='padding-top: 50px;'>
											<p><a href='login.php'>Login here!</a>
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