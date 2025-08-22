<?php
include ('../includes/db.php');
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: '.SITEURL.'login.php');
    exit();
}

// Handle Approve/Reject action BEFORE output
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    // Get request details
    $sql = "SELECT * FROM blood_requests WHERE id = $id";
    $res = mysqli_query($conn, $sql);
    $request = mysqli_fetch_assoc($res);

    if ($request) {
        $blood_group = $request['blood_group'];
        $quantity    = $request['quantity'];
        $type        = $request['request_type'];

        // Get current stock
        $sql2 = "SELECT quantity FROM blood_stock WHERE blood_group = '$blood_group'";
        $res2 = mysqli_query($conn, $sql2);

        if (mysqli_num_rows($res2) > 0) {
            $row2 = mysqli_fetch_assoc($res2);
            $current_qty = $row2['quantity'];
        } else {
            // Insert new blood group if not found
            $sql_insert = "INSERT INTO blood_stock (blood_group, quantity) VALUES ('$blood_group', 0)";
            mysqli_query($conn, $sql_insert);
            $current_qty = 0;
        }

        if ($action == 'approve') {
            if ($type == 'donate') {
                // Increase stock
                $new_qty = $current_qty + $quantity;
                mysqli_query($conn, "UPDATE blood_stock SET quantity = $new_qty WHERE blood_group = '$blood_group'");
                mysqli_query($conn, "UPDATE blood_requests SET status = 'approved' WHERE id = $id");

                $_SESSION['accept'] = "<div class='success'>✅ Donation request approved!</div>";

            } elseif ($type == 'request') {
                if ($current_qty >= $quantity) {
                    // Decrease stock
                    $new_qty = $current_qty - $quantity;
                    mysqli_query($conn, "UPDATE blood_stock SET quantity = $new_qty WHERE blood_group = '$blood_group'");
                    mysqli_query($conn, "UPDATE blood_requests SET status = 'approved' WHERE id = $id");

                    $_SESSION['accept'] = "<div class='success'>✅ Blood request approved!</div>";
                } else {
                    $_SESSION['reject'] = "<div class='error'>❌ Not enough stock for $blood_group</div>";
                }
            }
        } elseif ($action == 'reject') {
            mysqli_query($conn, "UPDATE blood_requests SET status = 'rejected' WHERE id = $id");
            $_SESSION['reject'] = "<div class='error'>❌ Request rejected!</div>";
        }
    }

    header('Location: '.SITEURL.'admin/manage_requests.php');
    exit();
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
    <br>
    <?php
        if(isset($_SESSION['accept'])) {
            echo $_SESSION['accept'];
            unset($_SESSION['accept']);
        }
        if(isset($_SESSION['reject'])) {
            echo $_SESSION['reject'];
            unset($_SESSION['reject']);
        }
    ?>
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
