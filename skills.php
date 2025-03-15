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
    $soft_skills = mysqli_real_escape_string($conn, $_POST['soft_skills']);
    $technical_skills = mysqli_real_escape_string($conn, $_POST['technical_skills']);

    // Insert or update skills
    $query = "INSERT INTO skills (user_id, soft_skills, technical_skills) 
              VALUES ('$user_id', '$soft_skills', '$technical_skills')
              ON DUPLICATE KEY UPDATE soft_skills='$soft_skills', technical_skills='$technical_skills'";

    if (mysqli_query($conn, $query)) {
        header("Location: academic_background.php");
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
    <title>Skills</title>
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

        /* Skills Container */
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

        .input-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            resize: vertical;
            min-height: 100px;
        }

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
        <h1>Skills</h1>
        <form method="POST" action="skills.php">
            <!-- Soft Skills -->
            <div class="input-group">
                <label for="soft_skills">Soft Skills (e.g., Communication, Teamwork):</label>
                <textarea name="soft_skills" id="soft_skills" placeholder="Enter your soft skills" required></textarea>
            </div>

            <!-- Technical Skills -->
            <div class="input-group">
                <label for="technical_skills">Technical Skills (e.g., Python, JavaScript):</label>
                <textarea name="technical_skills" id="technical_skills" placeholder="Enter your technical skills" required></textarea>
            </div>

            <!-- Save & Next Button -->
            <button type="submit" class="btn">Save & Next</button>
        </form>
    </div>
</body>
</html>