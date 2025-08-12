<?php
require 'vendor/autoload.php';
$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->cake;
$cartCollection = $db->cart;

$citemid = $_GET['citemid'];
$cartCollection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($citemid)]);
header('Location: cart.php'); // Redirect to the cart page
exit;
?>