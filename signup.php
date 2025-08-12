<?php
    require 'connection.php';
    session_start();
   

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $mobile_number = $_POST['mobile_number'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if($password == $confirm_password){
            // Create a new MongoDB connection
            $mongoClient = new MongoDB\Driver\Manager("mongodb://localhost:27017");

            // Create a new collection
            $collection = new MongoDB\Collection($mongoClient, 'vastra', 'suppliers');

            // Create a new document
            $document = array(
                "username" => $username,
                "email" => $email,
                "mobile_number" => $mobile_number,
                "password" => password_hash($password, PASSWORD_BCRYPT)
            );

            // Insert the document
            $result = $collection->insertOne($document);

            if($result->getInsertedCount() == 1){
                header('location: login.php');
                exit; // add this to prevent further execution
            } else {
                echo "Registration failed!";
            }
        } else {
            echo "Passwords do not match!";
        }
    }
?>

<!-- rest of your HTML code -->
<!DOCTYPE html>
<html>
    <head>
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
        <link rel="stylesheet" href="css/style.css" type="text/css">
    </head>
    <body>
        <div>
            <?php
                require 'header.php';
            ?>
            <br><br>
            <div class="container">
                <div class="row">
                    <div class="col-xs-4 col-xs-offset-4">
                        <h1><b>SIGN UP</b></h1>
                        <form method="post" action="">
                            <div class="form-group">
                                <input type="text" class="form-control" name="username" placeholder="Username" required="true">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" placeholder="Email" required="true" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
                            </div> 
                            <div class="form-group">
                                <input type="tel" class="form-control" name="mobile_number" placeholder="Mobile Number" required="true">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="Password(min. 6 characters)" required="true" pattern=".{6,}">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required="true" pattern=".{6,}">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Sign Up">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <br><br><br><br><br><br>
           <footer class="footer">
               <div class="container">
               <center>
                   <p>Copyright &copy vastra. All Rights Reserved. | Contact Us: +91 90000 00000</p>
                   <p>This website is developed by MIHIR PATEL</p>
               </center>
               </div>
           </footer>

        </div>
    </body>
</html>