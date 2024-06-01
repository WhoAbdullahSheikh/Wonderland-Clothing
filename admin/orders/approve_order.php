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

    header('Location: ../adminprofile.php');
    exit();
}

$conn->close();
?>
