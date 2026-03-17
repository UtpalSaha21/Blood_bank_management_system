<?php
    include('../includes/db.php');
    session_start();

    // Only admin can access
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin')
        {
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
    <link rel="stylesheet" href="../Css/style.css">
</head>
<body>

    <div class="menu text-center">
        <div class="wrapper">
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../account.php">Enter Into Account</a></li>
                <li><a href="../find_donor.php">Find Donor By Blood Group</a></li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="tbl-wrapper">
            <h2>🩸 Update Blood Stock</h2>
            <form method="POST">
                <table class="tbl">
                    
                    <tr>
                        <th>Blood Group</th>
                        <th>Available Quantity (Units)</th>
                    </tr>

                    <?php while ($row = mysqli_fetch_assoc($res)) { ?>
                        
                    <tr>
                        <td><?php echo $row['blood_group']; ?></td>

                        <td>
                            <input type="number" name="quantity[<?php echo $row['blood_group']; ?>]" value="<?php echo $row['quantity']; ?>" min="0">
                        </td>

                    </tr>
                    <?php } ?>
                </table>
                <br>
                <input type="submit" name="save" value="💾 Save Changes" class="btn-approve">
            </form>
        </div>
    </div>

</body>
</html>

<?php
    // Handle form submission
    if (isset($_POST['save']))
        {
            foreach ($_POST['quantity'] as $blood_group => $qty)
                    {
                        $qty = (int)$qty; // prevent injection
                        $blood_group = mysqli_real_escape_string($conn, $blood_group);
                        
                        $sql2 = "UPDATE blood_stock SET quantity = $qty WHERE blood_group = '$blood_group'";
                        mysqli_query($conn, $sql2);
                    }
                
            $_SESSION['save'] = "<p style='color:green;'>Blood stock updated successfully!</p>";
            header('location:'.SITEURL.'admin/admin_blood_stock.php');
        }

?>
