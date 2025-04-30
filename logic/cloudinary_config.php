<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Ensure correct path

\Cloudinary\Configuration\Configuration::instance([
    'cloud' => [
        'cloud_name' => 'dqsn8hxbr',
        'api_key'    => '154194152794391',
        'api_secret' => 'Z67j2Vh6bqc9LingNJvy6Icf2KA',
    ],
    'url' => [
        'secure' => true
    ]
]);
