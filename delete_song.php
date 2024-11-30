<?php
// Start the session
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

// Get the song ID from the URL
$song_id = $_GET['id'];

// Delete the song from the database
$delete_sql = "DELETE FROM songs WHERE id = ?";
$stmt = $conn->prepare($delete_sql);
$stmt->bind_param("i", $song_id);

if ($stmt->execute()) {
    // Redirect to the playlist page after successful deletion
    header("Location: playlist.php");
    exit();
} else {
    echo "Error deleting song: " . $conn->error;
}

$conn->close();
?>
