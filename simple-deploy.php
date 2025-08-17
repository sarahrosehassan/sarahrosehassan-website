<?php
// simple-deploy.php - Simplified Git deployment for old.sarahrosehassan.com
echo "<h1>Git Deployment to old.sarahrosehassan.com</h1>";
echo "<p>Starting deployment...</p>";

// Configuration
$deploy_path = $_SERVER['DOCUMENT_ROOT'] . '/old.sarahrosehassan.com';
$repo_url = 'https://github.com/sarahrosehassan/sarahrosehassan-website-legacy.git';
$temp_dir = '/tmp/git_deploy_' . time();

try {
    echo "<p>1. Creating temporary directory...</p>";
    mkdir($temp_dir, 0755, true);
    
    echo "<p>2. Cloning repository...</p>";
    $output = shell_exec("cd $temp_dir && git clone $repo_url . 2>&1");
    echo "<pre>$output</pre>";
    
    if (!file_exists("$temp_dir/index.php")) {
        throw new Exception("Repository clone failed - no index.php found");
    }
    
    echo "<p>3. Creating deployment directory...</p>";
    if (!is_dir($deploy_path)) {
        mkdir($deploy_path, 0755, true);
    }
    
    echo "<p>4. Copying files...</p>";
    $copy_output = shell_exec("cp -r $temp_dir/* $deploy_path/ 2>&1");
    echo "<pre>$copy_output</pre>";
    
    // Remove git-specific files
    if (file_exists("$deploy_path/.git")) {
        shell_exec("rm -rf $deploy_path/.git");
    }
    if (file_exists("$deploy_path/.cpanel.yml")) {
        unlink("$deploy_path/.cpanel.yml");
    }
    if (file_exists("$deploy_path/quick-deploy.php")) {
        unlink("$deploy_path/quick-deploy.php");
    }
    if (file_exists("$deploy_path/deploy.php")) {
        unlink("$deploy_path/deploy.php");
    }
    
    echo "<p>5. Setting permissions...</p>";
    shell_exec("chmod -R 644 $deploy_path/*");
    shell_exec("find $deploy_path -type d -exec chmod 755 {} \;");
    
    echo "<p>6. Cleaning up...</p>";
    shell_exec("rm -rf $temp_dir");
    
    echo "<h2 style='color: green;'>✅ Deployment Successful!</h2>";
    echo "<p>Your website is now live at: <a href='http://old.sarahrosehassan.com' target='_blank'>old.sarahrosehassan.com</a></p>";
    echo "<p>The subdomain is now connected to your Git repository!</p>";
    
} catch (Exception $e) {
    echo "<h2 style='color: red;'>❌ Deployment Failed</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
    
    // Cleanup on error
    if (is_dir($temp_dir)) {
        shell_exec("rm -rf $temp_dir");
    }
}

echo "<hr>";
echo "<p><small>To update in the future, just run this script again or set up a GitHub webhook.</small></p>";
?>
