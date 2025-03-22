<?php
session_start();
include("connect.php");

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signIn'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM user WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['email'] = $row['email'];
        $_SESSION['user_id'] = $row['Id']; // Store user_id in the session
        header("Location: homepage.php");
        exit();
    } else {
        echo "<script>alert('Invalid email or password.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Embedded CSS -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
    background: url('images/flat-lay-workstation-with-copy-space-laptop.jpg');
    background-size: cover; 
    background-position: center center; 
    background-repeat: no-repeat; 
    font-size: 16px;
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}


        .container {
    background: rgba(255, 255, 255, 0.9); 
    width: 500px;
    padding: 2.5rem;
    margin: 0;
    border-radius: 15px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    transition: box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}


        .container:hover {
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1.5rem;
            color: #4a90e2;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group input {
            width: 100%;
            padding: 15px 16px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            color: #333;
            transition: border-color 0.3s ease, background-color 0.3s ease;
            padding-left: 40px;
        }

        .input-group i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }

        .input-group input::placeholder {
            color: #aaa;
            font-size: 1rem;
        }

        .input-group input:focus {
            border-color: #4a90e2;
            outline: none;
            background-color: #fff;
        }

        .btn {
            width: 100%;
            padding: 15px;
            background-color: #4a90e2;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn:hover {
            background-color: #357ab7;
            transform: translateY(-2px);
        }

        .btn:active {
            background-color: #2c5b87;
            transform: translateY(0);
        }

        .links {
            display: flex;
            justify-content: center;
            margin-top: 1.5rem;
        }

        button {
            color: #4a90e2;
            background-color: transparent;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        button:hover {
            color: #357ab7;
            text-decoration: underline;
        }

        .homepage-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container" id="signup" style="display:none;">
        <h1 class="form-title">Register</h1>
        <form method="post" action="register.php">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="fName" id="fName" placeholder="First Name" required>
            </div>
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="lName" id="lName" placeholder="Last Name" required>
            </div>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Email" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
            <input type="submit" class="btn" value="Sign Up" name="signUp">
        </form>
        <div class="links">
            <p>Already Have Account?</p>
            <button id="signInButton">Sign In</button>
        </div>
    </div>

    <div class="container" id="signIn">
        <h1 class="form-title">Sign In</h1>
        <form method="post" action="login.php">
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Email" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
            <input type="submit" class="btn" value="Sign In" name="signIn">
        </form>
        <div class="links">
            <p>Don't have an account yet?</p>
            <button id="signUpButton">Sign Up</button>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
