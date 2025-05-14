<?php include("includes/header.php"); ?>

<h1>📚 All Blog Posts</h1>

<?php
include("includes/load-posts.php");

// Load all posts (no limit)
$posts = load_blog_posts("sarahrose.wordpress.2024-12-23.000.xml");
?>

<div class="post-list">
  <?php foreach ($posts as $post): ?>
    <?php
      $title = $post['title'];
      $date = $post['date'];
      $content = $post['content'];
      $thumbnail = $post['thumbnail'];
      $preview = substr(strip_tags($content), 0, 100) . '...';
    ?>

    <a href="post.php?title=<?= urlencode($title) ?>" class="post-card vertical">
      <?php if (!empty($thumbnail)): ?>
        <img class="thumbnail" src="<?= htmlspecialchars($thumbnail) ?>" alt="Thumbnail">
      <?php endif; ?>

      <div class="post-content">
        <h3><?= htmlspecialchars($title) ?></h3>
        <p class="date"><em><?= htmlspecialchars($date) ?></em></p>
        <p><?= htmlspecialchars($preview) ?></p>
      </div>
    </a>

  <?php endforeach; ?>
</div>

<?php include("includes/footer.php"); ?>
