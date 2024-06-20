<?php
session_start();

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

// Function to sanitize input (prevent SQL injection)
function sanitize($conn, $input) {
    return mysqli_real_escape_string($conn, $input);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle rating submission
    if (isset($_POST['rating']) && isset($_POST['email'])) {
        $rating = sanitize($conn, $_POST['rating']);
        $email = sanitize($conn, $_POST['email']);

        // Retrieve the email of the product owner from the products table
        $getEmailSql = "SELECT email FROM products WHERE email = '$email'";
        $result = $conn->query($getEmailSql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $email = $row['email'];

            // Update the user's rating in the database
            $updateRatingSql = "UPDATE users SET rating = '$rating' WHERE email = '$email'";
            if ($conn->query($updateRatingSql) === TRUE) {
                // Rating updated successfully
                echo json_encode(["status" => "success", "message" => "Thankyou for your feedback! Rating has been submitted successfully"]);
            } else {
                // Error updating rating
                echo json_encode(["status" => "error", "message" => "Error updating rating"]);
            }
        } else {
            // Product not found
            echo json_encode(["status" => "error", "message" => "Product not found"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid input"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}

$conn->close();
?>
