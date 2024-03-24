<?php
// Assuming you have a MySQL database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wonderland";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the username and password from the form
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare a SQL query to select the user from the database
    $query = "INSERT INTO users (fullname, email, password) VALUES ('$fullname', '$email', '$password')";
    $result = $conn->query($query);

    // Check if the query returned any rows
    if (mysqli_query($connection, $query)) {
        
        $success = "Registration successful!";
    } else {
        
        $error = "Error: " . mysqli_error($connection);
    }
}