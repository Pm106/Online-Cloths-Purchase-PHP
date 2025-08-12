<?php
session_start();

require("connection.php");

// Get the product ID from the URL
$product_id = $_GET['id'];

// Check if the product ID is set
if (!isset($product_id)) {
    echo "Error: Product ID is not set.";
    exit;
}

// Delete the product from the database
$delete_result = $GLOBALS['con']->deleteOne(array("_id" => new MongoDB\BSON\ObjectId($product_id)));

// Check if the deletion was successful
if ($delete_result->getDeletedCount() == 1) {
    echo "Product deleted successfully.";
    header("Location: Ahome.php");
    exit;
} else {
    echo "Error: Unable to delete product.";
    exit;
}
?>