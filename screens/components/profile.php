<?php
// Step 1: Connect to your database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wonderland";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Step 2: Retrieve user data from the database
// For example, let's assume the user is already logged in and we have their user ID stored in a session variable
session_start();
if (!isset($_SESSION['user_id'])) {
  // Redirect to login page if user is not logged in
  //header("Location: loginscreen.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT fullname, email FROM users WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // User found, fetch user details
  $row = $result->fetch_assoc();
  $fullname = $row['fullname'];
  $email = $row['email'];
} else {
  // User not found (this should not happen if user ID is valid)
  // You can handle this case as per your application's requirement
  $fullname = "Unknown";
  $email = "Unknown";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }

    .profile-container {
      max-width: 600px;
      margin: 50px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      margin-bottom: 20px;
    }

    .profile-details {
      margin-bottom: 20px;
    }

    .detail {
      margin-bottom: 10px;
    }

    .detail label {
      font-weight: bold;
    }

    button {
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="profile-container">
    <h1>User Profile</h1>
    <div class="profile-details">
      <div class="detail">
        <label for="fullname">Full Name:</label>
        <span id="fullname"><?php echo $fullname; ?></span>
      </div>
      <div class="detail">
        <label for="email">Email:</label>
        <span id="email"><?php echo $email; ?></span>
      </div>
    </div>
    <button onclick="logout()">Logout</button>
  </div>

  <script>
    function logout() {
      // You can perform logout actions here (e.g., clear session, redirect to login page)
      alert("Logged out successfully!");
    }
  </script>
</body>
</html>
