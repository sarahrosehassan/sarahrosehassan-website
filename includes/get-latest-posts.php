<?php
include("load-posts.php");

// Load the latest 3 blog posts from your XML export
$posts = load_blog_posts("sarahrose.wordpress.2024-12-23.000.xml", 3);

foreach ($posts as $post) {
  $preview = strip_tags($post['content']);
  $preview = substr($preview, 0, 100) . '...';
  $url = "post.php?title=" . urlencode($post['title']);

  echo '<a href="' . $url . '" class="post-card">';

  if (!empty($post['thumbnail'])) {
    echo '<img class="thumbnail" src="' . htmlspecialchars($post['thumbnail']) . '" alt="Thumbnail">';
  }

  echo '<div class="post-content">';
  echo '<h3>' . htmlspecialchars($post['title']) . '</h3>';
  echo '<p class="date"><em>' . htmlspecialchars($post['date']) . '</em></p>';
  echo '<p>' . htmlspecialchars($preview) . '</p>';
  echo '</div>';

  echo '</a>';
}
?>
