<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wonderland";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Generate a unique token and store it in the session
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32)); // Generate a random token
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload'])) {
    // Validate the token to prevent CSRF attacks
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
        die("Invalid token");
    }

    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $order_id = $_POST['order_id'];

    if (!$filename || !$tempname) {
        echo '<script>alert("Error: You must upload an image."); window.history.back();</script>';
        exit;
    }

    $target_dir = "../records/image/";
    $target_file = $target_dir . basename($filename);

    if (!is_dir($target_dir) || !is_writable($target_dir)) {
        echo '<script>alert("Error: Target directory is not writable."); window.history.back();</script>';
        exit;
    }

    if (move_uploaded_file($tempname, $target_file)) {
        $sql = "UPDATE orders SET tr_receipt = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo "Error preparing statement: " . $conn->error;
            exit;
        }

        $stmt->bind_param("si", $filename, $order_id);

        if ($stmt->execute()) {
            // Redirect to orderplace.php with order_id parameter
            header("Location: ../orderplace.php?order_id=" . $order_id);
            exit();
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo '<script>alert("Failed to upload file ' . htmlspecialchars($filename) . '"); window.history.back();</script>';
    }
}

$conn->close();
?>
