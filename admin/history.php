<?php
include ('../includes/db.php');

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('location:'.SITEURL.'login.php');
    exit();
}


// Fetch all non-pending requests

$sql = "SELECT * FROM blood_requests , users WHERE blood_requests.status IN ('approved','rejected') AND users.id = blood_requests.user_id ORDER BY blood_requests.request_date DESC";
$res = mysqli_query($conn,$sql);
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
        <?php while ($row = mysqli_fetch_assoc($res)) { ?>
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
