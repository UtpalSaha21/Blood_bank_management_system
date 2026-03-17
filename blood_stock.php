<?php
    include ('includes/db.php');
    session_start();
    
    if (!isset($_SESSION['role'])) 
        {
            $_SESSION['unathorize']="<p style='color:red;'>You have to login first</p>";
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
    <link rel="stylesheet" href="Css/style.css">
</head>
<body>

    <div class="menu text-center">
        <div class="wrapper">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="account.php">Enter Into Account</a></li>
                <li><a href="find_donor.php">Find Donor By Blood Group</a></li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="tbl-wrapper">
            <h2>🩸 Current Blood Stock</h2>
            
            <table class="tbl">
                <tr>
                    <th>Blood Group</th>
                    <th>Available Quantity (Units)</th>
                </tr>
                
                <?php while ($row = mysqli_fetch_assoc($res)) { ?>
                <tr>
                    <td><?php echo $row['blood_group']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                </tr>
                
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>