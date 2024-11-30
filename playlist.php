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

// Initialize an empty array to store playlists
$playlists = [];

// Fetch user's playlists
$sql = "SELECT * FROM playlist_songs WHERE username = '" . $conn->real_escape_string($_SESSION['username']) . "'";
$result = $conn->query($sql);

// Check if the query was successful
if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $playlists[] = $row;
        }
    } else {
        echo "<p class='no-playlists'>You have no playlists yet.</p>"; // Changed to class for styling
    }
} else {
    echo "Error: " . $conn->error;
}

// Delete song from playlist
if (isset($_GET['delete_id'])) {
    $delete_id = $conn->real_escape_string($_GET['delete_id']);
    $delete_sql = "DELETE FROM songs WHERE id = '$delete_id'";
    if ($conn->query($delete_sql) === TRUE) {
        header("Location: playlist.php");
        exit();
    } else {
        echo "Error deleting song: " . $conn->error;
    }
}

// Delete playlist
if (isset($_GET['delete_playlist_id'])) {
    $delete_playlist_id = $conn->real_escape_string($_GET['delete_playlist_id']);
    
    // First, delete songs associated with the playlist
    $delete_songs_sql = "DELETE FROM songs WHERE playlist_id = '$delete_playlist_id'";
    $conn->query($delete_songs_sql); // Ignore errors for song deletion

    // Then, delete the playlist
    $delete_playlist_sql = "DELETE FROM playlist_songs WHERE id = '$delete_playlist_id' AND username = '" . $conn->real_escape_string($_SESSION['username']) . "'";
    if ($conn->query($delete_playlist_sql) === TRUE) {
        header("Location: playlist.php");
        exit();
    } else {
        echo "Error deleting playlist: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Playlists - Mood Based Music Playlist</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('back.jpg') no-repeat center center fixed; /* Add your background image */
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

        .playlist {
            margin-bottom: 30px; /* Increased bottom margin */
            padding: 30px; /* Increased padding */
            border-radius: 10px; /* Increased border radius */
            background: rgba(0, 0, 0, 0.7); /* Semi-transparent black */
            border: 2px solid #ff6b6b; /* Pink border */
            font-size: 24px; /* Increased font size for playlist */
        }

        .playlist h3 {
            color: #ffcc00; /* Bright yellow */
            font-size: 36px; /* Increased font size */
            margin-bottom: 20px; /* Added margin */
        }

        .song {
            margin-bottom: 20px; /* Increased margin */
            font-size: 20px; /* Increased font size for songs */
        }

        a {
            text-decoration: none;
            color: #ffcc00; /* Bright yellow for links */
            font-weight: bold;
            transition: color 0.3s; /* Smooth color transition */
        }

        a:hover {
            color: #ff6b6b; /* Change to pink on hover */
            text-decoration: underline; /* Underline on hover */
        }

        .delete-link {
            color: #ff6b6b; /* Pink */
        }

        .delete-link:hover {
            color: #e55a5a; /* Darker pink on hover */
        }

        .update-link {
            color: #00ffcc; /* Bright cyan */
            margin-left: 15px; /* Space between delete and update links */
        }

        .update-link:hover {
            color: #ffcc00; /* Change to bright yellow on hover */
            text-decoration: underline; /* Underline on hover */
        }

        .logout-link {
            margin-top: 40px; /* Increased margin */
            color: #ff6b6b; /* Pink */
            font-size: 22px; /* Increased font size */
            font-weight: bold;
        }

        .logout-link:hover {
            text-decoration: underline; /* Underline on hover */
        }

        .create-playlist-link {
            margin-top: 40px; /* Increased margin */
            color: #00ffcc; /* Bright cyan */
            font-size: 24px; /* Increased font size */
            font-weight: bold;
            transition: color 0.3s; /* Smooth color transition */
        }

        .create-playlist-link:hover {
            color: #ffcc00; /* Change to bright yellow on hover */
            text-decoration: underline; /* Underline on hover */
        }

        .no-playlists {
            font-size: 28px; /* Increased font size for visibility */
            color: #ff6b6b; /* Pink color for the message */
            margin-top: 50px; /* Increased margin above */
        }
    </style>
</head>
<body>
    <h2>Your Playlists</h2>

    <!-- Link to create a new playlist -->
    <p class="create-playlist-link"><a href="create_playlist.php">Create a New Playlist</a></p>

    <!-- Link to go back to the dashboard -->
    <p><a href="dashboard.php">Back to Dashboard</a></p>

    <?php foreach ($playlists as $playlist): ?>
        <div class="playlist">
            <h3><?php echo htmlspecialchars($playlist['playlist_name']); ?></h3>

            <!-- Link to add a song to the playlist -->
            <p><a href="add_song.php?playlist_id=<?php echo $playlist['id']; ?>">Add Song</a></p>

            <a class="delete-link" href="playlist.php?delete_playlist_id=<?php echo $playlist['id']; ?>"><strong>Delete Playlist</strong></a>

            <?php
            // Fetch songs for the current playlist
            $conn = new mysqli($servername, $db_username, $db_password, $dbname);
            $songs_sql = "SELECT * FROM songs WHERE playlist_id = '" . $playlist['id'] . "'";
            $songs_result = $conn->query($songs_sql);
            if ($songs_result && $songs_result->num_rows > 0): ?>
                <h4>Songs in this Playlist:</h4>
                <?php while ($song = $songs_result->fetch_assoc()): ?>
                    <div class="song">
                        <p><strong><?php echo htmlspecialchars($song['song_name']); ?></strong></p>
                        <p>Artist: <?php echo htmlspecialchars($song['artist']); ?></p>
                        <p>
                            <a href="<?php echo htmlspecialchars($song['spotify_link']); ?>" target="_blank">Listen on Spotify</a>
                        </p>
                        <br>
                        <a class="delete-link" href="playlist.php?delete_id=<?php echo $song['id']; ?>"><strong>Delete</strong></a>
                        <a class="update-link" href="update_song.php?song_id=<?php echo $song['id']; ?>"><strong>Update</strong></a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No songs added to this playlist yet.</p>
            <?php endif; ?>

            <?php $conn->close(); ?>
        </div>
    <?php endforeach; ?>

    <p class="logout-link"><a href="logout.php">Logout</a></p>
</body>
</html>
