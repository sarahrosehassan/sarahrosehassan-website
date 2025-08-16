<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "sarahrosehassan_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all blog posts
$sql = "SELECT * FROM blog_posts ORDER BY date DESC";
$result = $conn->query($sql);
?>

<h1>Manage Blog Posts</h1>
<table border="1" cellpadding="10">
    <tr>
        <th>Title</th>
        <th>Date</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['date']) ?></td>
            <td>
                <a href="edit-blog-post.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="delete-blog-post.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<?php $conn->close(); ?>