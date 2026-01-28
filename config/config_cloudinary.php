<?php
// Subimos un nivel (..) para salir de 'config' y encontrar 'vendor'
require_once __DIR__ . '/../vendor/autoload.php';

use Cloudinary\Configuration\Configuration;

Configuration::instance([
  'cloud' => [
    'cloud_name' => 'dlq7yc7ff', 
    'api_key'    => '918316742178458', 
    'api_secret' => 'QmsIzdT070orpOAI2Uch9kHc1K8'
  ],
  'url' => [
    'secure' => true]
]);
?>
