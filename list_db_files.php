<?php
$dir = 'C:/xampp/mysql/data/invoicedesk';
if (is_dir($dir)) {
    $files = scandir($dir);
    echo "Files in $dir:\n";
    foreach ($files as $file) {
        echo $file . "\n";
    }
} else {
    echo "Directory $dir does not exist.\n";
}
