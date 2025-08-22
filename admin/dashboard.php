<?php
include ('../includes/db.php');
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

//sql query for getting data from database[counting donor no]
$sql = "SELECT * FROM users WHERE role ='donor'";
$res = mysqli_query($conn,$sql);
$count  = mysqli_num_rows($res);

//sql query for getting data from database[counting recipient no]
$sql2 = "SELECT * FROM users WHERE role ='recipient'";
$res2 = mysqli_query($conn,$sql2);
$count2  = mysqli_num_rows($res2);

//sql query for Count total blood units
$sql3 = "SELECT SUM(quantity) AS total_units FROM blood_stock";
$res3 = mysqli_query($conn,$sql3);
$row3 = mysqli_fetch_assoc($res3);
$count3 = $row3['total_units'];
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
            <strong>Total Donors:</strong> <?php echo $count; ?>
        </div>
        <div class="card">
            <strong>Total Recipients:</strong> <?php echo $count2; ?>
        </div>
        <div class="card">
            <strong>Total Blood Units in Stock:</strong> <?php echo $count3 ?? 0; ?>
        </div>
        <div>
            <a href="<?php echo SITEURL;?>admin/admin_blood_stock.php">📦 View Blood Stock</a>
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
