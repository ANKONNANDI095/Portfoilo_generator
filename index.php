<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Generator</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet"> <!-- Stylish fonts -->
    <style>
        /* Basic styling */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', sans-serif; /* Modern font for paragraph */
            height: 100vh;
            background: url('images/flat-lay-workstation-with-copy-space-laptop.jpg') no-repeat center center/cover; /* Full-page background image */
            display: flex;
            align-items: center;
            justify-content: flex-start; /* Align content to the left */
            overflow: hidden; /* Prevent scrolling */
            position: relative;
        }

        /* Lighter gradient overlay */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(106, 90, 205, 0.4), rgba(147, 112, 219, 0.4)); /* Lighter indigo to lighter purple gradient */
            animation: gradientAnimation 10s infinite alternate;
            z-index: 1;
        }

        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }
            100% {
                background-position: 100% 50%;
            }
        }

        /* Left section with text (40% width) */
        .left-section {
            width: 40%; /* 40% of the screen width */
            height: 100vh; /* Full height */
            background: rgba(15, 11, 11, 0.7); /* Semi-transparent mask */
            color: #f0f0f0; /* Light gray text color */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px; /* Adjusted padding */
            text-align: center;
            border-right: 2px solid rgba(255, 255, 255, 0.1); /* Subtle border for separation */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5); /* Shadow for depth */
            backdrop-filter: blur(5px); /* Blur effect */
            z-index: 2; /* Ensure it's above the gradient overlay */
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transition for hover effect */
        }

        /* Hover effect on the mask */
        .left-section:hover {
            transform: translateX(10px); /* Slight movement on hover */
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.7); /* Enhanced shadow on hover */
        }

        .left-section h1 {
            font-size: 5em; /* Very large font size for heading */
            margin-bottom: 20px;
            font-family: 'Playfair Display', serif; /* Special font for heading */
            font-weight: bold; /* Bold text */
            transition: text-shadow 0.3s ease; /* Smooth transition for glow effect */
        }

        .left-section p {
            font-size: 1.5em; /* Smaller font size for paragraph */
            margin-bottom: 30px;
            font-weight: bold; /* Bold text */
            transition: text-shadow 0.3s ease; /* Smooth transition for glow effect */
        }

        /* Neon glow effect on hover */
        .left-section h1:hover,
        .left-section p:hover {
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.8), 0 0 20px rgba(255, 255, 255, 0.6), 0 0 30px rgba(255, 255, 255, 0.4); /* Neon glow effect */
        }

        /* Sign-in button */
        .sign-in-btn {
            color: white;
            text-decoration: none;
            font-size: 20px; /* Larger font size */
            padding: 15px 30px; /* Larger padding */
            background: #ff7b00;
            border-radius: 5px;
            transition: transform 0.3s ease, background 0.3s ease, box-shadow 0.3s ease; /* Smooth transition for pop-up effect */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); /* Shadow for the button */
            position: relative;
            overflow: hidden;
            font-weight: bold; /* Bold text */
        }

        /* Pulsating animation for the button */
        .sign-in-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300%;
            height: 300%;
            background: rgba(255, 255, 255, 0.1);
            transform: translate(-50%, -50%) scale(0);
            border-radius: 50%;
            transition: transform 0.5s ease;
            z-index: 0;
        }

        .sign-in-btn:hover::before {
            transform: translate(-50%, -50%) scale(1);
        }

        .sign-in-btn:hover {
            background: #e06900;
            transform: scale(1.1); /* Pop-up effect */
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.3); /* Enhanced shadow on hover */
        }

        /* Decorative circles */
        .decorative-circle {
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            z-index: 1;
            animation: float 6s infinite ease-in-out;
        }

        .circle-1 {
            top: 10%;
            left: 70%;
            animation-delay: 0s;
        }

        .circle-2 {
            top: 60%;
            left: 20%;
            animation-delay: 2s;
        }

        .circle-3 {
            top: 40%;
            left: 80%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }
    </style>
</head>
<body>
    <!-- Left Section (40% width) -->
    <div class="left-section">
        <h1>Portfolio Generator</h1>
        <p>"Create a stunning portfolio based on your information with ease. 
        Showcase your work, skills, and achievements in a visually appealing way".</p>
        <a href="login.php" class="sign-in-btn">Start Creating</a>
    </div>

    <!-- Decorative circles -->
    <div class="decorative-circle circle-1"></div>
    <div class="decorative-circle circle-2"></div>
    <div class="decorative-circle circle-3"></div>
</body>
</html>
