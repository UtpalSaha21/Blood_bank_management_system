<?php
session_start();
include ('includes/db.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="Css/login.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
    <form method="POST">
        Email: <input type="email" name="email" >
        Password: <input type="password" name="password" >
        <br>
        <input type="submit" name="login" value="Login">
        <br>
        <tr>
            <td>OR</td>
        </tr>
        <br><br>
        <input type="submit" name="register" value="Register">
    </form>
    </div>

<?php
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $pass = md5($_POST['password']);

    // Query user from database
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$pass'";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    // Check user exists
    if ($count == 1) 
        {
                    $row = mysqli_fetch_assoc($res);
                    $_SESSION['userid'] = $row['id'];
                    $_SESSION['role'] = $row['role'];

                    // Redirect by role
                    if ($row['role'] == 'admin') 
                        {
                        header('location:'.SITEURL.'admin/dashboard.php');
                        } 
                    elseif ($row['role'] == 'donor') 
                        {
                        header('location:'.SITEURL.'donor/dashboard.php');
                        } 
                    else 
                        {
                        header('location:'.SITEURL.'recipient/dashboard.php');
                        }
        } 
    else 
        {
            echo "<p style='color:red;'>❌ User not found or wrong password.</p>";
        }

}

    if(isset($_POST['register']))
    {
        header('location:'.SITEURL.'register.php');
    }
    if(isset($_SESSION['unathorize']))
    {
        echo $_SESSION['unathorize'];
        unset($_SESSION['unathorize']);
    }
?>
</body>
</html>
