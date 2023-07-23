<?php
session_start();
include('connection.php');

if (isset($_POST['submit'])) {
    $user = $_POST['username'];
    $psd = $_POST['password'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit();
    }

    // Check if the username already exists in the database
    $query = "SELECT * FROM STUDENT WHERE USERNAME='$user'";
    $data = mysqli_query($conn, $query);
    $total = mysqli_num_rows($data);

    if ($total == 0) {
        // Check if the entered password matches the confirm password
        if ($psd === $confirmPassword) {
            // Generate a unique ID based on current time
            $uniqueID = uniqid();

            // Generate a secure hash of the user's password
            $hashedPassword = password_hash($psd, PASSWORD_BCRYPT);

            // Insert the new user into the database with the unique ID and hashed password
            $insertQuery = "INSERT INTO STUDENT (USERNAME, PASSWORD, EMAIL, GENDER, UNIQUE_ID) VALUES ('$user', '$hashedPassword', '$email', '$gender', '$uniqueID')";

            if (mysqli_query($conn, $insertQuery)) {
                // Send the email with the unique ID to the user's email address
                $subject = "Your Unique ID";
                $message = "Your unique ID is: $uniqueID";
                $headers = "From: mjoshi112003@gmail.com"; // Replace with a valid sender email

                if (mail($email, $subject, $message, "From: mjoshi112003@gmail.com")) {
                    // Store the unique ID in the session
                    $_SESSION['unique_id'] = $uniqueID;
                    $_SESSION['user_name'] = $user;
                    header('location: welcome.php');
                    exit();
                } else {
                    echo "Failed to send the confirmation email. Please try again later.";
                }
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "Password and Confirm Password do not match.";
        }
    } else {
        echo "Username already exists. Please choose a different username.";
    }
}
?>


<!-- Link to the CSS file -->
<link rel="stylesheet" href="styles.css">

<form action="signup.php" method="POST" class="signup-form">
<form action="" method="POST" class="signup-form">
    <h2>Sign Up</h2>
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required><br><br>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required><br><br>

    <label for="confirm_password">Confirm Password:</label>
    <input type="password" name="confirm_password" id="confirm_password" required><br><br>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required><br><br>

    <label>Gender:</label>
    <input type="radio" name="gender" value="male" id="male" required>
    <label for="male">Male</label>

    <input type="radio" name="gender" value="female" id="female" required>
    <label for="female">Female</label>

    <input type="radio" name="gender" value="other" id="other" required>
    <label for="other">Other</label><br><br>

    <input type="submit" name="submit" value="SIGN UP">

</form>

