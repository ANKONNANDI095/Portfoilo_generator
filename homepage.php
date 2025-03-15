<?php
session_start();
include("connect.php");

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$query = mysqli_query($conn, "SELECT * FROM user WHERE email='$email'");
$user = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage - Portfolio Generator</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="homepage-container">
        <div class="welcome-message">
            <h1>Hello, <?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?>!</h1>
            <p>Welcome to your Portfolio Generator Dashboard.</p>
        </div>

        <div class="action-buttons">
            <a href="personal_info.php" class="btn">Create Your Portfolio</a>
            <a href="logout.php" class="btn logout-btn">Logout</a>
        </div>
    </div>
</body>
</html>