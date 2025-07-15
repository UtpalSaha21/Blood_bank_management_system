<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'recipient') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

if (isset($_POST['request'])) {
    $blood_group = $_POST['blood_group'];
    $quantity = $_POST['quantity'];
    $user_id = $_SESSION['userid'];

    $stmt = $conn->prepare("INSERT INTO blood_requests (user_id, blood_group, quantity, request_type) VALUES (?, ?, ?, 'request')");
    $stmt->bind_param("isi", $user_id, $blood_group, $quantity);

    if ($stmt->execute()) {
        $msg = "✅ Blood request submitted successfully!";
    } else {
        $msg = "❌ Error submitting request.";
    }
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
</div>
</body>
</html>
