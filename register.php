<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "tutorfinder";

$connection = mysqli_connect($host, $username, $password, $database);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}


function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = sanitize($_POST["Id"]); 
    $firstName = sanitize($_POST["FirstName"]);
    $lastName = sanitize($_POST["LastName"]);
    $userName = sanitize($_POST["UserName"]);
    $email = sanitize($_POST["Email"]);
    $password = sanitize($_POST["Password"]);
    $option = sanitize($_POST["Option"]);

    if ($option == "faculty") {
        $query = "INSERT INTO tutors (id, firstname, lastname, username, email, password) VALUES ('$id', '$firstName', '$lastName', '$userName', '$email', '$password')";
    } else if ($option == "student") {
        $query = "INSERT INTO students (id, firstname, lastname, username, email, password) VALUES ('$id', '$firstName', '$lastName', '$userName', '$email', '$password')";
    }

    if (mysqli_query($connection, $query)) {
        
        $success = "Registration successful!";
    } else {
        
        $error = "Error: " . mysqli_error($connection);
    }
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>TutorFinder</title>
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
        
        function displaySuccessMessage() {
            var successMessage = document.getElementById("success-message");
            successMessage.style.display = "block";
        }
        
        function validateForm(event) {
            event.preventDefault();
            
            var id = document.getElementById("Id").value;
            var firstName = document.getElementById("FirstName").value;
            var lastName = document.getElementById("LastName").value;
            var userName = document.getElementById("UserName").value;
            var email = document.getElementById("Email").value;
            var password = document.getElementById("Password").value;
            var errorMessage = document.getElementById("error-message");
            
            errorMessage.textContent = "";
            
            if (id==="" || firstName === "" || lastName === "" || userName === "" || email === "" || password === "") {
                errorMessage.textContent = "Please fill in all fields.";
                return;
            }
            
            // Proceed with form submission
            document.getElementById("registration-form").submit();
        }
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
            <h1>TutorFinder</h1>
                <li><a href="home.html">Back</a></li> 
            </ul>
        </header>
    </div>

    <div class="area">
        <h1 style="color: white;">Registration</h1>

        <form id="registration-form" action="register.php" method="post" onsubmit="validateForm(event)">
             <div class="mb-3 row">
                <label for="Id" class="col-sm-3 col-form-label">ID</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="Id" name="Id">
                </div>
            </div>

            <br>
            <div class="mb-3 row">
                <label for="FirstName" class="col-sm-3 col-form-label">First Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="FirstName" name="FirstName">
                </div>
            </div>
            <br>
            <div class="mb-3 row">
                <label for="LastName" class="col-sm-3 col-form-label">Last Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="LastName" name="LastName">
                </div>
            </div>
            <br>
            <div class="mb-3 row">
                <label for="UserName" class="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="UserName" name="UserName">
                </div>
            </div>
            <br>
            <div class="mb-3 row">
                <label for="Email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control" id="Email" name="Email">
                </div>
            </div>
            <br>
            <div class="mb-3 row">
                <label for="Password" class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="Password" name="Password">
                </div>
            </div>
            <br>
            <div class="mb-3 row">
                <label for="Option" class="col-sm-3 col-form-label">Please Select</label>
                <div class="col-sm-9">
                    <select class="form-select" id="Password" name="Option">
                        <option value="faculty">Faculty</option>
                        <option value="student">Student</option>
                    </select>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-success">Register</button>

            <p id="error-message" class="error-message"></p>
            <p id="success-message" class="success-message" style="display: none;">Registration successful!</p>
        </form>
    </div>

    <br>
    <div class="footer">
        &copy; 2024 TutorFinder. All rights reserved
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>



