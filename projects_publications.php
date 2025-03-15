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
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $link = mysqli_real_escape_string($conn, $_POST['link']);

    // Insert or update projects and publications
    $query = "INSERT INTO projects_publications (user_id, title, description, link) 
              VALUES ('$user_id', '$title', '$description', '$link')
              ON DUPLICATE KEY UPDATE title='$title', description='$description', link='$link'";

    if (mysqli_query($conn, $query)) {
        // Redirect to confirmation.php after successful submission
        header("Location: profile.php");
        exit(); // Ensure no further code is executed after redirection
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
    <title>Projects & Publications</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background-color: #c9d6ff;
            background: linear-gradient(to right, #e2e2e2, #c9d6ff);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Projects & Publications Container */
        .container {
            background: #fff;
            width: 450px;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 20px 35px rgba(0, 0, 0, 0.9);
        }

        .container h1 {
            font-size: 1.8rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .container form {
            margin: 0 1rem;
        }

        /* Input Groups */
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
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
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

        /* Save & Next Button */
        .btn {
            font-size: 1.1rem;
            padding: 10px 20px;
            border-radius: 5px;
            outline: none;
            border: none;
            width: 100%;
            background: rgb(125, 125, 235);
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
        <h1>Projects & Publications</h1>
        <form method="POST" action="projects_publications.php">
            <!-- Title -->
            <div class="input-group">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" placeholder="Enter project or publication title" required>
            </div>

            <!-- Description -->
            <div class="input-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description" placeholder="Describe your project or publication" required></textarea>
            </div>

            <!-- Link -->
            <div class="input-group">
                <label for="link">Link (Optional):</label>
                <input type="text" name="link" id="link" placeholder="Enter a link (e.g., GitHub, DOI)">
            </div>

            <!-- Save & Next Button -->
            <button type="submit" class="btn">Save & Next</button>
        </form>
    </div>
</body>
</html>