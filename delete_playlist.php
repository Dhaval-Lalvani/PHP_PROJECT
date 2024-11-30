<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Database connection parameters
$servername = "localhost";
$db_username = "root"; // XAMPP default username
$db_password = ""; // XAMPP default password
$dbname = "mood_music_db"; // Your database name

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the playlist ID is set
if (isset($_GET['id'])) {
    $playlist_id = $conn->real_escape_string($_GET['id']);
    
    // Delete the playlist from the database
    $sql = "DELETE FROM playlist_songs WHERE playlist_id='$playlist_id' AND username='" . $_SESSION['username'] . "'";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: playlist.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
