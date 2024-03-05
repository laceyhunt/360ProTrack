<?php
require('db.php');
include("auth_session.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard - Client area</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div class="form">
        <p>Hey, <?php echo $_SESSION['username']; ?>!</p>
        <p>You are now at the user dashboard page.</p>
		<p><a href="registration.php">Add a new user</a></p>
		<p><a href="user_table.php">View/Delete users</a></p>
        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>