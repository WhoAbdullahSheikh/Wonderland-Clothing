<?php

session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wonderland";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;

// Validate order ID
if (!$order_id) {
    echo "Invalid order ID.";
    exit;
}



// Update delivery status to "shipped"
$sql = "UPDATE orders SET delivery_status = 'shipped' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);

if ($stmt->execute()) {
    echo "Order fulfilled successfully.";
} else {
    echo "Error fulfilling order: " . $conn->error;
}

// Close connections
$stmt->close();
$conn->close();

?>