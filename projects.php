<?php
function get_github_stars($repo) {
  if (!$repo) {
    return "N/A"; // Return "N/A" for non-GitHub projects
  }

  $url = "https://api.github.com/repos/$repo";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'YourAppName');
  $response = curl_exec($ch);
  curl_close($ch);

  $data = json_decode($response, true);
  return $data['stargazers_count'] ?? "N/A";
}
?>

<?php include("includes/header.php"); ?>
<link rel="stylesheet" href="assets/css/projects.css">

<main class="projects">
  <h1>Software Projects</h1>
  <p>Open-source projects I've worked on, including apps, games, and tools.</p>

  <!-- Project 1 -->
  <div class="project-card">
    <img src="media/Projects/encrypt.png" alt="File Encrypter Preview" class="project-image" />
    <div class="project-info">
      <h3>File Encrypter</h3>
      <p class="tech">Python</p>
      <p>Encrypts and decrypts computer files.</p>
      <div class="project-meta">
        <span class="stars">⭐ <?= get_github_stars('sarahrosehassan/encrypt-file') ?></span>
        <a href="https://github.com/sarahrosehassan/encrypt-file" target="_blank">Source</a>
      </div>
    </div>
  </div>

  <!-- Project 2 -->
  <div class="project-card">
    <img src="assets/images/listcalc.png" alt="List Calculator Preview" class="project-image" />
    <div class="project-info">
      <h3>List Calculator</h3>
      <p class="tech">Python</p>
      <p>Adds, subtracts, multiplies, and divides lists.</p>
      <div class="project-meta">
        <span class="stars">⭐ <?= get_github_stars('sarahrosehassan/cauchy-list') ?></span>
        <a href="https://github.com/sarahrosehassan/cauchy-list" target="_blank">Source</a>
      </div>
    </div>
  </div>

  <!-- Project 3 -->
  <div class="project-card">
    <img src="assets/images/prime.png" alt="Prime Number Searcher Preview" class="project-image" />
    <div class="project-info">
      <h3>Prime Number Searcher</h3>
      <p class="tech">Java</p>
      <p>Finds the 1st–30,000th prime number under 1 minute.</p>
      <div class="project-meta">
        <span class="stars">⭐ <?= get_github_stars('sarahrosehassan/prime-numbers') ?></span>
        <a href="https://github.com/sarahrosehassan/prime-numbers" target="_blank">GitHub Repo</a>
      </div>
    </div>
  </div>

  <!-- Project 4 -->
  <div class="project-card">
    <img src="assets/images/animal-match.png" alt="Animal Matching Game Preview" class="project-image" />
    <div class="project-info">
      <h3>Animal Matching Game</h3>
      <p class="tech">C#, .NET</p>
      <p>Time-based game to match animal symbols on a timer.</p>
      <div class="project-meta">
        <span class="stars">⭐ <?= get_github_stars('sarahrosehassan/animal-matching-game') ?></span>
        <a href="https://github.com/sarahrosehassan/animal-matching-game" target="_blank">GitHub Repo</a>
        <a href="https://www.youtube.com/watch?v=9JtIz1rOfUY" target="_blank">Watch Demo</a>
      </div>
    </div>
  </div>
</main>

<?php include("includes/footer.php"); ?>
