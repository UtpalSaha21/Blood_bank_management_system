<?php
include('../includes/db.php');
session_start();

// Only admin can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('location:' . SITEURL . 'login.php');
    exit();
}

// Fetch blood stock data
$sql = "SELECT blood_group, quantity FROM blood_stock ORDER BY blood_group ASC";
$res = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Blood Stock</title>
    <link rel="stylesheet" href="../Css/blood_stock.css">
</head>
<body>
    <div class="dashboard">
        <h2>🩸 Update Blood Stock</h2>
        <form method="POST">
            <table>
                <tr>
                    <th>Blood Group</th>
                    <th>Available Quantity (Units)</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($res)) { ?>
                    <tr>
                        <td><?= $row['blood_group'] ?></td>
                        <td>
                            <input type="number" name="quantity[<?= $row['blood_group'] ?>]" 
                                   value="<?= $row['quantity'] ?>" min="0">
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <input type="submit" name="save" value="💾 Save Changes" class="button">
        </form>
    </div>

    <div>
        <a href="dashboard.php">⬅ Back to Dashboard</a>
    </div>
</body>
</html>

<?php
    // Handle form submission
if (isset($_POST['save'])) {
    foreach ($_POST['quantity'] as $blood_group => $qty) {
        $qty = (int)$qty; // prevent injection
        $blood_group = mysqli_real_escape_string($conn, $blood_group);
        
        $sql2 = "UPDATE blood_stock SET quantity = $qty WHERE blood_group = '$blood_group'";
        mysqli_query($conn, $sql2);
    }
    $_SESSION['save'] = "<p style='color:green;'>✅ Blood stock updated successfully!</p>";
    header('location:'.SITEURL.'admin/admin_blood_stock.php');
}

?>
