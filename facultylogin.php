<?php
// Assuming you have a MySQL database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elibrary";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the username and password from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Prepare a SQL query to select the user from the database
    $query = "SELECT * FROM faculty WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    // Check if the query returned any rows
    if ($result->num_rows > 0) {
        // User credentials are correct
        echo "<div class='success-message'>Login successful!</div>";
        echo "<script>window.location.href = 'facultydash.html';</script>";
    } else {
        // User credentials are incorrect
        echo "<div class='error-message'>Incorrect username or password.</div>";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>ELibrary</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/css/bootstrap.min.css">
    <style>
        body {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            margin: 0;
            margin-right: 1%;
            padding: 1%;
            background: linear-gradient(#000000, #5c2b2b);
            background-attachment: fixed;
        }

        .container {
            width: 100%;
            max-width: 110%;
            margin: 0 auto;
            padding: 10px;
            background: rgba(0, 0, 0, 0.4) url(pics/lib.jpg) no-repeat center center fixed;
            border-radius: 20px;
            box-shadow: 0 0 110px rgba(255, 248, 248, 0.1);
            border: 3px solid #251f1f;
            outline: none;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-top: 0;
            color: #fff;
        }

        .header ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .header ul li {
            display: inline-block;
            margin-right: 1px;
            margin-left: 1px;
            margin-bottom: 3px;
        }

        .header ul li a {
            color: #fff;
            text-decoration: none;
            background-color: #440000;
            padding: 8px 15px;
            border-radius: 15px;
            transition: background-color 0.3s ease;
            border: 3px solid #000000;
            outline: none;

        }

        .header ul li a:hover {
            background-color: #45a049;
            border-color: #45a049;
        }

        .area {
            color: #fff;
            margin: 0 auto;
            margin-top: 70px;
            width: 50%;
            padding-left: 1%;
            padding-right: 1%;
            border: 2px solid #ffffff;
            border-radius: 30px;
            text-align: center;
            padding-bottom: 0;
        }

        .area h1 {
            margin-top: 5%;
            text-align: center;
        }

        .footer {
            text-align: center;
            color: #fff;
            background: black;
            margin-top: auto;
            padding: 5px;
            border-radius: 10px;
            border: 2px solid #424242;
        }

        .header-bar {
            text-align: center;
            color: #fff;
            background: linear-gradient(#000000, #575151);
            margin-bottom: 1%;
            padding: 5px;
            background-color: rgba(107, 55, 55, 0.8);
            border-radius: 10px;
            border: 2px solid #424242;
        }

        .btn-success {
            color: #fff;
            background-color: #236833;
            border-color: #236833;
            border-radius: 10px;
            border: 5px solid #236833;
            padding: 5px;
            padding-left: 3%;
            padding-right: 3%;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-success:focus,
        .btn-success.focus {
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.5);
        }

        .btn-success.disabled,
        .btn-success:disabled {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:not(:disabled):not(.disabled):active,
        .btn-success:not(:disabled):not(.disabled).active,
        .show>.btn-success.dropdown-toggle {
            background-color: #1e7e34;
            border-color: #1c7430;
        }

        .btn-success:not(:disabled):not(.disabled):active:focus,
        .btn-success:not(:disabled):not(.disabled).active:focus,
        .show>.btn-success.dropdown-toggle:focus {
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.5);
        }
        
        .success-message {
            color: #28a745;
            margin-top: 10px;
        }
        
        .error-message {
            color: #fc0019;
            margin-top: 10px;
        }
    </style>

    <script>
        function updateTime() {
            var today = new Date();
            var date = today.toLocaleDateString();
            var time = today.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            document.getElementById("header-date").textContent = date;
            document.getElementById("header-time").textContent = time;
        }

        setInterval(updateTime, 1000);
        
        
    </script>
</head>

<body>
    <div class="header-bar">
        <strong>
            <span id="header-time" class="header-time"></span>
            <span id="header-date" class="header-date"></span>
        </strong>
    </div>

    <div class="container">
        <header class="header">
            <ul>
            <h1>E-Library</h1>
                <li><a href="home.html">Back</a></li>            
            </ul>
        </header>
    </div>

    <div class="area">
        
        <h1 style="color: white;">Faculty Login</h1>
        <form action="facultylogin.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <br>
        

            <button type="submit" class="btn-success">Login</button>
            <p id="error-message" class="error-message"></p>
            <p id="success-message" class="success-message" style="display: none;">Login successful!</p>

            
        </form>
    </div>

    <br>
    <div class="footer">
        &copy; 2023 ELibrary. All rights reserved
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
