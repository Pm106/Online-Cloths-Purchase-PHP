<html>
<head>
    <title>Vastra</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- latest compiled and minified CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
    <!-- jquery library -->
    <script type="text/javascript" src="bootstrap/js/jquery-3.2.1.min.js"></script>
    <!-- Latest compiled and minified javascript -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <!-- External CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<?php
require("connection.php");
require 'header2.php';
if (isset($_GET['_id'])) {
    $supplier_id = new MongoDB\BSON\ObjectId($_GET['_id']);
    $collection = $db->suppliers;
    $query = $collection->find(['_id' => $supplier_id]);
    $supplier = $query->toArray();
    if (count($supplier) > 0) {
        $supplier = $supplier[0];
        ?>
        <form action="update_supplier.php" method="post">
            <input type="hidden" name="_id" value="<?php echo $_GET['_id']; ?>">
            <label>Supplier Name:</label>
            <input type="text" name="username" value="<?php echo $supplier["username"]; ?>"><br><br>
            <label>Phone Number:</label>
            <input type="text" name="mob" value="<?php echo $supplier["mob"]; ?>"><br><br>
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $supplier["email"]; ?>"><br><br>
            <input type="submit" value="Update Supplier">
        </form>
        <?php
    } else {
        echo "<p>Supplier not found.</p>";
    }
} else {
    echo "<p>Invalid request.</p>";
}
?>