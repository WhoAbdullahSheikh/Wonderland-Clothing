<?php
// processOrder.php

header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wonderland"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

// Retrieve form data
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$cashondelivery = isset($_POST['cashondelivery']) ? 1 : 0;
$cartData = json_decode($_POST['cartData'], true);

if (empty($fullname) || empty($email) || empty($address) || empty($city) || empty($state) || empty($zip) || empty($cartData)) {
    die(json_encode(["status" => "error", "message" => "All fields are required."]));
}

// Debug: Print cart data
file_put_contents('php://stderr', print_r($cartData, TRUE));

$totalPrice = 0;
$ownerEmail = '';

$firstProduct = $cartData[0]['name'];
$stmt = $conn->prepare("SELECT email FROM products WHERE p_name = ?");
if (!$stmt) {
    die(json_encode(["status" => "error", "message" => "Prepare statement failed: " . $conn->error]));
}
$stmt->bind_param("s", $firstProduct);
if (!$stmt->execute()) {
    die(json_encode(["status" => "error", "message" => "Execute statement failed: " . $stmt->error]));
}
$stmt->bind_result($ownerEmail);
$stmt->fetch();
$stmt->close();

if (empty($ownerEmail)) {
    die(json_encode(["status" => "error", "message" => "Owner email not found for product: " . $firstProduct]));
}

// Insert order into 'orders' table
$stmt = $conn->prepare("INSERT INTO orders (fullname, email, address, city, state, zip, cashondelivery, owner_email) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    die(json_encode(["status" => "error", "message" => "Prepare statement failed: " . $conn->error]));
}
$stmt->bind_param("ssssssis", $fullname, $email, $address, $city, $state, $zip, $cashondelivery, $ownerEmail);
if (!$stmt->execute()) {
    die(json_encode(["status" => "error", "message" => "Execute statement failed: " . $stmt->error]));
}
$order_id = $stmt->insert_id;
$stmt->close();

// Insert order items into 'order_items' table
foreach ($cartData as $item) {
    $product_name = $item['name'];
    $product_price = $item['price'];
    $product_quantity = 1; // Assuming quantity is 1 for each item, modify as per your requirements

    // Fetch the product_id from the products table
    $stmt = $conn->prepare("SELECT id FROM products WHERE p_name = ?");
    if (!$stmt) {
        die(json_encode(["status" => "error", "message" => "Prepare statement failed: " . $conn->error]));
    }
    $stmt->bind_param("s", $product_name);
    if (!$stmt->execute()) {
        die(json_encode(["status" => "error", "message" => "Execute statement failed: " . $stmt->error]));
    }
    $stmt->bind_result($product_id);
    $stmt->fetch();
    $stmt->close();

    if (empty($product_id)) {
        die(json_encode(["status" => "error", "message" => "Product ID not found for product: " . $product_name]));
    }

    // Insert into order_items table
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_price, product_quantity) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die(json_encode(["status" => "error", "message" => "Prepare statement failed: " . $conn->error]));
    }
    $stmt->bind_param("iisdi", $order_id, $product_id, $product_name, $product_price, $product_quantity);
    if (!$stmt->execute()) {
        die(json_encode(["status" => "error", "message" => "Execute statement failed: " . $stmt->error]));
    }
    $stmt->close();

    $totalPrice += $product_price;
}

// Update the order with the total price
$stmt = $conn->prepare("UPDATE orders SET total_price = ? WHERE id = ?");
if (!$stmt) {
    die(json_encode(["status" => "error", "message" => "Prepare statement failed: " . $conn->error]));
}
$stmt->bind_param("di", $totalPrice, $order_id);
if (!$stmt->execute()) {
    die(json_encode(["status" => "error", "message" => "Execute statement failed: " . $stmt->error]));
}
$stmt->close();

$conn->close();

$response = [
    'status' => 'success',
    'order_id' => $order_id,
    'totalPrice' => $totalPrice
];

echo json_encode($response);
?>
