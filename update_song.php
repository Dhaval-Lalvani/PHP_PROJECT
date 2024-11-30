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

// Initialize variables
$song_name = $artist = $spotify_link = '';
$song_id = $_GET['song_id'] ?? null;

// Fetch song details if song_id is provided
if ($song_id) {
    $song_id = $conn->real_escape_string($song_id);
    $sql = "SELECT * FROM songs WHERE id = '$song_id'";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $song = $result->fetch_assoc();
        $song_name = $song['song_name'];
        $artist = $song['artist'];
        $spotify_link = $song['spotify_link'];
    } else {
        echo "Song not found.";
    }
}

// Update song details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_song_name = $conn->real_escape_string($_POST['song_name']);
    $new_artist = $conn->real_escape_string($_POST['artist']);
    $new_spotify_link = $conn->real_escape_string($_POST['spotify_link']);
    
    $update_sql = "UPDATE songs SET song_name='$new_song_name', artist='$new_artist', spotify_link='$new_spotify_link' WHERE id='$song_id'";
    
    if ($conn->query($update_sql) === TRUE) {
        header("Location: playlist.php");
        exit();
    } else {
        echo "Error updating song: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Song - Mood Based Music Playlist</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('back.jpg') no-repeat center center fixed; /* Background image */
            background-size: cover; /* Ensure the image covers the whole background */
            color: #fff; /* White text */
            padding: 40px; /* Increased padding */
            text-align: center; /* Center the text */
        }
        
        h2 {
            font-size: 60px; /* Increased font size */
            color: #ffcc00; /* Bright yellow */
            text-shadow: 3px 3px 5px #ff00ff; /* Neon pink shadow */
            margin-bottom: 40px; /* Increased margin below */
        }

        form {
            margin: auto; /* Center the form */
            max-width: 400px; /* Maximum width of the form */
            background: rgba(0, 0, 0, 0.7); /* Semi-transparent black background */
            padding: 20px; /* Padding inside the form */
            border-radius: 10px; /* Rounded corners */
            border: 2px solid #ff6b6b; /* Pink border */
        }

        label {
            font-size: 20px; /* Font size for labels */
            display: block; /* Block display for labels */
            margin-bottom: 10px; /* Margin below labels */
        }

        input[type="text"],
        input[type="url"],
        input[type="submit"] {
            font-size: 18px; /* Font size for input fields */
            padding: 10px; /* Padding inside input fields */
            width: 100%; /* Full width of the input fields */
            margin-bottom: 20px; /* Margin below input fields */
            border-radius: 5px; /* Rounded corners for input fields */
            border: 1px solid #ff6b6b; /* Border color for input fields */
        }

        input[type="submit"] {
            background-color: #ff6b6b; /* Button background color */
            color: #fff; /* Button text color */
            cursor: pointer; /* Pointer cursor on hover */
            transition: background-color 0.3s; /* Smooth background color transition */
        }

        input[type="submit"]:hover {
            background-color: #e55a5a; /* Darker shade on hover */
        }

        a {
            color: #ffcc00; /* Bright yellow for links */
            font-weight: bold; /* Bold font for links */
            text-decoration: none; /* Remove underline */
            margin-top: 20px; /* Margin above link */
            display: inline-block; /* Block display for link */
        }

        a:hover {
            text-decoration: underline; /* Underline on hover */
        }
    </style>
</head>
<body>
    <h2>Update Song</h2>
    <form action="" method="POST">
        <label for="song_name">Song Name:</label>
        <input type="text" name="song_name" id="song_name" value="<?php echo htmlspecialchars($song_name); ?>" required>

        <label for="artist">Artist:</label>
        <input type="text" name="artist" id="artist" value="<?php echo htmlspecialchars($artist); ?>" required>

        <label for="spotify_link">Spotify Link:</label>
        <input type="url" name="spotify_link" id="spotify_link" value="<?php echo htmlspecialchars($spotify_link); ?>" required>

        <input type="submit" value="Update Song">
    </form>

    <p><a href="playlist.php">Back to Playlists</a></p>
</body>
</html>
