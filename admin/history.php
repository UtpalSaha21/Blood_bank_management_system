<?php
    include ('../includes/db.php');
    
    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin')
        {
            header('location:'.SITEURL.'login.php');
            exit();
        }


    // Fetch all non-pending requests

    $sql = "SELECT * FROM blood_requests , users WHERE
    blood_requests.status IN ('approved','rejected') AND users.id = blood_requests.user_id
    ORDER BY blood_requests.request_date DESC";
    $res = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Blood Request History</title>
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
            
            <h2>Request & Donation History</h2>
            
            <table class="tbl">
                <tr>
                    <th>S.N.</th>
                    <th>User</th>
                    <th>Role</th>
                    <th>Type</th>
                    <th>Blood Group</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>

                <?php

                $sn = 1;

                while ($row = mysqli_fetch_assoc($res)) { ?>
                
                <tr>
                    <td><?php echo $sn++; ?></td>

                    <td><?php echo ($row['name']); ?></td>

                    <td><?php echo ucfirst($row['role']); ?></td>

                    <td><?php echo ucfirst($row['request_type']); ?></td>

                    <td><?php echo $row['blood_group']; ?></td>

                    <td><?php echo $row['quantity']; ?></td>

                    <td>
                        <?php if ($row['status'] === 'approved') { ?>
                            <span class="approved">Approved</span>
                        <?php } else { ?>
                            <span class="rejected">Rejected</span>
                        <?php } ?>
                    </td>

                    <td><?php echo $row['request_date']; ?></td>
                    
                </tr>

                <?php } ?>

            </table>

        </div>
    </div>

</body>
</html>
