<?php
session_start();

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

// Query to count songs in each playlist
$sql = "SELECT playlist_name, COUNT(songs.id) AS total_songs
        FROM playlist_songs
        LEFT JOIN songs ON playlist_songs.id = songs.playlist_id
        GROUP BY playlist_name";

$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Songs per Playlist Report</title>
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

        table {
            width: 80%; /* Width of the table */
            margin: auto; /* Center the table */
            border-collapse: collapse; /* Merge borders */
            background: rgba(0, 0, 0, 0.7); /* Semi-transparent black background for the table */
        }

        th, td {
            padding: 15px; /* Padding for table cells */
            border: 1px solid #ff6b6b; /* Border color */
            text-align: center; /* Center text in cells */
        }

        th {
            background-color: #ff6b6b; /* Header background color */
            color: #fff; /* Header text color */
            font-size: 24px; /* Font size for headers */
        }

        td {
            color: #fff; /* Cell text color */
            font-size: 20px; /* Font size for cells */
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
    <h2>Total Songs in Each Playlist</h2>

    <table>
        <tr>
            <th>Playlist Name</th>
            <th>Total Songs</th>
        </tr>
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . htmlspecialchars($row['playlist_name']) . "</td><td>" . $row['total_songs'] . "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No data available</td></tr>";
        }
        ?>
    </table>

    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>
