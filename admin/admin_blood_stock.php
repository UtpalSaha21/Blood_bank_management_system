<?php
include ('../includes/db.php');
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('location:'.SITEURL.'login.php');
    exit();
}


// Fetch blood stock data
$sql = "SELECT blood_group, quantity FROM blood_stock ORDER BY blood_group ASC";
$res = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blood Stock</title>
    <link rel="stylesheet" href="../Css/blood_stock.css">
</head>
<body>

    <form action="" method="POST">
        <div class="dashboard">
    <h2>🩸 Current Blood Stock</h2>
    <?php
        if(isset($_SESSION['save']))
        {
            echo $_SESSION['save'];
            unset($_SESSION['save']);
        }
    ?>    
    <a href="<?php echo SITEURL;?>admin/update_blood_stock.php" class="button">Update</a>
    <table>
        <tr>
            <th>Blood Group</th>
            <th>Available Quantity (Units)</th>
        </tr>
        <?php
        while($row = mysqli_fetch_assoc($res))
        { 
            ?>
        <tr>
            <td><?= $row['blood_group'] ?></td>
            <td><?= $row['quantity'] ?></td>
        </tr>

        <?php 

        }

        ?>
    </table>
</div>
    </form>

<div>
    <a href="dashboard.php">Back</a>
</div>
</body>
</html>
