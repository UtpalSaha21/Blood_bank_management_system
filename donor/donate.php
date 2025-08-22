<?php
include('../includes/db.php');
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'donor') {
    header("Location: ../login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Donate Blood</title>
    <link rel="stylesheet" href="../Css/donor.css">
</head>
<body>
<div class="dashboard">
    <h2>Donate Blood</h2>
    <form method="POST">
        <select name="blood_group" required>
            <option disabled selected>Select Blood Group</option>
            <option>A+</option><option>A-</option>
            <option>B+</option><option>B-</option>
            <option>AB+</option><option>AB-</option>
            <option>O+</option><option>O-</option>
        </select>
        <input type="number" name="quantity" placeholder="Quantity in units" required>
        <input type="submit" name="donate" value="Submit">
    </form>
    <br><br>
    <div>
    <a href="dashboard.php">Back</a>
    </div>
</div>
</body>
</html>

<?php
    if (isset($_POST['donate'])) 
    {
    $blood_group = $_POST['blood_group'];
    $quantity = $_POST['quantity'];
    $user_id = $_SESSION['userid'];

    $sql = "INSERT INTO blood_requests SET
    user_id = $user_id,
    blood_group = '$blood_group',
    quantity = $quantity,
    request_type = 'donate'
    ";
    $res = mysqli_query($conn,$sql);
    if ($res == true) 
    {
        $_SESSION['success'] = "✅ Donation request submitted successfully!";
        header('location:'.SITEURL.'donor/dashboard.php');
    } 
    else 
    {
        $_SESSION['success'] = "❌ Error submitting donation.";
        header('location:'.SITEURL.'donor/dashboard.php');
    }
    }

?>
