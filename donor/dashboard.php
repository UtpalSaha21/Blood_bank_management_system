<?php
include('../includes/db.php');
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'donor') {
    header('location:'.SITEURL.'login.php');
    exit();
}

$user_id = $_SESSION['userid'];
//query for getting user information from database
$sql = "SELECT * FROM users WHERE id=$user_id";
$res = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($res);
$name = $row['name'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Donor Dashboard</title>
    <link rel="stylesheet" href="../Css/user.css">
</head>
<body>
    <div class="dashboard">
        <h2>Welcome, <?php echo $name; ?></h2>
        <a href="donate.php">➕ Donate Blood</a>
        <a href="donor_blood_stock.php">📦 View Blood Stock</a>
        <br><br>
        <?php
        if(isset($_SESSION['success']))
        {
            echo $_SESSION['success'];
            unset($_SESSION['success']);
        }
        ?>
        <h3>Donation History</h3>
        <table>
            <tr>
                <th>Blood Group</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
            <?php
                //query for getting the blood req data of the user
                $sql2 = "SELECT * FROM blood_requests WHERE user_id = $user_id AND request_type = 'donate' ORDER BY request_date DESC";
                $res2 = mysqli_query($conn,$sql2);
                while ($row2 = mysqli_fetch_assoc($res2)) { ?>
                <tr>
                    <td><?= $row2['blood_group'] ?></td>
                    <td><?= $row2['quantity'] ?></td>
                    <td>
                        <?php
                            if ($row2['status'] === 'approved') 
                            { ?>
                            <span class="approved">Approved</span>
                            <?php 
                            } 
                            elseif ($row2['status'] === 'rejected') 
                            {  
                            ?>
                            <span class="rejected">Rejected</span>
                            <?php 
                            } 
                            else 
                            { 
                            echo ucfirst($row2['status']); 
                            } 
                            ?>
                    </td>
                    <td><?= $row2['request_date'] ?></td>
                </tr>
            <?php } ?>
        </table>
                <br><br>
        <a href="<?php echo SITEURL;?>logout.php">Logout</a>
    </div>
</body>
</html>
