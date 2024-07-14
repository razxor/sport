<?php
// Path to your repository on your server
$repo_dir = 'sportv3.xorsoftbd.com';

// Change to the repository directory
chdir($repo_dir);

// Pull the latest changes from the repository
$output = shell_exec('git pull 2>&1');

// Log the output for debugging
file_put_contents('deploy.log', $output, FILE_APPEND);

// Deploy the changes using cPanel's Git Version Control
shell_exec('/usr/local/cpanel/3rdparty/bin/git --work-tree=/home/username/public_html --git-dir=/home/username/repositories/my-repo/.git checkout -f');

// Output the result
echo "<pre>$output</pre>";
