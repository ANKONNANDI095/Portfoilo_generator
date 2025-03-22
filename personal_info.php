<?php
session_start();
include("connect.php");

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_SESSION['user_id'])) {
    die("User ID not found in session. Please log in again.");
}

$user_id = $_SESSION['user_id'];

// Debug: Check if the user_id exists in the user table
$check_user = "SELECT * FROM user WHERE Id = '$user_id'";
$result = mysqli_query($conn, $check_user);

if (mysqli_num_rows($result) === 0) {
    die("Invalid user ID. Please log in again.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = mysqli_real_escape_string($conn, $_POST['fullName']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);
    $profile_picture = "";

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/"; // Ensure this directory exists and is writable
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Create the directory if it doesn't exist
        }
        $target_file = $target_dir . basename($_FILES['profile_picture']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is a JPG or PNG
        if ($imageFileType === 'jpg' || $imageFileType === 'jpeg' || $imageFileType === 'png') {
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
                $profile_picture = $target_file;
            } else {
                echo "<script>alert('Error uploading file.');</script>";
            }
        } else {
            echo "<script>alert('Only JPG/PNG files are allowed.');</script>";
        }
    }

    // Insert or update personal info
    $query = "INSERT INTO personal_info (user_id, fullName, phone, profile_picture, bio) 
              VALUES ('$user_id', '$fullName', '$phone', '$profile_picture', '$bio')
              ON DUPLICATE KEY UPDATE fullName='$fullName', phone='$phone', profile_picture='$profile_picture', bio='$bio'";

    if (mysqli_query($conn, $query)) {
        header("Location: skills.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Information</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background: url('images/flat-lay-workstation-with-copy-space-laptop.jpg') no-repeat center center/cover; /* Full-page background image */
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: rgba(255, 255, 255, 0.8); /* Semi-transparent background */
            width: 500px;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 20px 35px rgba(0, 0, 0, 0.9);
            text-align: center;
        }

        .container h1 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        .input-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-size: 1rem;
        }

        .input-group input,
        .input-group textarea {
            width: 100%;
            padding: 12px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease, background-color 0.3s ease;
        }

        .input-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .input-group input:focus,
        .input-group textarea:focus {
            outline: none;
            border-color: rgb(125, 125, 235);
            box-shadow: 0 0 5px rgba(125, 125, 235, 0.5);
        }

        .file-input {
            margin-bottom: 1.5rem;
        }

        .file-input label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-size: 1rem;
        }

        .custom-file-upload {
            display: inline-block;
            padding: 10px 15px;
            background: rgb(125, 125, 235);
            color: white;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 1rem;
        }

        .custom-file-upload:hover {
            background: #07001f;
        }

        .custom-file-upload i {
            margin-right: 5px;
        }

        #file-name {
            display: block;
            margin-top: 0.5rem;
            font-size: 0.9rem;
            color: #555;
        }

        .btn {
            font-size: 1.1rem;
            padding: 10px 20px;
            border-radius: 5px;
            outline: none;
            border: none;
            width: 100%;
            background: #4a90e2;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 1rem;
        }

        .btn:hover {
            background: #07001f;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Personal Information</h1>
        <form method="POST" action="personal_info.php" enctype="multipart/form-data">
            <!-- Full Name -->
            <div class="input-group">
                <label for="fullName">Full Name:</label>
                <input type="text" name="fullName" id="fullName" required>
            </div>

            <!-- Phone Number -->
            <div class="input-group">
                <label for="phone">Phone Number:</label>
                <input type="text" name="phone" id="phone" required>
            </div>

            <!-- Profile Picture Upload -->
            <div class="file-input">
                <label for="profile_picture">Profile Picture (JPG/PNG only):</label>
                <input type="file" name="profile_picture" id="profile_picture" accept=".jpg, .jpeg, .png">
                <span id="file-name">No file chosen</span>
            </div>

            <!-- Bio -->
            <div class="input-group">
                <label for="bio">Bio:</label>
                <textarea name="bio" id="bio" rows="4" required></textarea>
            </div>

            <!-- Save & Next Button -->
            <button type="submit" class="btn">Save & Next</button>
        </form>
    </div>

    <script>
        // Display the selected file name
        document.getElementById('profile_picture').addEventListener('change', function () {
            const fileName = this.files[0] ? this.files[0].name : 'No file chosen';
            document.getElementById('file-name').textContent = fileName;
        });
    </script>
</body>
</html>
