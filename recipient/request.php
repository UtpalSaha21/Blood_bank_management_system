<?php
    include('../includes/db.php');
    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'recipient')
        {
            header("Location: ../login.php");
            exit();
        }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Request Blood</title>
    <link rel="stylesheet" href="../Css/style.css">
</head>
<body>

    <div class="menu text-center">
        <div class="wrapper">
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../account.php">Enter Into Account</a></li>
                <li><a href="../find_donor.php">Find Donor By Blood Group</a></li>
            </ul>
        </div>
    </div>
    
    <div class="container text-center">
        <h1>Request Blood</h1>

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
