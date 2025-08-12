<?php
require_once 'vendor/autoload.php';

use Dompdf\Dompdf;
use MongoDB\Client;

// Establish a connection to your database
$mongoClient = new Client("mongodb://localhost:27017");
$db = $mongoClient->selectDatabase('project');

// Get orders collection data
$orders_collection = $db->orders;
$orders = $orders_collection->find();

// Create HTML content
$html = '<h2>Orders Collection Data Report</h2>';
$html .= '<table>';
$html .= '<tr><th>Order ID</th><th>Product ID</th><th>Product Name</th><th>Price</th><th>Quantity</th><th>Payment Method</th><th>Order Date</th></tr>';

foreach ($orders as $order) {
    $html .= '<tr>';
    $html .= '<td>' . $order['_id'] . '</td>';
    $html .= '<td>' . $order['product_id'] . '</td>';
    $html .= '<td>' . $order['product_name'] . '</td>';
    $html .= '<td>' . $order['price'] . '</td>';
    $html .= '<td>' . $order['quantity'] . '</td>';
    $html .= '<td>' . $order['payment_method'] . '</td>';
    $html .= '<td>' . $order['order_date'] . '</td>';
    $html .= '</tr>';
}

$html .= '</table>';

// Load HTML content into Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render PDF
$dompdf->render();

// Output PDF
$dompdf->stream('orders_report.pdf', array('Attachment' => 0));