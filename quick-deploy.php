<?php
// quick-deploy.php - Simple deployment script for Bluehost
// Upload this to your public_html folder and run it

echo "<h1>Website Deployment</h1>";
echo "<p>Starting deployment...</p>";

// Configuration
$repo_url = 'https://github.com/sarahrosehassan/sarahrosehassan-website-legacy/archive/refs/heads/main.zip';
$deploy_path = $_SERVER['DOCUMENT_ROOT'] . '/old.sarahrosehassan.com';
$temp_file = '/tmp/website.zip';
$temp_dir = '/tmp/website_temp';

try {
    echo "<p>1. Downloading latest code from GitHub...</p>";
    
    // Download the repository as ZIP
    $zip_content = file_get_contents($repo_url);
    if ($zip_content === false) {
        throw new Exception("Failed to download repository");
    }
    
    file_put_contents($temp_file, $zip_content);
    echo "<p>✓ Code downloaded successfully</p>";
    
    echo "<p>2. Extracting files...</p>";
    
    // Create temp directory
    if (is_dir($temp_dir)) {
        exec("rm -rf $temp_dir");
    }
    mkdir($temp_dir, 0755, true);
    
    // Extract ZIP
    $zip = new ZipArchive;
    if ($zip->open($temp_file) === TRUE) {
        $zip->extractTo($temp_dir);
        $zip->close();
        echo "<p>✓ Files extracted</p>";
    } else {
        throw new Exception("Failed to extract ZIP file");
    }
    
    echo "<p>3. Deploying to subdomain...</p>";
    
    // Create deployment directory
    if (!is_dir($deploy_path)) {
        mkdir($deploy_path, 0755, true);
        echo "<p>✓ Created directory: $deploy_path</p>";
    }
    
    // Find the extracted folder (it will be named something like "sarahrosehassan-website-legacy-main")
    $extracted_folders = glob($temp_dir . '/sarahrosehassan-website-legacy-*');
    if (empty($extracted_folders)) {
        throw new Exception("Could not find extracted repository folder");
    }
    
    $source_path = $extracted_folders[0];
    
    // Copy files (exclude deployment scripts)
    $files_to_exclude = ['deploy.php', 'quick-deploy.php', '.cpanel.yml', 'README.md', '.git*'];
    
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($source_path, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    
    foreach ($iterator as $item) {
        $skip = false;
        foreach ($files_to_exclude as $exclude) {
            if (fnmatch($exclude, $item->getFilename())) {
                $skip = true;
                break;
            }
        }
        
        if ($skip) continue;
        
        $target = $deploy_path . '/' . $iterator->getSubPathName();
        
        if ($item->isDir()) {
            if (!is_dir($target)) {
                mkdir($target, 0755, true);
            }
        } else {
            copy($item, $target);
            chmod($target, 0644);
        }
    }
    
    echo "<p>✓ Files copied to deployment directory</p>";
    
    echo "<p>4. Cleaning up...</p>";
    
    // Clean up
    unlink($temp_file);
    exec("rm -rf $temp_dir");
    
    echo "<p>✓ Cleanup complete</p>";
    
    echo "<h2 style='color: green;'>🎉 Deployment Successful!</h2>";
    echo "<p>Your website should now be available at: <a href='http://old.sarahrosehassan.com' target='_blank'>old.sarahrosehassan.com</a></p>";
    echo "<p>Deployment completed at: " . date('Y-m-d H:i:s') . "</p>";
    
} catch (Exception $e) {
    echo "<h2 style='color: red;'>❌ Deployment Failed</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
    
    // Clean up on error
    if (file_exists($temp_file)) {
        unlink($temp_file);
    }
    if (is_dir($temp_dir)) {
        exec("rm -rf $temp_dir");
    }
}

echo "<hr>";
echo "<p><a href='quick-deploy.php'>Run Deployment Again</a></p>";
?>
