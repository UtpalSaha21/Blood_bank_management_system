<?php
    include ('includes/db.php'); 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="Css/register.css">
</head>
<body>

<div class="register-container">
    
    <h2>Register</h2>
    
    <form method="POST" action="">
        
        <input type="text" name="name" placeholder="Full Name" required>

        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="password" placeholder="Password" required>

        <input type="number" name="age" placeholder="Age" required>

        <input type="text" name="phone" placeholder="Phone Number" required>

        <select name="gender" required>
            <option value="" disabled selected>Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>

        <textarea name="address" placeholder="Address" rows="3" required></textarea>

        <select name="role" id="role" onchange="showBloodGroup()" required>
            <option value="" disabled selected>Select Role</option>
            <option value="donor">Donor</option>
            <option value="recipient">Recipient</option>
        </select>

        <div id="bloodGroupField" style="display:none;">
            <select name="blood_group">
                <option value="" disabled selected>Select Blood Group</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
            </select>

            <select name="search">
                <option value="" disabled selected>Anyone can find your details by searching</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
        </div>

        <input type="submit" name="register" value="Register"><br>
        
        <p>
            Already have an account?
            <a href="login.php" class="btn">Sign In</a>
        </p>
        
    </form>
</div>


<?php

if (isset($_POST['register'])) 
    {
    // Get form data
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = md5($_POST['password']);
    $role     = $_POST['role'];
    $age      = $_POST['age'];
    $phone    = $_POST['phone'];
    $gender   = $_POST['gender'];
    $address  = $_POST['address'];
    $blood_group = isset($_POST['blood_group']) ? $_POST['blood_group'] : 'NULL';
    $search = isset($_POST['search']) ? $_POST['search'] : 'NULL';

    // Check if email exists

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $res = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($res);

    if ($count>0) 
        {
        echo "<p style='color:red;'>Email already exists.</p>";
        } 
    else 
        {
        // Insert new user
        $sql2 = "INSERT INTO users SET
        name = '$name',
        email = '$email',
        password = '$password',
        role = '$role',
        age = $age,
        gender = '$gender',
        phone = '$phone',
        address = '$address',
        blood_group = '$blood_group',
        search = '$search'
        ";

        $res2 = mysqli_query($conn,$sql2);

        if ($res2==true) 
            {
            echo "<p style='color:green;'>Registration successful. <a href='login.php'>Login Now</a></p>";
            } 
        else 
            {
            echo "<p style='color:red;'>Registration failed. Please try again.</p>";
            }

        }
    }
?>

<!-- Javascript part -->
    <script>
        function showBloodGroup() {

            var role = document.getElementById("role").value;
            var blood = document.getElementById("bloodGroupField");

            if(role == "donor"){
                blood.style.display = "block";
            }
            else{
                blood.style.display = "none";
            }

        }
    </script>
</body>
</html>
