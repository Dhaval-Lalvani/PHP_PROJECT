<?php
// Start the session
session_start();

// Database connection parameters
$servername = "localhost"; // Usually localhost
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password is usually empty
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
    $username = $conn->real_escape_string($_POST['username']); // Changed to username
    $password = $conn->real_escape_string($_POST['password']);

    // Simple SQL query to find the user
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'"; // Changed email to username
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found
        $_SESSION['username'] = $username; // Store username in session
        header("Location: dashboard.php"); // Redirect to dashboard or home page
        exit();
    } else {
        // User not found
        echo "<script>alert('Invalid username or password.'); window.location.href='login.html';</script>";
    }
}

$conn->close();
?>
