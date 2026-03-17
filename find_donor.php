<?php
    include("includes/db.php");
    $show = false;
    if(isset($_POST['submit']))
        {
            $show = true;
            $blood_group = $_POST['blood_group'];
            $sql = "SELECT * FROM users WHERE blood_group = '$blood_group' AND search = 'yes'";
            $res = mysqli_query($conn,$sql);
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

    <div class="container text-center">
        
        <h1>Find Donor By Blood Group</h1>
        
        <form action="" method="POST">
            <select name="blood_group" id="">
                <option value="" disabled selected>Blood Group</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
            </select>
            <input type="submit" name="submit" value="search">
        </form>

    </div>

    <div class="main-content">
        <div class="tbl_wrapper">
            <?php if($show)
                {
                    while($row = mysqli_fetch_assoc($res))
                        {?>
                            <table class="tbl">
                                
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Address</th>
                                </tr>
                                
                                <tr>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['phone']; ?></td>
                                    <td><?php echo $row['address']; ?></td>
                                </tr>

                            </table>       
                            
                    <?php
                        }
                }
                ?>
        </div>
    </div>
</body>
</html>