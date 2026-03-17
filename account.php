<?php
    session_start();
    include("includes/db.php");

    if (!isset($_SESSION['role']))
        {
            header('location:'.SITEURL.'login.php');
            exit();
        }

    if ($_SESSION['role'] == 'donor')
        {
            header('location:'.SITEURL.'donor/dashboard.php');
            exit();
        }
    
    if ($_SESSION['role'] == 'recipient')
        {
            header('location:'.SITEURL.'recipient/dashboard.php');
            exit();
        }

    if ($_SESSION['role'] == 'admin')
        {
            header('location:'.SITEURL.'admin/dashboard.php');
            exit();
        }
?>