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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet"> <!-- Stylish fonts -->
    <style>
        /* Basic styling */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', sans-serif;
            height: 100vh;
            background: url('images/flat-lay-workstation-with-copy-space-laptop.jpg') no-repeat center center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Overlay for the background */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(106, 90, 205, 0.5), rgba(147, 112, 219, 0.5));
            z-index: 1;
        }

        /* Welcome message container */
        .homepage-container {
            z-index: 2;
            text-align: center;
            color: white;
            max-width: 600px;
            background: rgba(0, 0, 0, 0.6);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5);
        }

        .welcome-message h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .welcome-message p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        /* Action buttons */
        .action-buttons a {
            display: inline-block;
            font-size: 1.2rem;
            padding: 12px 25px;
            background-color: #4a90e2;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin: 10px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .action-buttons a:hover {
            background-color: #357ab7;
            transform: scale(1.05);
        }

        .logout-btn {
            background-color: #f54e42;
        }

        .logout-btn:hover {
            background-color: #e0412b;
        }
    </style>
</head>
<body>
    <div class="homepage-container">
        <div class="welcome-message">
            <h1>Hello, <?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?>!</h1>
            <p>Welcome to your Portfolio Generator Dashboard. Create, manage, and showcase your portfolio.</p>
        </div>

        <div class="action-buttons">
            <a href="personal_info.php" class="btn">Create Your Portfolio</a>
            <a href="logout.php" class="btn logout-btn">Logout</a>
        </div>
    </div>
</body>
</html>
