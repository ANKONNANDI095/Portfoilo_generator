<?php
include 'connect.php';

// Handle user registration
if (isset($_POST['signUp'])) {
    $firstName = $_POST['fName'];
    $lastName = $_POST['lName'];
    $email = $_POST['email'];
    $password = $_POST['password']; // No hashing

    // Check if email already exists
    $checkEmail = "SELECT * FROM user WHERE email='$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        echo "Email Address Already Exists!";
    } else {
        // Insert new user into the database
        $insertQuery = "INSERT INTO user (firstName, lastName, email, password)
                        VALUES ('$firstName', '$lastName', '$email', '$password')"; // Store plain-text password

        if ($conn->query($insertQuery)) {
            header("Location: login.php"); // Redirect to the login page
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Handle user login
if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password']; // No hashing

    // Check if the user exists
    $sql = "SELECT * FROM user WHERE email='$email' AND password='$password'"; // Compare plain-text passwords
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Start a session and store user data
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        header("Location: homepage.php"); // Redirect to the homepage
        exit();
    } else {
        echo "Not Found, Incorrect Email or Password";
    }
}
?>