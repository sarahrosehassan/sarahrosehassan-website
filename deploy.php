<?php
// deploy.php - Professional Git deployment script
// This file should be placed in your public_html root

// Security: Only allow deployment from GitHub webhooks or specific IPs
$secret = 'your-webhook-secret-here'; // Change this to a secure secret
$payload = file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';

// Verify GitHub webhook signature (optional but recommended)
// $expected_signature = 'sha256=' . hash_hmac('sha256', $payload, $secret);
// if (!hash_equals($expected_signature, $sig_header)) {
//     http_response_code(403);
//     exit('Unauthorized');
// }

// Deployment configuration
$repo_path = '/home/sarapnlc/repositories/sarahrosehassan-website-legacy';
$deploy_path = '/home/sarapnlc/public_html/old.sarahrosehassan.com';

// Log deployment
$log_file = '/home/sarapnlc/deploy.log';
$timestamp = date('Y-m-d H:i:s');

function log_message($message) {
    global $log_file, $timestamp;
    file_put_contents($log_file, "[$timestamp] $message\n", FILE_APPEND | LOCK_EX);
}

log_message("Deployment started");

try {
    // Pull latest changes
    $output = [];
    $return_code = 0;
    
    // Change to repository directory and pull
    exec("cd $repo_path && git pull origin main 2>&1", $output, $return_code);
    
    if ($return_code !== 0) {
        throw new Exception("Git pull failed: " . implode("\n", $output));
    }
    
    log_message("Git pull successful");
    
    // Copy files to deployment directory
    exec("rsync -av --delete --exclude='.git' --exclude='deploy.php' --exclude='.cpanel.yml' $repo_path/ $deploy_path/ 2>&1", $output, $return_code);
    
    if ($return_code !== 0) {
        throw new Exception("File copy failed: " . implode("\n", $output));
    }
    
    log_message("Files copied successfully");
    
    // Set correct permissions
    exec("find $deploy_path -type f -exec chmod 644 {} \;");
    exec("find $deploy_path -type d -exec chmod 755 {} \;");
    
    log_message("Permissions set");
    
    echo "Deployment successful!";
    log_message("Deployment completed successfully");
    
} catch (Exception $e) {
    echo "Deployment failed: " . $e->getMessage();
    log_message("Deployment failed: " . $e->getMessage());
    http_response_code(500);
}
?>
