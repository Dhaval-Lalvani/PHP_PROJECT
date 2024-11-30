<?php
// Start the session
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['username'])) { // Changed to username
    header("Location: login.html");
    exit();
}

// Get user username from session
$username = $_SESSION['username']; // Changed to username
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Mood Based Music Playlist</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('back.jpg') no-repeat center center fixed; /* Add your background image */
            background-size: cover; /* Ensure the image covers the whole background */
            color: #fff;
            text-align: center;
            padding: 50px;
        }

        h1 {
            font-size: 48px;
            color: #ffcc00; /* Bright yellow */
            text-shadow: 3px 3px 5px #ff00ff; /* Neon pink shadow */
            margin-bottom: 40px;
        }

        .welcome-message {
            font-size: 28px;
            color: #ff6699; /* Soft pink */
            font-family: 'Georgia', serif;
            margin-bottom: 30px;
            font-weight: bold;
        }

        p {
            font-size: 20px;
            color: #ddd;
            margin-bottom: 20px;
        }

        a {
            color: #fff; /* White text for links */
            background-color: #3d3d3d; /* Dark gray background for links */
            padding: 12px 24px;
            border-radius: 5px;
            font-size: 22px; /* Bigger font size for links */
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 15px;
            transition: background-color 0.3s, transform 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5); /* Subtle shadow */
        }

        a:hover {
            background-color: #ff6699; /* Pink on hover */
            transform: scale(1.05); /* Slightly enlarge on hover */
        }

        .logout-button {
            margin-top: 50px; /* More space at the bottom */
            padding: 15px 30px; /* Bigger button */
            background-color: #ff6b6b; /* Button color */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5); /* Subtle shadow */
        }

        .logout-button:hover {
            background-color: #e55a5a; /* Darker color on hover */
            transform: scale(1.05); /* Slightly enlarge on hover */
        }

        .report-links {
            margin-top: 50px;
            font-size: 22px;
        }

        .report-links h2 {
            color: #ffcc00; /* Bright yellow for the reports section */
            text-shadow: 1px 1px 3px #ff00ff; /* Neon pink shadow */
            margin-bottom: 20px;
        }

        .report-links a {
            color: #fff; /* White text for report links */
            background-color: #1a1a1a; /* Very dark gray for contrast */
            padding: 12px 24px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: block;
            font-size: 20px;
            font-weight: bold;
            text-shadow: 1px 1px 3px #000; /* Subtle shadow */
            transition: background-color 0.3s, transform 0.3s;
        }

        .report-links a:hover {
            background-color: #ff6699; /* Pink on hover */
            transform: scale(1.1); /* Enlarge on hover */
        }

    </style>
</head>
<body>
    <h1>Welcome to Your Music Dashboard</h1>
    
    <p class="welcome-message">Hello, <?php echo $username; ?>! Manage your playlists .</p>
    
    <p>
        <a href="playlist.php">Go to Your Playlists</a>
    </p>

    <div class="report-links">
        <h2>Reports</h2>
        <a href="report_songs_per_playlist.php">Total Songs per Playlist</a>
        <a href="report_most_added_artist.php">Most Added Artist</a>
        <a href="report_playlists_per_user.php">Playlists per User</a>
    </div>

    <form action="logout.php" method="POST">
        <button type="submit" class="logout-button">Logout</button>
    </form>
</body>
</html>
