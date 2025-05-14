<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "sarahrosehassan_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the blog post
$id = intval($_GET['id']);
$sql = "SELECT * FROM blog_posts WHERE id = $id";
$result = $conn->query($sql);
$post = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update the blog post
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $date = $conn->real_escape_string($_POST['date']);
    $thumbnail = $conn->real_escape_string($_POST['thumbnail']);

    $update_sql = "UPDATE blog_posts SET title = '$title', content = '$content', date = '$date', thumbnail = '$thumbnail' WHERE id = $id";
    if ($conn->query($update_sql) === TRUE) {
        echo "Blog post updated successfully!";
    } else {
        echo "Error updating blog post: " . $conn->error;
    }
}
?>

<h1>Edit Blog Post</h1>
<form method="POST">
    <label for="title">Title</label>
    <input type="text" id="title" name="title" value="<?= htmlspecialchars($post['title']) ?>" required><br>

    <label for="content">Content</label>
    <textarea id="content" name="content" rows="10" required><?= htmlspecialchars($post['content']) ?></textarea><br>

    <label for="date">Date</label>
    <input type="date" id="date" name="date" value="<?= htmlspecialchars($post['date']) ?>" required><br>

    <label for="thumbnail">Thumbnail</label>
    <input type="text" id="thumbnail" name="thumbnail" value="<?= htmlspecialchars($post['thumbnail']) ?>"><br>

    <button type="submit">Update Post</button>
</form>

<?php $conn->close(); ?>