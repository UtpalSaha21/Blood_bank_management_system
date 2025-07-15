<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

// Count donors
$donorResult = $conn->query("SELECT COUNT(*) AS total_donors FROM users WHERE role = 'donor'");
$donors = $donorResult->fetch_assoc()['total_donors'];

// Count recipients
$recipientResult = $conn->query("SELECT COUNT(*) AS total_recipients FROM users WHERE role = 'recipient'");
$recipients = $recipientResult->fetch_assoc()['total_recipients'];

// Count total blood units
$bloodResult = $conn->query("SELECT SUM(quantity) AS total_units FROM blood_stock");
$totalUnits = $bloodResult->fetch_assoc()['total_units'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../Css/admin.css">
</head>
<body>
    <div class="dashboard">
        <h1>Admin Dashboard</h1>
        <div class="card">
            <strong>Total Donors:</strong> <?php echo $donors; ?>
        </div>
        <div class="card">
            <strong>Total Recipients:</strong> <?php echo $recipients; ?>
        </div>
        <div class="card">
            <strong>Total Blood Units in Stock:</strong> <?php echo $totalUnits ?? 0; ?>
        </div>
        <div>
            <a href="../blood_stock.php">📦 View Blood Stock</a>
        </div>
        <div>
            <a href="manage_requests.php">Manage Requests</a>
        </div>
        <div>
            <a href="history.php">View History Log</a>
        </div>
        <a href="../logout.php">Logout</a>
        </div>
</body>
</html>
