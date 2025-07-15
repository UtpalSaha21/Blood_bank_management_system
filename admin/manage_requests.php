<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

// Handle Approve/Reject action
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    // Get request details
    $stmt = $conn->prepare("SELECT * FROM blood_requests WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $request = $result->fetch_assoc();

    if ($request) {
        $blood_group = $request['blood_group'];
        $quantity = $request['quantity'];
        $type = $request['request_type'];

        // Fetch current stock
        $stock_stmt = $conn->prepare("SELECT quantity FROM blood_stock WHERE blood_group = ?");
        $stock_stmt->bind_param("s", $blood_group);
        $stock_stmt->execute();
        $stock_result = $stock_stmt->get_result();

        if ($stock_result->num_rows > 0) {
            $stock_row = $stock_result->fetch_assoc();
            $current_qty = $stock_row['quantity'];
        } else {
            // Initialize stock row if not exists
            $insert_stock = $conn->prepare("INSERT INTO blood_stock (blood_group, quantity) VALUES (?, 0)");
            $insert_stock->bind_param("s", $blood_group);
            $insert_stock->execute();
            $current_qty = 0;
        }

        if ($action === 'approve') {
            if ($type === 'donate') {
                // Update: Increase quantity
                $new_qty = $current_qty + $quantity;
                $update = $conn->prepare("UPDATE blood_stock SET quantity = ? WHERE blood_group = ?");
                $update->bind_param("is", $new_qty, $blood_group);
                $update->execute();

                $conn->query("UPDATE blood_requests SET status = 'approved' WHERE id = $id");

            } elseif ($type === 'request') {
                if ($current_qty >= $quantity) {
                    // Update: Decrease quantity
                    $new_qty = $current_qty - $quantity;
                    $update = $conn->prepare("UPDATE blood_stock SET quantity = ? WHERE blood_group = ?");
                    $update->bind_param("is", $new_qty, $blood_group);
                    $update->execute();

                    $conn->query("UPDATE blood_requests SET status = 'approved' WHERE id = $id");
                } else {
                    echo "<script>alert('❌ Not enough stock for $blood_group');</script>";
                }
            }

        } elseif ($action === 'reject') {
            $conn->query("UPDATE blood_requests SET status = 'rejected' WHERE id = $id");
        }
    }
}



// Fetch all pending requests
$sql = "SELECT br.id, u.name, u.role, br.blood_group, br.quantity, br.request_type, br.status, br.request_date
        FROM blood_requests br
        JOIN users u ON br.user_id = u.id
        WHERE br.status = 'pending'
        ORDER BY br.request_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Blood Requests</title>
    <link rel="stylesheet" href="../Css/manage_req.css">
</head>
<body>
<div class="dashboard">
    <h2>Pending Blood Requests</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Role</th>
            <th>Type</th>
            <th>Blood Group</th>
            <th>Quantity</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= ucfirst($row['role']) ?></td>
            <td><?= ucfirst($row['request_type']) ?></td>
            <td><?= $row['blood_group'] ?></td>
            <td><?= $row['quantity'] ?></td>
            <td><?= $row['request_date'] ?></td>
            <td>
                <a class="btn-approve" href="?action=approve&id=<?= $row['id'] ?>">Approve</a>
                <a class="btn-reject" href="?action=reject&id=<?= $row['id'] ?>">Reject</a>
            </td>
        </tr>
        <?php } ?>
    </table>
    <a href="dashboard.php">Back</a>
</div>
</body>
</html>
