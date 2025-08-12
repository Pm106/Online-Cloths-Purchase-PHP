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
<body>
<?php
session_start();

require("connection.php");
 require 'header2.php';
// Get the product ID from the URL
$product_id = $_GET['id'];

// Check if the product ID is set
if (!isset($product_id)) {
    echo "Error: Product ID is not set.";
    exit;
}

// Get the product details from the database
$collection = $db->products;
$query = $collection->find(['_id' => new MongoDB\BSON\ObjectId($product_id)]);
$product = $query->toArray();

// Check if the product exists
if (count($product) == 0) {
    echo "Error: Product not found.";
    exit;
}

// Get the product details
$product_name = $product[0]['name'];
$product_price = $product[0]['price'];
$product_image = $product[0]['image'];

// Display the product details in a form
?>
<form action="update_product.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
    <label for="product_name">Product Name:</label>
    <input type="text" id="product_name" name="product_name" value="<?php echo $product_name; ?>"><br><br>
    <label for="product_price">Product Price:</label>
    <input type="number" id="product_price" name="product_price" value="<?php echo $product_price; ?>"><br><br>
    <label for="product_image">Product Image:</label>
    <input type="file" id="product_image" name="product_image"><br><br>
    <img src="data:image/jpeg;base64,<?php echo base64_encode($product_image); ?>" alt="Product Image"><br><br>
    <input type="submit" value="Update Product">
</form>
</body>   </div>
    
</html>