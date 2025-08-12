<!-- make_payment.php -->
<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit;
}
?>

<html>
<head>
    <title>Make Payment</title>
</head>
<body>
    <h1>Make Payment</h1>
    <form action="make_payment.php" method="post">
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount"><br><br>
        <input type="submit" value="Make Payment">
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $amount = $_POST['amount'];
        // Process payment logic here
        echo "Payment made successfully!";
    }
    ?>
</body>
</html>