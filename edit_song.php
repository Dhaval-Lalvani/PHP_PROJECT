<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Database connection
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "mood_music_db";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the song ID from the URL
$song_id = $_GET['id'];

// Fetch the current song details
$sql = "SELECT * FROM songs WHERE id = $song_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $song = $result->fetch_assoc();
} else {
    echo "Song not found.";
    exit();
}

// Handle form submission for updating the song
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $song_name = $conn->real_escape_string($_POST['song_name']);
    $artist = $conn->real_escape_string($_POST['artist']);
    $spotify_link = $conn->real_escape_string($_POST['spotify_link']);

    // Update query
    $update_sql = "UPDATE songs SET song_name = '$song_name', artist = '$artist', spotify_link = '$spotify_link' WHERE id = $song_id";

    if ($conn->query($update_sql) === TRUE) {
        echo "Song updated successfully!";
        header("Location: playlist.php");
        exit();
    } else {
        echo "Error updating song: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Song</title>
</head>
<body>
    <h2>Edit Song</h2>

    <form action="" method="POST">
        <label for="song_name">Song Name:</label>
        <input type="text" id="song_name" name="song_name" value="<?php echo htmlspecialchars($song['song_name']); ?>" required><br><br>

        <label for="artist">Artist:</label>
        <input type="text" id="artist" name="artist" value="<?php echo htmlspecialchars($song['artist']); ?>" required><br><br>

        <label for="spotify_link">Spotify Link:</label>
        <input type="text" id="spotify_link" name="spotify_link" value="<?php echo htmlspecialchars($song['spotify_link']); ?>" required><br><br>

        <input type="submit" value="Update Song">
    </form>

    <a href="playlist.php">Back to Playlist</a>
</body>
</html>

<?php $conn->close(); ?>
