<?php
session_start();

require("connection.php");

// Get the supplier ID from the URL
$supplier_id = $_GET['_id'];

// Check if the supplier ID is set
if (!isset($supplier_id)) {
    echo "Error: Supplier ID is not set.";
    exit;
}

// Delete the supplier from the database
$delete_result = $db->suppliers->deleteOne(array("_id" => new MongoDB\BSON\ObjectId($supplier_id)));

// Check if the deletion was successful
if ($delete_result->getDeletedCount() == 1) {
    echo "Supplier deleted successfully.";
    header("Location: Ahome.php?redirect=manage_supplier"); // Redirect to Ahome.php with redirect parameter
    exit;
} else {
    echo "Error: Unable to delete supplier.";
    exit;
}
?>