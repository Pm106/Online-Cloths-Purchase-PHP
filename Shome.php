<?php
session_start(); // Start the session

require("connection.php"); // Include the connection file

// Check if the supplier is logged in
/*if (!isset($_SESSION['sid'])) {
    header("Location: Shome.php"); // Redirect to login page if not logged in
    exit;
}*/

// Make sure supplier_id is set
if (!isset($_SESSION['supplier_id'])) {
    $_SESSION['supplier_id'] = 0; // Set a default value or redirect to an error page
}

// Add product form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $image = $_FILES['image'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $availability = $_POST['availability'];

    // Check if the image is uploaded successfully
    if ($image['error'] == 0) {
        $image_data = file_get_contents($image['tmp_name']);
        $image_binary = new MongoDB\BSON\Binary($image_data, MongoDB\BSON\Binary::TYPE_GENERIC);
    } else {
        echo "Error uploading image";
        exit;
    }

    // Insert product into database
    $product = array(
        "sid" => $_SESSION['supplier_id'],
        "image" => new MongoDB\BSON\Binary($image_data, MongoDB\BSON\Binary::TYPE_GENERIC), // Create a new binary object from the image data // Store the image binary data in the 'image' field
        "name" => $name,
        "price" => $price,
        "quantity" => $quantity,
        "availability" => $availability
    );
    $GLOBALS['con']->insertOne($product);
}

// View products table
$query = array("sid" => $_SESSION['supplier_id']);
$cursor = $GLOBALS['con']->find($query);
// HTML Code Starts Here
?><!DOCTYPE html>
<html>
<head>
    <title>Vashtra - Supplier Home</title>
    <link rel="shortcut icon" href="img/lifestyleStore.png" />
        <title>vastra</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- latest compiled and minified CSS -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
        <!-- jquery library -->
        <script type="text/javascript" src="bootstrap/js/jquery-3.2.1.min.js"></script>
        <!-- Latest compiled and minified javascript -->
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <!-- External CSS -->
        <link rel="stylesheet" href="style.css" type="text/css">
    </head>
<body>
<?php
                require 'header2.php';
            ?>
    <div style="background-color:white;">
        <h1>Supplier Home</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="image">Product Image:</label>
                <input type="file" name="image" required>
            </div>
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label for="price">Product Price:</label>
                <input type="number" name="price" required>
            </div>
            <div class="form-group">
                <label for="quantity">Product Quantity:</label>
                <input type="number" name="quantity" required>
            </div>
            <div class="form-group">
                <label for="availability">Product Availability:</label>
                <select name="availability" required>
                    <option value="1">In Stock</option>
                    <option value="0">Out of Stock</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>

        <h2>Uploaded Products</h2>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Availability</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($cursor as $document) { ?>
                <tr>
                <td>
                    <?php if ($document["image"]) { ?>
                    <?php $image_data = $document["image"]->getData(); ?>
                <img src="data:image/jpeg;base64,<?= base64_encode($image_data) ?>" width='150' hight='150'>
                    <?php } else { ?>
                <p>No image available</p>
                    <?php } ?>
                </td>
                <td><?= $document["name"] ?></td>
                <td><?= $document["price"] ?></td>
                <td><?= $document["quantity"] ?></td>
                <td><?= ($document["availability"] == 1 ? "In Stock" : "Out of Stock") ?></td>
                <td><a href='update_product.php?id=<?= $document["_id"] ?>'>Update</a> | <a href='delete_product.php?id=<?= $document["_id"] ?>'>Delete</a></td>
            </tr>
            <?php } ?>
        </table>
    </div>
    <footer class="footer">
               <div class="container">
               <center>
                   <p>Copyright &copy vastra. All Rights Reserved. | Contact Us: +91 90000 00000</p>
                   <p>This website is developed by MIHIR PATEL</p>
               </center>
               </div>
           </footer>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>