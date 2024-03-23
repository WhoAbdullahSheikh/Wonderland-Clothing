<?php
// Retrieve the parameters from the request
$username = $_POST['username'];
$id = $_POST['id'];

// Perform the deletion logic
// Assuming you are using MySQLi for database operations
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "tutorfinder";


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbName", $dbUsername, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $stmt = $conn->prepare("SELECT * FROM tutors WHERE username = :username AND id = :id");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $facultyUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($facultyUser) {
        $stmt = $conn->prepare("DELETE FROM tutors WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        echo "User deleted successfully!";
        exit;
    }


    $stmt = $conn->prepare("SELECT * FROM students WHERE username = :username AND id = :id");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $studentUser = $stmt->fetch(PDO::FETCH_ASSOC);

   
    if ($studentUser) {
        $stmt = $conn->prepare("DELETE FROM students WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        echo "User deleted successfully!";
        exit;
    }

    echo "User not found!";
} catch (PDOException $e) 
{
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>

