<?php
require("connection.php");

if (isset($_GET['_id'])) {
    $cart_id = $_GET['_id'];
    $collection = $db->cart;
    $query = $collection->deleteOne(['_id' => $cart_id]);
    header('Location: manage_cart.php');
    exit;
}
?>