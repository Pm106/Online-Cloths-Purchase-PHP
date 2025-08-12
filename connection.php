<?php
require_once 'vendor/autoload.php'; 
use Dompdf\Dompdf;
$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->vastra; // or $client->selectDatabase('vastra')
$collection = $db->products; // Select the 'products' collection
$GLOBALS['con'] = $collection;
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
$database = new MongoDB\Database($manager, 'vastra');
$collection = $database->selectCollection('admins');
?>