<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'donor') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';
$user_id = $_SESSION['userid'];

$sql = "SELECT * FROM blood_requests WHERE user_id = ? AND request_type = 'donate' ORDER BY request_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Donor Dashboard</title>
    <link rel="stylesheet" href="../Css/user.css">
</head>
<body>
    <div class="dashboard">
        <h2>Welcome, Donor!</h2>
        <a href="donate.php">➕ Donate Blood</a>
        <h3>Donation History</h3>
        <table>
            <tr>
                <th>Blood Group</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['blood_group'] ?></td>
                <td><?= $row['quantity'] ?></td>
                <td>
                    <?php if ($row['status'] === 'approved') { ?>
                        <span class="approved">Approved</span>
                    <?php } elseif ($row['status'] === 'rejected') { ?>
                        <span class="rejected">Rejected</span>
                    <?php } else { echo ucfirst($row['status']); } ?>
                </td>
                <td><?= $row['request_date'] ?></td>
            </tr>
            <?php } ?>
        </table>
                <br><br>
        <a href="../logout.php">Logout</a>
    </div>
</body>
</html>
