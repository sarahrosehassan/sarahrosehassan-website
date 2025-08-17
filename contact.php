<?php
session_start();
include("includes/header.php"); 
?>
<?php
// Contact Page – Sarah Rose Hassan
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Me</title>
  <style>
    body { 
      font-family: sans-serif; 
      background: #ffffff; /* Pure white background */
      margin: 0; 
      padding: 0; 
      color: #333; 
    }
    .container { max-width: 700px; margin: auto; padding: 4rem 2rem; }
    h1 { text-align: center; margin-bottom: 1rem; font-size: 2.5rem; }
    p { text-align: center; margin-bottom: 2rem; font-size: 1.1rem; }
    form { background: #fff; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
    input, textarea { 
      width: 100%; 
      padding: 0.75rem; 
      margin-bottom: 1.5rem; 
      border: 1px solid #ccc; /* Grey border */
      border-radius: 6px; 
      font-size: 1rem; 
    }
    button { 
      background: #333; /* Dark grey button */
      color: white; 
      padding: 0.75rem 1.5rem; 
      border: none; 
      border-radius: 5px; 
      font-size: 1rem; 
      cursor: pointer; 
    }
    button:hover { background: #e75480; /* Darker pink on hover */ }
    .success { 
      background: #e6ffe6; /* Light green background */
      padding: 1rem; 
      border-left: 4px solid #4caf50; /* Green border */
      margin-bottom: 1rem; 
    }
    .error { 
      background: #ffe6e6; /* Light red background */
      padding: 1rem; 
      border-left: 4px solid #f44336; /* Red border */
      margin-bottom: 1rem; 
    }
    a { color: #333; text-decoration: none; }
    a:hover { text-decoration: underline; }
    
    /* Honeypot field - hidden from users but visible to bots */
    .honeypot { 
      position: absolute; 
      left: -9999px; 
      width: 1px; 
      height: 1px; 
      overflow: hidden; 
    }
    
    .captcha {
      background: #f9f9f9;
      padding: 1rem;
      border: 1px solid #ddd;
      border-radius: 6px;
      margin-bottom: 1.5rem;
    }
    
    .captcha input {
      width: 100px;
      margin-bottom: 0;
    }
    
    .whatsapp-link {
      color: #25D366;
      font-weight: bold;
    }
    
    .whatsapp-link:hover {
      color: #128C7E;
    }
    
    #whatsapp-contact {
      color: #25D366;
      font-weight: bold;
      cursor: pointer;
      text-decoration: underline;
    }
      margin-bottom: 0;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Contact Me</h1>
    <p>
      Have a question, collaboration idea, or just want to say hi?  
      Use the form below or email me at <a href="mailto:contact@sarahrosehassan.com">contact@sarahrosehassan.com</a> for any inquiries.<br><br>
      
      For urgent matters, you can also reach me via WhatsApp Business at <span id="whatsapp-contact">click to reveal</span>.
    </p>

    <script>
    // Obfuscated phone number to prevent scraping
    document.addEventListener('DOMContentLoaded', function() {
      const phoneElement = document.getElementById('whatsapp-contact');
      
      // Base64 encoded phone data to prevent scraping
      const encodedData = 'aHR0cHM6Ly93YS5tZS8xNjQ3NDc0NDU0MQ=='; // https://wa.me/16474744541
      const phoneUrl = atob(encodedData);
      const displayNumber = '+1 (647) 474-4541';
      
      phoneElement.innerHTML = '<a href="' + phoneUrl + '" target="_blank" class="whatsapp-link">' + 
                               displayNumber + '</a>';
      phoneElement.style.cursor = 'pointer';
    });
    </script>


    <?php
    // Function to check if submission is too frequent
    function checkRateLimit() {
      $lastSubmission = $_SESSION['last_submission'] ?? 0;
      $currentTime = time();
      return ($currentTime - $lastSubmission) > 30; // 30 seconds between submissions
    }
    
    // Function to validate email content for spam patterns
    function isSpamContent($message, $name, $email) {
      $spamKeywords = ['seo', 'marketing', 'casino', 'loan', 'viagra', 'pharmacy', 'bitcoin', 'crypto', 'investment', 'business opportunity'];
      $message_lower = strtolower($message . ' ' . $name);
      
      foreach ($spamKeywords as $keyword) {
        if (strpos($message_lower, $keyword) !== false) {
          return true;
        }
      }
      
      // Check for excessive links
      if (substr_count($message, 'http') > 2) {
        return true;
      }
      
      return false;
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Check honeypot field
      if (!empty($_POST['website'])) {
        // Bot detected - silently fail
        echo "<div class='success'>Thank you! Your message has been sent.</div>";
        exit;
      }
      
      // Check rate limiting
      if (!checkRateLimit()) {
        echo "<div class='error'>Please wait at least 30 seconds between submissions.</div>";
      } else {
        $name = htmlspecialchars(trim($_POST['name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $message = htmlspecialchars(trim($_POST['message']));
        $captcha_answer = $_POST['captcha'] ?? '';
        $captcha_expected = $_SESSION['captcha_answer'] ?? '';

        if ($name && $email && $message && $captcha_answer == $captcha_expected) {
          // Check for spam content
          if (isSpamContent($message, $name, $email)) {
            echo "<div class='error'>Your message appears to contain spam content. Please revise and try again.</div>";
          } else {
            $to = "contact@sarahrosehassan.com";
            $subject = "New Contact Form Submission from $name";
            $body = "Name: $name\nEmail: $email\n\nMessage:\n$message\n\nSubmitted from IP: " . $_SERVER['REMOTE_ADDR'];
            $headers = "From: Sarah Rose Website <sarapnlc@server113.web-hosting.com>\r\n";
            $headers .= "Reply-To: $email\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

            if (mail($to, $subject, $body, $headers)) {
                $_SESSION['last_submission'] = time();
                echo "<div class='success'>Thank you, $name! Your message has been sent.</div>";
            } else {
                echo "<div class='error'>Sorry, your message could not be sent. Please try again later.</div>";
            }
          }
        } else {
          if ($captcha_answer != $captcha_expected) {
            echo "<div class='error'>Please solve the math problem correctly.</div>";
          } else {
            echo "<div class='error'>Please fill out all fields.</div>";
          }
        }
      }
    }
    
    // Generate simple math captcha
    $num1 = rand(1, 10);
    $num2 = rand(1, 10);
    $_SESSION['captcha_answer'] = $num1 + $num2;
    ?>

    <form action="" method="POST">
      <label for="name">Name</label>
      <input type="text" id="name" name="name" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>

      <label for="message">Message</label>
      <textarea id="message" name="message" rows="6" required></textarea>

      <!-- Honeypot field - hidden from users but visible to bots -->
      <div class="honeypot">
        <label for="website">Website (leave blank)</label>
        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
      </div>

      <!-- Simple math captcha -->
      <div class="captcha">
        <label for="captcha">Spam protection: What is <?= $num1 ?> + <?= $num2 ?>?</label>
        <input type="number" id="captcha" name="captcha" required>
      </div>

      <button type="submit">Send Message</button>
    </form>
  </div>
</body>
</html>

<?php include("includes/footer.php"); ?>
