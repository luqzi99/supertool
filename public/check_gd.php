<?php
header('Content-Type: text/plain');
if (extension_loaded('gd')) {
    echo "GD loaded.\n";
    $info = gd_info();
    echo "JPEG Support: " . ($info['JPEG Support'] ?? 'false') . "\n";
    echo "PNG Support: " . ($info['PNG Support'] ?? 'false') . "\n";
    echo "WebP Support: " . ($info['WebP Support'] ?? 'false') . "\n";
} else {
    echo "GD NOT loaded.\n";
}
