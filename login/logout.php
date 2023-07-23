<?php
    session_start();
    // Destroy the user session to log them out
    session_destroy();
    // Redirect to the login page
    header('location: loginn.php');
    exit();
?>
