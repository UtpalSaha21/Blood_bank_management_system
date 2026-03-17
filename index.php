<?php
    session_start();
    include("includes/db.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blood Bank Management System</title>
    <link rel="stylesheet" href="Css/style.css">
</head>
<body>

    <div class="menu text-center">
        <div class="wrapper">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="account.php">Enter Into Account</a></li>
                <li><a href="find_donor.php">Find Donor By Blood Group</a></li>
            </ul>
        </div>
    </div>

    <div class="text-center">
        <h1>Blood Bank</h1>
        <p>A Social Initiative To Save Life</p>
        <p>Do you need blood? Searching for blood donor!</p>
        <img class="img-size" src="img/image.jpg" alt="">
    </div>
    
</body>
</html>
