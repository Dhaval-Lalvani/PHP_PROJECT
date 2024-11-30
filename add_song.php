<?php
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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $playlist_id = $conn->real_escape_string($_POST['playlist_id']);
    $song_name = $conn->real_escape_string($_POST['song_name']);
    $artist = $conn->real_escape_string($_POST['artist']);
    $spotify_link = $conn->real_escape_string($_POST['spotify_link']);

    // Insert song into the database
    $sql = "INSERT INTO songs (playlist_id, song_name, artist, spotify_link) VALUES ('$playlist_id', '$song_name', '$artist', '$spotify_link')";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect back to playlist.php after successful addition
        header("Location: playlist.php");
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
    <title>Add Song</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('back.jpg') no-repeat center center fixed; /* Add your background image */
            background-size: cover; /* Ensure the image covers the whole background */
            color: #fff; /* White text */
            padding: 40px; /* Padding around the content */
            text-align: center; /* Centered text */
        }

        h2 {
            font-size: 60px; /* Increased font size */
            color: #ffcc00; /* Bright yellow */
            text-shadow: 3px 3px 5px #ff00ff; /* Neon pink shadow */
            margin-bottom: 40px; /* Increased margin below */
        }

        label {
            font-size: 24px; /* Increased font size for label */
            color: #ffcc00; /* Bright yellow */
        }

        input[type="text"],
        input[type="url"] {
            width: 300px; /* Fixed width */
            padding: 10px; /* Padding inside the input */
            margin: 20px 0; /* Margin above and below */
            border: none; /* Remove default border */
            border-radius: 5px; /* Rounded corners */
            background-color: rgba(255, 255, 255, 0.7); /* Semi-transparent background */
            color: #333; /* Dark text color */
            font-size: 20px; /* Increased font size */
        }

        button {
            padding: 10px 20px; /* Padding for the button */
            font-size: 20px; /* Increased font size */
            background-color: #ff6b6b; /* Pink background */
            color: white; /* White text */
            border: none; /* Remove default border */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            transition: background-color 0.3s; /* Smooth transition for background color */
        }

        button:hover {
            background-color: #ffcc00; /* Change to yellow on hover */
        }

        a {
            color: #00ffcc; /* Bright cyan */
            font-size: 20px; /* Increased font size for links */
            margin-top: 20px; /* Space above link */
            display: inline-block; /* Make it inline-block for spacing */
            text-decoration: none; /* Remove underline */
            transition: color 0.3s; /* Smooth color transition */
        }

        a:hover {
            color: #ffcc00; /* Change to bright yellow on hover */
            text-decoration: underline; /* Underline on hover */
        }
    </style>
</head>
<body>
    <h2>Add a Song to the Playlist</h2>
    <form action="" method="POST">
        <!-- Ensure playlist_id is correctly passed in the hidden input -->
        <input type="hidden" name="playlist_id" value="<?php echo htmlspecialchars($_GET['playlist_id']); ?>">
        
        <label for="song_name">Song Name:</label><br>
        <input type="text" id="song_name" name="song_name" required><br>

        <label for="artist">Artist:</label><br>
        <input type="text" id="artist" name="artist" required><br>

        <label for="spotify_link">Spotify Link:</label><br>
        <input type="url" id="spotify_link" name="spotify_link" required><br>

        <button type="submit">Add Song</button>
    </form>

    <a href="playlist.php">Back to Playlists</a>
</body>
</html>
