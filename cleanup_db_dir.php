<?php
$dir = 'C:/xampp/mysql/data/invoicedesk';

if (!is_dir($dir)) {
    die("Directory $dir does not exist.\n");
}

echo "Attempting to wipe $dir...\n";

$files = array_diff(scandir($dir), array('.', '..'));

foreach ($files as $file) {
    $path = $dir . '/' . $file;
    if (is_file($path)) {
        if (unlink($path)) {
            echo "Deleted file: $file\n";
        } else {
            echo "Failed to delete file: $file\n";
        }
    }
}

if (count(array_diff(scandir($dir), array('.', '..'))) === 0) {
    if (rmdir($dir)) {
        echo "Successfully removed directory $dir.\n";
    } else {
        echo "Failed to remove directory $dir.\n";
    }
} else {
    echo "Directory is not empty after cleanup.\n";
}
