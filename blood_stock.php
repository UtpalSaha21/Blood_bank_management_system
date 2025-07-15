<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include 'includes/db.php';

// Fetch blood stock data
$sql = "SELECT blood_group, quantity FROM blood_stock ORDER BY blood_group ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blood Stock</title>
    <link rel="stylesheet" href="Css/blood_stock.css">
</head>
<body>
<div class="dashboard">
    <h2>🩸 Current Blood Stock</h2>
    <table>
        <tr>
            <th>Blood Group</th>
            <th>Available Quantity (Units)</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['blood_group'] ?></td>
            <td><?= $row['quantity'] ?></td>
        </tr>
        <?php } ?>
    </table>
</div>
<div>
    <a href="admin/dashboard.php">Back</a>
</div>
</body>
</html>
