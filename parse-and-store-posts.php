<?php
// Database connection
$conn = new mysqli("localhost", "saranplc", "3MPqX6SzZCDp7je@", "saranplc_website_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Include the load-posts function
include("includes/load-posts.php");

// Path to your XML file
$xml_file_path = "sarahrose.wordpress.2024-12-23.000.xml";

// Load and parse blog posts
$posts = load_blog_posts($xml_file_path);

// Insert posts into the database
foreach ($posts as $post) {
    $title = $conn->real_escape_string($post['title']);
    $date = date('Y-m-d', strtotime($post['date'])); // Format date for MySQL
    $content = $conn->real_escape_string($post['content']);
    $thumbnail = $conn->real_escape_string($post['thumbnail'] ?? null);

    // Check if the post already exists in the database
    $check_query = "SELECT id FROM blog_posts WHERE title = '$title' AND date = '$date'";
    $result = $conn->query($check_query);

    if ($result->num_rows === 0) {
        // Insert the post if it doesn't already exist
        $insert_query = "INSERT INTO blog_posts (title, date, content, thumbnail) 
                         VALUES ('$title', '$date', '$content', '$thumbnail')";
        if ($conn->query($insert_query) === TRUE) {
            echo "Inserted: $title<br>";
        } else {
            echo "Error inserting $title: " . $conn->error . "<br>";
        }
    } else {
        echo "Skipped (already exists): $title<br>";
    }
}

// Close the database connection
$conn->close();
?>