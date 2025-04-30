<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Cloudinary PHP SDK autoload

\Cloudinary\Configuration\Configuration::instance([
  'cloud' => [
    'cloud_name' => 'your_cloud_name',
    'api_key'    => 'your_api_key',
    'api_secret' => 'your_api_secret',
  ],
  'url' => [
    'secure' => true
  ]
]);
