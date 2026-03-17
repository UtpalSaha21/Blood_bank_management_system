<?php
    include ('../includes/db.php');
    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'recipient')
        {
            header("Location: ../login.php");
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
    <title>Recipient Dashboard</title>
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

    <div class="container text-center">

        <h2>Welcome, <?php echo $name; ?></h2>

        <a href="request.php" class="btn">🩸 Request Blood</a>
        <a href="../blood_stock.php" class="btn">📦 View Blood Stock</a>
        <a href="../logout.php" class="btn">🏃🏻‍♀️‍➡️ Logout</a><br><br>

        <?php
        if(isset($_SESSION['success']))
            {
                echo $_SESSION['success'];
                unset($_SESSION['success']);
            }
        ?>

    </div>

    <div class="main-content">
        <div class="tbl-wrapper">
            <h3>Request History</h3>

            <?php
                $sql2 = "SELECT * FROM blood_requests WHERE user_id = $user_id AND request_type = 'request' ORDER BY request_date DESC";
                $res2 = mysqli_query($conn,$sql2);
                $count = mysqli_num_rows($res2);

                if($count>0)
                    {
            ?>
                        <table class="tbl">

                                <tr>
                                    <th>Blood Group</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                        <?php
                
                        while($row2 = mysqli_fetch_assoc($res2)) 
                            { 

                        ?>
                                <tr>
                                    <td><?php echo $row2['blood_group']; ?></td>

                                    <td><?php echo $row2['quantity']; ?></td>

                                    <td>
                                        <?php
                                        if ($row2['status'] === 'approved') 
                                            { 
                                                ?>
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

                                    <td><?php echo $row2['request_date']; ?></td>

                                </tr>
                                <?php 
                            } 
                        
                        ?>
                        </table>

                    <?php
                    }
                    else
                        {
                    ?>
                            <span class="rejected">No History available</span>
            <?php
                        }
            ?>
            
        </div>
    </div>
</body>
</html>
