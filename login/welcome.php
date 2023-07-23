
<?php
    session_start();
    // Make sure the user is logged in before accessing this page
    if (!isset($_SESSION['user_name'])) {
        header('location: login.php');
        exit();
    }
?>

<!-- Link to the CSS file -->
<link rel="stylesheet" href="welcome.css">

<div class="welcome-container">
    <h1>Welcome, <?php echo $_SESSION['user_name']; ?></h1>
    <p>Thank you for signing up!</p>
    <!-- Logout link -->
    <a href="logout.php">Logout</a>
</div>
