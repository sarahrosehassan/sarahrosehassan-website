<?php
$pageClass = '';
if (isset($_GET['title']) && $_GET['title'] === 'About') {
  $pageClass = 'about-page';
}
?>

<!DOCTYPE html>
<html lang="en">
  
<head>
  <meta charset="UTF-8">
  <title>Sarah Rose - Software Engineer & Youtuber </title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- Favicons -->
  <link rel="apple-touch-icon" sizes="180x180" href="/media/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/media/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/media/favicon/favicon-16x16.png">
  <link rel="manifest" href="/media/favicon/site.webmanifest">
  <link rel="shortcut icon" type="image/x-icon" href="/media/favicon/favicon.ico">
</head>
<body>

<div class="layout">
  <aside class="sidebar">
    <div class="sidebar-inner">
      <a href="index.php" class="site-branding">
        <img src="/media/favicon/website-icon.png" alt="Sarah Rose Icon" class="site-icon" />
        <h2 class="site-title">Sarah Rose</h2>
      </a>
      
      <nav id="site-nav">
        <ul>
          <li><a href="show-posts.php" class="<?= basename($_SERVER['PHP_SELF']) == 'show-posts.php' ? 'active' : '' ?>">Blog</a></li>
          <li><a href="projects.php" class="<?= basename($_SERVER['PHP_SELF']) == 'projects.php' ? 'active' : '' ?>">Projects</a></li>
          <li><a href="post.php?title=About" class="<?= basename($_SERVER['PHP_SELF']) == 'post.php' && $_GET['title'] === 'About' ? 'active' : '' ?>">About</a></li>
          <li><a href="resume.php" class="<?= basename($_SERVER['PHP_SELF']) == 'resume.php' ? 'active' : '' ?>">Resume</a></li>
          <li><a href="contact.php" class="<?= basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : '' ?>">Contact</a></li>
        </ul>
      </nav>

      <div class="social-icons">
        <a href="https://linkedin.com/in/sarahrosehassan" target="_blank">
          <i class="fab fa-linkedin"></i>
        </a>
        <a href="https://github.com/sarahrosehassan" target="_blank">
          <i class="fab fa-github"></i>
        </a>
        <a href="https://youtube.com/@sarahrosehassan" target="_blank">
          <i class="fab fa-youtube"></i>
        </a>
        <a href="https://instagram.com/sarahrosehassan" target="_blank">
          <i class="fab fa-instagram"></i>
        </a>
      </div>
    </div>
  </aside>

  <main class="content">
    <!-- page content starts here -->
