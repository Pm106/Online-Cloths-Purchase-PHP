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
require("connection.php");
require 'header2.php';
           ?>
    <nav class="navbar">
    <div class="container">
        <ul class="nav navbar-nav">
            <li class="active"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?page=home">Home</a></li>
            <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?page=manage_product">Manage Product</a></li>
            <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?page=manage_supplier">Manage Supplier</a></li>
            <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?page=order">Order</a></li>
        </ul>
    </div>
</nav>
    <div class="container">
    <?php
// Database connection
require("connection.php");

// Check if the page parameter is set
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 'home';
}
// Add product to cart
if (isset($_POST['buy_now'])) {
    $product_id = $_POST['product_id'];
    $collection = $db->products;
    $query = $collection->find(['_id' => $product_id]);
    $product = $query->toArray();
    if (count($product) > 0) {
        $product_name = $product[0]['name'];
        $price = $product[0]['price'];
        $image_data = $product[0]['image'];

        // Add product to cart collection
        $cart_collection = $db->cart;
        $cart_collection->insertOne([
            'product_id' => $product_id,
            'product_name' => $product_name,
            'price' => $price,
            'quantity' => 1,
            'image' => $image_data
        ]);

        // Redirect to cart.php
        header('Location: cart.php');
        exit;
    }
}
if ($page == 'home') {
    // Home page content
    ?>
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Welcome to Our Luxury Store</h1>
            <p class="text-center">Experience the finest products and exceptional service</p>
        </div>
    </div>
    <div class="row">
        <?php
        $collection = $db->products;
        $query = $collection->find();
        $products = $query->toArray();
        if (count($products) > 0) {
            foreach ($products as $row) {
                $image_data = $row["image"];
                $image_src = 'data:image/jpeg;base64,' . base64_encode($image_data);
                ?>
                <div class="col-md-3">
                    <div class="card">
                        <img src="<?php echo $image_src; ?>" alt="<?php echo $row["name"]; ?>" style="width: 100%; height: 200px; object-fit: cover; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row["name"]; ?></h5>
                            <p class="card-text">Price: <?php echo $row["price"]; ?></p>
                            <form action="add_cart.php" method="post">
                                <input type="hidden" name="product_id" value="<?php echo $row["_id"]; ?>">
                                <button type="submit" name="add_cart" class="btn btn-primary">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No products available.</p>";
        }
        ?>
    </div>
</div>

    <?php
} elseif ($page == 'manage_product') {
    // Manage Product page content
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Manage Products</h1>
                <p class="text-center">Add, edit, and delete products</p>
            </div>
        </div>
        <div class="row">
            <?php
            $collection = $db->products;
            $query = $collection->find();
            $products = $query->toArray();
            if (count($products) > 0) {
                ?>
                <table class="table table-striped">
                    <thead>
                        <tr><th>Product ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($products as $row) {
                            $image_data = $row["image"];
                            $image_src = 'data:image/jpeg;base64,' . base64_encode($image_data);
                            ?>
                            <tr>
        <td><?php echo $row["_id"]; ?></td>
        <td><?php echo $row["name"]; ?></td>
        <td><?php echo $row["price"]; ?></td>
        <td><img src="<?php echo $image_src; ?>" alt="<?php echo $row["name"]; ?>" style="width: 50px; height: 50px; object-fit: cover;"></td>
        <td>
        <a href='edit_product.php?id=<?= $row["_id"] ?>'>Edit</a> | <a href='delete_product1.php?id=<?= $row["_id"] ?>'>Delete</a>

        </td>
    </tr>
    <?php
    }
        ?>
            </tbody>
            </table>
            -<?php
            } else {
                echo "<p>No products available.</p>";
            }
            ?>
        </div>
    </div>
    <?php
} elseif ($page == 'manage_cart') {
    // Manage Cart page content
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Manage Cart</h1>
                <p class="text-center">View and edit cart items</p>
            </div>
        </div>
        <div class="row">
            <?php
            $collection = $db->cart;
            $query = $collection->find();
            $cart = $query->toArray();
            if (count($cart) > 0) {
                ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product ID</th>
                            <th>Quantity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($cart as $row) {
                            ?>
                            <tr>
                                <td><?php echo $row["_id"]; ?></td>
                                <td><?php echo $row["sid"]; ?></td>
                                <td><?php echo $row["quantity"]; ?></ td>
                                <td>
                                <td>
    <a href="#" class="btn btn-primary">Edit</a>
    <a href="delete_cart_item.php?_id=<?php echo $row["_id"]; ?>" class="btn btn-danger">Delete</a>
</td>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo "<p>No cart items available.</p>";
            }
            ?>
        </div>
    </div>
    <?php
} elseif ($page == 'manage_supplier') {
    // Manage Supplier page content
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Manage Suppliers</h1>
                <p class="text-center">View and manage supplier details</p>
            </div>
        </div>
        <div class="row">
            <?php
            $collection = $db->suppliers;
            $query = $collection->find();
            $suppliers = $query->toArray();
            if (count($suppliers) > 0) {
                ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Supplier ID</th>
                            <th>Supplier Name</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($suppliers as $row) {
                            ?>
                            <tr>
                                <td><?php echo $row["_id"]; ?></td>
                                <td><?php echo isset($row["username"]) ? $row["username"] : 'N/A'; ?></td>
                               <td><?php echo isset($row["mob"]) ? $row["mob"] : 'N/A'; ?></td>
                                <td><?php echo isset($row["email"]) ? $row["email"] : 'N/A'; ?></td>
                                <td>
                                <a href="edit_supplier.php?_id=<?php echo $row["_id"]; ?>" class="btn btn-primary">Edit</a>
                                <a href="delete_supplier.php?_id=<?php echo $row["_id"]; ?>" class="btn btn-danger">Delete</a>
                                    </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo "<p>No suppliers available.</p>";
            }
            ?>
        </div>
    </div>
<?php
} elseif ($page == 'order') {
// Display orders collection data report
$orders_collection = $db->orders;
$orders = $orders_collection->find();
?>
<table class="table table-striped table-hover">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Order ID</th>
            <th scope="col">Product ID</th>
            <th scope="col">Product Name</th>
            <th scope="col">Price</th>
            <th scope="col">Payment Method</th>
            <th scope="col">Order Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Assuming $orders is an array of order data
        foreach ($orders as $order) {
            ?>
            <tr>
                <td><?php echo $order['_id']; ?></td>
                <td><?php echo $order['product_id']; ?></td>
                <td><?php echo $order['product_name']; ?></td>
                <td><?php echo $order['price']; ?></td>
                <td><?php echo $order['payment_method']; ?></td>
                <td><?php echo $order['order_date']; ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
<?php

// Download as PDF option
/* echo '<a href="download_pdf.php" class="btn btn-primary">Download as PDF</a>';
*/
// Load HTML content into Dompdf
}
?>
</body>   </div>
    <footer class="footer"> 
               <div class="container">
               <center>
                   <p>Copyright &copy vastra. All Rights Reserved. | Contact Us: +91 90000 00000</p>
                   <p>This website is developed by MIHIR PATEL</p>
               </center>
               </div>
           </footer>

</html>