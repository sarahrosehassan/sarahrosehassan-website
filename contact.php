<?php include("includes/header.php"); ?>
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
  </style>
</head>
<body>
  <div class="container">
    <h1>Contact Me</h1>
    <p>
      Have a question, collaboration idea, or just want to say hi?  
      Use the form below or email me at <a href="mailto:hello@sarahrosehassan.com">hello@sarahrosehassan.com</a> for casual inquiries or personal messages.<br>
      For software engineering opportunities, recruitment, or business collaborations, please email <a href="mailto:contact@sarahrosehassan.com">contact@sarahrosehassan.com</a>.
    </p>


    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $name = htmlspecialchars(trim($_POST['name']));
      $email = htmlspecialchars(trim($_POST['email']));
      $message = htmlspecialchars(trim($_POST['message']));

      if ($name && $email && $message) {
        $to = "hello@sarahrosehassan.com";
        $subject = "New Contact Form Submission from $name";
        $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
        $headers = "From: Sarah Rose Website <sarapnlc@server113.web-hosting.com>\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";


        if (mail($to, $subject, $body, $headers)) {
            echo "<div class='success'>Thank you, $name! Your message has been sent.</div>";
        } else {
            echo "<div class='error'>Sorry, your message could not be sent. Please try again later.</div>";
        }
      } else {
        echo "<div class='error'>Please fill out all fields.</div>";
      }
    }
    ?>

    <form action="" method="POST">
      <label for="name">Name</label>
      <input type="text" id="name" name="name" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>

      <label for="message">Message</label>
      <textarea id="message" name="message" rows="6" required></textarea>

      <button type="submit">Send Message</button>
    </form>
  </div>
</body>
</html>

<?php include("includes/footer.php"); ?>
