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

// Deployment configuration - Updated for Bluehost
$repo_url = 'https://github.com/sarahrosehassan/sarahrosehassan-website-legacy.git';
$deploy_path = $_SERVER['HOME'] . '/public_html/old.sarahrosehassan.com';
$temp_path = $_SERVER['HOME'] . '/temp_deploy';

// Log deployment
$log_file = $_SERVER['HOME'] . '/deploy.log';
$timestamp = date('Y-m-d H:i:s');

function log_message($message) {
    global $log_file, $timestamp;
    file_put_contents($log_file, "[$timestamp] $message\n", FILE_APPEND | LOCK_EX);
}

log_message("Deployment started");

try {
    // Create temp directory for cloning
    if (is_dir($temp_path)) {
        exec("rm -rf $temp_path");
    }
    
    log_message("Cloning repository to temp directory");
    
    // Clone the repository
    $output = [];
    $return_code = 0;
    exec("git clone $repo_url $temp_path 2>&1", $output, $return_code);
    
    if ($return_code !== 0) {
        throw new Exception("Git clone failed: " . implode("\n", $output));
    }
    
    log_message("Repository cloned successfully");
    
    // Create deployment directory if it doesn't exist
    if (!is_dir($deploy_path)) {
        mkdir($deploy_path, 0755, true);
        log_message("Created deployment directory: $deploy_path");
    }
    
    // Copy files to deployment directory (exclude git and deployment files)
    exec("rsync -av --delete --exclude='.git' --exclude='deploy.php' --exclude='.cpanel.yml' --exclude='README.md' $temp_path/ $deploy_path/ 2>&1", $output, $return_code);
    
    if ($return_code !== 0) {
        throw new Exception("File copy failed: " . implode("\n", $output));
    }
    
    log_message("Files copied successfully");
    
    // Clean up temp directory
    exec("rm -rf $temp_path");
    log_message("Temp directory cleaned up");
    
    // Set correct permissions
    exec("find $deploy_path -type f -exec chmod 644 {} \;");
    exec("find $deploy_path -type d -exec chmod 755 {} \;");
    
    log_message("Permissions set");
    
    echo "Deployment successful! Website updated at old.sarahrosehassan.com";
    log_message("Deployment completed successfully");
    
} catch (Exception $e) {
    // Clean up on error
    if (is_dir($temp_path)) {
        exec("rm -rf $temp_path");
    }
    
    echo "Deployment failed: " . $e->getMessage();
    log_message("Deployment failed: " . $e->getMessage());
    http_response_code(500);
}
?>
