<?php
    include ('../includes/db.php');
    session_start();

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin')
        {
            header('Location: '.SITEURL.'login.php');
            exit();
        }

    // Handle Approve/Reject action BEFORE output
    if (isset($_GET['action']) && isset($_GET['id']))
        {
            $id = intval($_GET['id']);
            $action = $_GET['action'];

            // Get request details
            $sql = "SELECT * FROM blood_requests WHERE id = $id";
            $res = mysqli_query($conn, $sql);
            $request = mysqli_fetch_assoc($res);

            if ($request)
                {
                    $blood_group = $request['blood_group'];
                    $quantity    = $request['quantity'];
                    $type        = $request['request_type'];

                    // Get current stock
                    $sql2 = "SELECT quantity FROM blood_stock WHERE blood_group = '$blood_group'";
                    $res2 = mysqli_query($conn, $sql2);

                    if (mysqli_num_rows($res2) > 0)
                        {
                            $row2 = mysqli_fetch_assoc($res2);
                            $current_qty = $row2['quantity'];
                        }
                    else 
                        {
                            // Insert new blood group if not found
                            $sql_insert = "INSERT INTO blood_stock (blood_group, quantity) VALUES ('$blood_group', 0)";
                            mysqli_query($conn, $sql_insert);
                            $current_qty = 0;
                        }

                    if ($action == 'approve')
                        {
                            if ($type == 'donate')
                                {
                                    // Increase stock
                                    $new_qty = $current_qty + $quantity;
                                    mysqli_query($conn, "UPDATE blood_stock SET quantity = $new_qty WHERE blood_group = '$blood_group'");
                                    mysqli_query($conn, "UPDATE blood_requests SET status = 'approved' WHERE id = $id");

                                    $_SESSION['accept'] = "<div class='success'>✅ Donation request approved!</div>";

                                } 
                            elseif ($type == 'request')
                                    {
                                        if ($current_qty >= $quantity) 
                                            {
                                                // Decrease stock
                                                $new_qty = $current_qty - $quantity;
                                                mysqli_query($conn, "UPDATE blood_stock SET quantity = $new_qty WHERE blood_group = '$blood_group'");
                                                mysqli_query($conn, "UPDATE blood_requests SET status = 'approved' WHERE id = $id");

                                                $_SESSION['accept'] = "<div class='success'>✅ Blood request approved!</div>";
                                            }
                                        else
                                            {
                                                $_SESSION['reject'] = "<div class='error'>❌ Not enough stock for $blood_group</div>";
                                            }
                                    }
                        }
                    elseif ($action == 'reject')
                            {
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
    $result = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Blood Requests</title>
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
            
            <h2>Pending Blood Requests</h2><br>

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
            <table class="tbl">
                <tr>
                    <th>S.N.</th>
                    <th>User</th>
                    <th>Role</th>
                    <th>Type</th>
                    <th>Blood Group</th>
                    <th>Quantity</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>

                <?php
                $sn = 1;
                while ($row = $result->fetch_assoc()) { ?>
                
                <tr>

                    <td><?php echo $sn++; ?></td>

                    <td><?php echo $row['name']; ?></td>

                    <td><?php echo ucfirst($row['role']); ?></td>

                    <td><?php echo ucfirst($row['request_type']); ?></td>

                    <td><?php echo $row['blood_group']; ?></td>

                    <td><?php echo $row['quantity']; ?></td>

                    <td><?php echo $row['request_date']; ?></td>

                    <td>
                        <a class="btn-approve" href="?action=approve&id=<?php echo $row['id']; ?>">Approve</a>
                        <a class="btn-reject" href="?action=reject&id=<?php echo $row['id']; ?>">Reject</a>
                    </td>

                </tr>

                <?php } ?>

            </table>

        </div>
    </div>

</body>
</html>
