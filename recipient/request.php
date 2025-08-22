<?php
include('../includes/db.php');
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'recipient') {
    header("Location: ../login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Request Blood</title>
    <link rel="stylesheet" href="../Css/recipient.css">
</head>
<body>
<div class="dashboard">
    <h2>Request Blood</h2>
    <?php if (isset($msg)) echo "<p>$msg</p>"; ?>
    <form method="POST">
        <select name="blood_group" required>
            <option disabled selected>Select Blood Group</option>
            <option>A+</option><option>A-</option>
            <option>B+</option><option>B-</option>
            <option>AB+</option><option>AB-</option>
            <option>O+</option><option>O-</option>
        </select>
        <input type="number" name="quantity" placeholder="Quantity in units" required>
        <input type="submit" name="request" value="Submit">
    </form>
    <br><br>
        <div>
        <a href="dashboard.php">Back</a>
        </div>
</div>
</body>
</html>

<?php

    if (isset($_POST['request'])) 
        {
            $blood_group = $_POST['blood_group'];
            $quantity = $_POST['quantity'];
            $user_id = $_SESSION['userid'];

            $sql = "INSERT INTO blood_requests SET
            user_id = $user_id,
            blood_group = '$blood_group',
            quantity = $quantity,
            request_type = 'request'
            ";
            $res = mysqli_query($conn,$sql);
            if ($res == true) 
            {
                $_SESSION['success'] = "✅ Blood request submitted successfully!";
                header('location:'.SITEURL.'recipient/dashboard.php');
            } 
            else 
            {
                $_SESSION['success'] = "❌ Error submitting request.";
                header('location:'.SITEURL.'recipient/dashboard.php');
            }
        }

?>
