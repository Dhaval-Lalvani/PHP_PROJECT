<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Database connection parameters
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "mood_music_db";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $playlist_id = $conn->real_escape_string($_POST['playlist_id']);
    $new_playlist_name = $conn->real_escape_string($_POST['playlist_name']);
    
    // Update the playlist name in the database
    $sql = "UPDATE playlist_songs SET playlist_name = '$new_playlist_name' WHERE id = '$playlist_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: playlist.php");
        exit();
    } else {
        echo "Error updating playlist: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Playlist</title>
</head>
<body>
    <h2>Update Playlist</h2>
    <form action="" method="POST">
        <input type="hidden" name="playlist_id" value="<?php echo $_GET['id']; ?>">
        <label for="playlist_name">New Playlist Name:</label>
        <input type="text" id="playlist_name" name="playlist_name" required><br>
        <button type="submit">Update Playlist</button>
    </form>
    <a href="playlist.php">Back to Playlists</a>
</body>
</html>
