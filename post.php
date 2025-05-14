<?php include("includes/header.php"); ?>

<?php
$xml = simplexml_load_file("sarahrose.wordpress.2024-12-23.000.xml");

$titleParam = isset($_GET['title']) ? $_GET['title'] : '';

foreach ($xml->channel->item as $item) {
  $title = (string) $item->title;

  if ($title === $titleParam) {
    $dateRaw = (string) $item->pubDate;
    $date = date('F j, Y', strtotime($dateRaw));

    $content = (string) $item->children('content', true)->encoded;
    $content = str_replace(
      [
        'https://sarahrose843606274.files.wordpress.com/',
        'https://sarahrosehassan.com/wp-content/uploads/'
      ],
      '/media/',
      $content
    );

    echo '<main class="post-wrapper">';
    echo '<h1>' . htmlspecialchars($title) . '</h1>';
    echo '<p class="post-date"><em>' . $date . '</em></p>';
    echo '<div class="post-content">' . $content . '</div>';
    echo '</main>';

    break;
  }
}
?>

<?php include("includes/footer.php"); ?>
