<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

// Fetch all non-pending requests
$sql = "SELECT br.id, u.name, u.role, br.blood_group, br.quantity, br.request_type, br.status, br.request_date
        FROM blood_requests br
        JOIN users u ON br.user_id = u.id
        WHERE br.status != 'pending'
        ORDER BY br.request_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blood Request History</title>
    <link rel="stylesheet" href="../Css/admin.css">
</head>
<body>
<div class="dashboard">
    <h2>Request & Donation History</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Role</th>
            <th>Type</th>
            <th>Blood Group</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Date</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= ucfirst($row['role']) ?></td>
            <td><?= ucfirst($row['request_type']) ?></td>
            <td><?= $row['blood_group'] ?></td>
            <td><?= $row['quantity'] ?></td>
            <td>
                <?php if ($row['status'] === 'approved') { ?>
                    <span class="approved">Approved</span>
                <?php } else { ?>
                    <span class="rejected">Rejected</span>
                <?php } ?>
            </td>
            <td><?= $row['request_date'] ?></td>
        </tr>
        <?php } ?>
    </table>
</div>
<a href="dashboard.php">Back</a>
</body>
</html>
