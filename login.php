<?php
session_start();
include 'includes/db.php';
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
        Email: <input type="email" name="email" required>
        Password: <input type="password" name="password" required>
        <br>
        <input type="submit" name="login" value="Login">
    </form>
    </div>

<?php
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    // Query user from database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($pass, $user['password'])) {
            $_SESSION['userid'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // Redirect by role
            if ($user['role'] == 'admin') {
                header("Location: admin/dashboard.php");
            } elseif ($user['role'] == 'donor') {
                header("Location: donor/dashboard.php");
            } else {
                header("Location: recipient/dashboard.php");
            }
            exit();
        } else {
            echo "<p style='color:red;'>❌ Wrong password.</p>";
        }
    } else {
        echo "<p style='color:red;'>❌ User not found.</p>";
    }

    $stmt->close();
}
?>
</body>
</html>
