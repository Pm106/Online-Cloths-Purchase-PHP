<?php
ob_start(); // Start output buffering

require 'connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = strtolower($_POST['role']); // Convert $role to lowercase

    if ($role == 'admin') {
        $collection = $db->selectCollection('admins');
        $filter = ['username' => $username];
        $admin = $collection->findOne($filter);
    } elseif ($role == 'supplier') {
        $collection = $db->selectCollection('suppliers');
        $filter = ['username' => $username];
        $supplier = $collection->findOne($filter);
    } else {
        $error = "Invalid role";
        // You can also redirect to an error page or display an error message
    }

    if (isset($admin) || isset($supplier)) {
        $stored_password = $admin['password'] ?? $supplier['password']; // Get the stored password from the database
        if (password_verify($password, $stored_password)) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            if ($role == 'admin') {
                header('Location: Ahome.php'); // Redirect to Ahome.php
                exit(); // Terminate the script immediately
            } elseif ($role == 'supplier') {
                header('Location: Shome.php'); // Redirect to Shome.php
                exit(); // Terminate the script immediately
            }
            exit(); // Terminate the script immediately
        } else {
            $error = "Invalid username or password";
            // Display an error message to the user
        }
    } else {
        $error = "Invalid username or password";
    }
}
?>

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
            <br><br><br>
           <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3>LOGIN</h3>
                            </div>
                            <div class="panel-body">
                                <p>Login to make a purchase.</p>
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="username" placeholder="Username">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password" placeholder="Password(min. 6 characters)" pattern=".{6,}">
                                    </div>
                                    <div class="form-group">
                                    <select class="form-control" id="role" name="role" required>
                    <option value="">Select Role</option>
                    <option value="admin">admin</option>
                    <option value="supplier">supplier</option>
                </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="Login" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                            <div class="panel-footer">Don't have an account yet? <a href="signup.php">Register</a></div>
                        </div>
                    </div>
                </div>
           </div>
           <br><br><br><br><br>
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