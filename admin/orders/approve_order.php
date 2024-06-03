<?php
session_start();

if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'admin@wonderland.com') {
    header('Location: loginscreen.php');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wonderland";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $orderId = $_GET['id'];
    $status = $_GET['status'];

    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param('si', $status, $orderId);
    $stmt->execute();
    $stmt->close();

    $provider_result = $conn->query("SELECT * FROM orders WHERE id = $orderId");
    $provider_row = $provider_result->fetch_assoc();
    $provider_email = $provider_row['email'];
    $provider_fullname = $provider_row['fullname'];

    // Compose email details
    $to = $provider_email;
    $subject = "Order Placement";
    $message = "Dear $provider_fullname,\n\nYour Order (Order ID : $orderId)  has been placed. It will be delivered to your address in 5 business days\n\nRegards,\nTeam Wonderland";

    // Generate URL to open Gmail with pre-filled details
    $email_url = "https://mail.google.com/mail/?view=cm&fs=1&to=" . urlencode($to) . "&su=" . urlencode($subject) . "&body=" . urlencode($message);

    // Redirect to Gmail with pre-filled email details
    echo "<script>
    const emailUrl = '$email_url';
    window.open(emailUrl, '_blank');
    window.location.href = '../adminprofile.php';
    </script>";
    exit();
}


$conn->close();
?>
