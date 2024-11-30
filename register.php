<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // XAMPP default username
$password = ""; // XAMPP default password
$dbname = "mood_music_db"; // Change this to your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form input
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    
    // Insert the user into the database
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    
    if ($conn->query($sql) === TRUE) {
        // Registration successful, redirect to login page
        header("Location: login.html"); // Redirect to login page
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Mood Based Music Playlist</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('back.jpg') no-repeat center center fixed; /* Add your background image */
            background-size: cover; /* Ensure the image covers the whole background */
            color: #fff;
            text-align: center;
            padding: 50px;
        }

        h2 {
            font-size: 48px;
            color: #ffcc00; /* Bright yellow */
            text-shadow: 3px 3px 5px #ff00ff; /* Neon pink shadow */
            margin-bottom: 30px;
        }

        label {
            font-size: 20px;
            margin-top: 20px;
            display: block; /* Stack the labels */
        }

        input[type="text"],
        input[type="password"] {
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            width: 300px;
            font-size: 16px;
        }

        button {
            padding: 10px 20px;
            background-color: #ff6b6b; /* Button color */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5); /* Subtle shadow */
            margin-top: 10px; /* Space above the button */
        }

        button:hover {
            background-color: #e55a5a; /* Darker color on hover */
            transform: scale(1.05); /* Slightly enlarge on hover */
        }

        p {
            font-size: 18px;
            color: #ddd; /* Light grey text */
            margin-top: 20px;
        }

        a {
            color: #ffcc00; /* Bright yellow for links */
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline; /* Underline on hover */
        }
    </style>
</head>
<body>
    <h2>Register</h2>
    <form action="" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        
        <button type="submit">Register</button> <!-- Button is now directly below the password input -->
    </form>
    <p>Already have an account? <a href="login.html">Login here</a></p>
</body>
</html>
