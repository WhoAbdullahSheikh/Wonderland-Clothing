<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wonderland";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$category = isset($_GET['category']) ? $_GET['category'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';

$sql = "SELECT * FROM products WHERE status = 'approved' AND category = ? AND type = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $category, $type);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="product-card">';
        echo '<a href="product_details.php?id=' . htmlspecialchars($row['id']) . '">';
        echo '<img class="product-image" src="./image/' . htmlspecialchars($row['filename']) . '" alt="' . htmlspecialchars($row['p_name']) . '">';
        echo '<div class="product-info">';
        echo '<p>' . htmlspecialchars($row['p_name']) . '</p>';
        echo '</div>';
        echo '</a>';
        echo '<div class="section-break-2"><hr/></div>';
        echo '<div class="product-desc">' . htmlspecialchars($row['description']) . '</div>';
        echo '<div class="price-cart-container">';
        echo '<p class="product-price">Rs. ' . htmlspecialchars($row['price']) . '</p>';
        echo '</div>';
        echo '</div>'; // Close product-card
    }
} else {
    echo "<p>No products found.</p>";
}

$stmt->close();
$conn->close();
?>
