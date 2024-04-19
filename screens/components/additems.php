<?php
session_start();

$userprofile = $_SESSION['email'];
if ($userprofile == true) {
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

    // Step 2: Retrieve user information from the database
    $email = $_SESSION['email'];
    $sql = "SELECT fullname, email FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, fetch user details
        $row = $result->fetch_assoc();
        $fullname = $row['fullname'];
        $email = $row['email'];
    }

    // Close the database connection
    $conn->close();
} else {
    header("Location: loginscreen.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Wonderland</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./ecommerce.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700&display=swap" />
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Raleway", sans-serif;
            box-sizing: border-box;
        }

        header {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            height: 60px;
            width: 100%;
            background: black;
        }

        .heading {
            display: flex;
            justify-content: flex-end;
            /* Align items to the right */
            align-items: center;
            height: 60px;
            width: 100%;
            background: black;
            padding-right: 3%;
        }

        .heading1 {
            opacity: 1;
            bottom: 8px;
        }

        .heading ul {
            display: flex;
        }

        .logo {
            margin: 5%;
        }

        .logo a {
            color: white;
            transition-duration: 1s;
            font-weight: 800;
        }

        .logo a:hover {
            color: rgb(240, 197, 6);
            transition-duration: 1s;
        }

        .heading ul li {
            list-style-type: none;
        }

        .heading ul li a {
            margin: 5px;
            text-decoration: none;
            color: black;
            font-weight: 500;
            position: relative;
            color: white;
            margin: 2px 14px;
            font-size: 10px;
            transition-duration: 1s;
        }

        .heading ul li a:active {
            color: red;
        }

        .heading ul li a:hover {
            color: rgb(243, 168, 7);
            transition-duration: 1s;
        }

        .heading ul li a::before {
            content: "";
            height: 2px;
            width: 0px;
            position: absolute;
            left: 0;
            bottom: 0;
            background-color: white;
            transition-duration: 1s;
        }

        .heading ul li a:hover::before {
            width: 100%;
            transition-duration: 1s;
            background-color: rgb(243, 168, 7);
        }

        #input {
            height: 30px;
            width: 300px;
            text-decoration: none;
            border: 0px;
            padding: 5px;
        }

        .logo a {
            color: white;
            font-size: 35px;
            font-weight: 500;
            text-decoration: none;
        }

        ion-icon {
            width: 30px;
            height: 30px;
            background-color: white;
            color: black;
        }

        ion-icon:hover {
            cursor: pointer;
        }

        .search a {
            display: flex;
        }

        header a ion-icon {
            position: relative;
            right: 3px;
        }

        .heading1 {
            opacity: 0;
        }

        .search {
            display: flex;
            position: relative;
        }

        .section1 {
            width: 100%;
            overflow: hidden;
            justify-content: center;
            align-items: center;
            margin: 0px auto;
        }

        footer {
            margin-top: 3%;
            padding-top: 3%;
            display: flex;
            flex-direction: column;
            background-color: black;
            align-items: center;
            color: white;
        }

        .footer1 {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: white;
            margin-top: 15px;
        }

        .social-media {
            display: flex;
            justify-content: center;
            color: white;
            flex-wrap: wrap;
        }

        .social-media a {
            color: white;
            margin: 20px;
            border-radius: 5px;
            margin-top: 10px;
            color: white;
        }

        .social-media a ion-icon {
            color: white;
            background-color: black;
        }

        .social-media a:hover ion-icon {
            color: rgb(243, 168, 7);
            transform: translateY(5px);
        }

        .footer2 {
            display: flex;
            width: 100%;
            justify-content: space-evenly;
            align-items: center;
            text-decoration: none;
            flex-wrap: wrap;
        }

        .footer0 {
            font-weight: 1200;
            transition-duration: 1s;
        }

        .footer0:hover {
            color: rgb(243, 168, 7);
        }

        .footer2 .heading-start {
            font-weight: 900;
            font-size: 18px;
        }

        .footer3 {
            margin-top: 60px;
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .footer2 .heading:hover {
            color: rgb(243, 168, 7);
        }

        .footer2 .div:hover {
            transform: scale(1.05);
        }

        .footer3 h4 {
            margin: 0 10px;
        }

        .footer2 div {
            margin: 10px;
        }

        .menu {
            visibility: hidden;
        }

        .heading1 .ham:active {
            color: red;
        }

        .items {
            overflow: hidden;
        }

        .ham,
        .close {
            cursor: pointer;
        }

        @media screen and (max-width: 1250px) {
            .heading ul li {
                display: none;
            }

            .items {
                transform: scale(0.9);
            }

            .img-slider img {
                height: 60vw;
                width: 80vw;
            }

            .ham:active {
                color: red;
            }

            .menu {
                display: block;
                flex-direction: column;
                align-items: center;
            }

            .menu a ion-icon {
                position: absolute;
            }

            @keyframes slide1 {
                0% {
                    left: 0vw;
                }

                15% {
                    left: 0vw;
                }

                20% {
                    left: -80vw;
                }

                32% {
                    left: -80vw;
                }

                35% {
                    left: -160vw;
                }

                47% {
                    left: -160vw;
                }

                50% {
                    left: -240vw;
                }

                63% {
                    left: -240vw;
                }

                66% {
                    left: -320vw;
                }

                79% {
                    left: -320vw;
                }

                82% {
                    left: -400vw;
                }

                100% {
                    left: 0vw;
                }
            }

            .menu ul {
                display: flex;
                flex-direction: column;
                position: absolute;
                width: 100vw;
                height: 70vh;
                background-color: rgb(0, 0, 0, 0.8);
                left: 0;
                top: 0;
                z-index: 11;
                align-items: center;
                justify-content: center;
            }

            .close {
                z-index: 34;

                color: white;
                background-color: black;
            }

            .close:active {
                color: red;
            }

            .menu ul li {
                list-style: none;
                margin: 20px;
                border-top: 3px solid white;
                width: 80%;
                text-align: center;

                padding-top: 10px;
            }

            .menu ul li a {
                text-decoration: none;
                padding-top: 10px;
                color: white;
                font-weight: 90;
            }

            .menu ul li a:hover {
                color: rgb(240, 197, 6);
            }

            .img-slider {
                display: flex;
                float: left;
                position: relative;
                width: 100%;
                height: 100%;
                animation-name: slide1;
                animation-duration: 10s;
                animation-iteration-count: infinite;
                transition-duration: 2s;
            }

            .section1 {
                width: 100%;
                overflow: hidden;
                justify-content: center;
                align-items: center;
                margin: 0px auto;
            }

            .heading1 {
                opacity: 1;
                bottom: 8px;
            }

            .search a {
                display: flex;
                flex-wrap: nowrap;
            }

            .heading1 .ham {
                background-color: black;
                color: white;
            }

            #input {
                width: 200px;
                flex-shrink: 2;
            }

            header {
                height: 150px;
            }
        }

        @media screen and (max-width: 550px) {
            .heading ul li {
                display: none;
            }

            .heading1 {
                opacity: 1;

                bottom: 8px;
            }

            header {
                height: 250px;
                flex-wrap: wrap;
                display: flex;
                flex-direction: column;
            }

            #input {
                width: 150px;
            }

            .close {
                z-index: 34;
            }

            .search a {
                display: flex;
                flex-wrap: nowrap;
            }
        }

        .section-break {
            padding-top: 2%;
            text-align: center;
            margin: 5px 0;
            padding-bottom: 1%;
        }

        .section-break hr {
            width: 85%;
            /* Adjust the width as needed */
            border: none;
            height: 1px;
            margin: 0 auto;
            /* Center the line horizontally */
            background-color: #333;
        }

        .section2 {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            max-width: 1200px;
            padding: 20px;
        }

        .category-heading {
            text-align: center;
            font-size: 30px;
            padding: 1%;
        }


        .sidenav {
            height: 100%;
            width: 250px;
            /* Adjust the width as needed */
            position: fixed;
            z-index: 1;
            top: 60px;
            /* Position at the bottom of the header */
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
            /* Adjust based on your header height */
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        /* Style the links inside the navigation drawer sidebar */
        .sidenav a {
            padding: 8px 16px;
            /* Add equal padding */
            text-decoration: none;
            font-size: 20px;
            /* Adjust the font size as needed */
            color: #818181;
            display: flex;
            align-items: center;
            /* Center items vertically */
            transition: 0.3s;
            margin-left: 5%;
        }

        /* Change the color of links on hover */
        .sidenav a:hover {
            color: #f1f1f1;
        }

        /* Position and style the close button (x) */
        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }

        /* Style the button to open the sidebar */
        span.openbtn {
            font-size: 30px;
            cursor: pointer;
            position: fixed;
            top: 10px;
            /* Adjust based on your header height */
            left: 10px;
            z-index: 2;
        }

        /* Style the close button (x) on hover */
        .sidenav .closebtn:hover {
            color: #f1f1f1;
        }

        hr {
            width: 90%;
            border: none;
            height: 1px;
            margin: 0 auto;
            /* Center the line horizontally */
            background-color: #818181;
            margin-top: 600px;
            margin-bottom: 10px;
        }

        .profile-container {
            border: 0px solid #ccc;
            border-radius: 40px;
            padding: 20px;
            margin-left: 10%;
            margin-right: 10%;
            margin-top: 3%;
            padding-top: 2%;
            padding-bottom: 3%;
            box-shadow: 0 0 70px rgba(0, 0, 0, 0.7);
            opacity: 0;
            /* Initially hide the container */
            animation: fadeIn 0.5s forwards;

            /* Apply fade-in animation */
        }

        /* Define the fade-in animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                /* Start with opacity 0 */
            }

            to {
                opacity: 1;
                /* End with opacity 1 */
            }
        }




        .profile-container h2 {
            margin-bottom: 10px;
            font-size: 40px;
        }

        .profile-container div {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 20px;
        }

        input[type="text"],
        input[type="email"] {
            width: 30%;
            padding: 10px;
            border: 1px solid black;
            border-radius: 10px;
            font-size: 15px;
        }

        button[type="submit"] {
            width: 30%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: rgb(240, 197, 6);
            color: rgb(0, 0, 0);
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: rgb(243, 168, 7);
        }

        .section-break {
            padding-top: 3px;
            text-align: center;
            margin: 5px 0;
            padding-bottom: 1%;
        }

        .section-break hr {
            width: 100%;
            /* Adjust the width as needed */
            border: none;
            height: 1px;
            margin: 0 auto;
            /* Center the line horizontally */
            background-color: #333;
        }
    </style>
</head>

<body>
    <header>
        <div id="mySidenav" class="sidenav">


            <a href="#" onclick="toggleProfile()">
                <i class="fas fa-user" style="font-size: 20px; color: #818181; margin-right: 30%"></i>
                Profile </a>
            <a href="#" onclick="toggleItems()">
                <i class="fa fa-shopping-bag" style="font-size: 20px; color: #818181; margin-right: 30%"></i>
                Orders</a>
            <a href="#">
                <i class="material-icons" style="font-size: 20px; color: #818181; margin-right: 30%">favorite</i>
                Items</a>
            <a href="#">How to Add</a>

            <hr>
            <a href="./logout.php">
                <i type="submit" class="fas fa-sign-out-alt"
                    style="font-size: 20px; color: #818181; margin-right: 25%"></i>
                Signout</a>
        </div>

        <div class="logo">
            <a href="../home.html">Wonderland</a>
        </div>

        <div class="heading">
            <ul>
                <li><a href="../home.html" class="under">HOME</a></li>
                <li><a href="./shopscreen.html" class="under">SHOP</a></li>
                <li><a href="./about.html" class="under">ABOUT US</a></li>

            </ul>
        </div>

        <div class="heading1">
            <ion-icon name="menu" class="ham"></ion-icon>
            <div class="menu">
                <a href="#">
                    <ion-icon name="close" class="close"></ion-icon>
                </a>

                <ul>
                    <li><a href="#" class="under">HOME</a></li>
                    <li><a href="#" class="under">SHOP</a></li>
                    <li><a href="#" class="under">OUR PRODUCTS</a></li>
                    <li><a href="#" class="under">LOGIN/REGISTER</a></li>
                    <li><a href="#" class="under">ABOUT US</a></li>
                </ul>
            </div>
        </div>
    </header>
    <section>
        <section id="profileSection" style="background-color: white; color: black; padding: 20px; padding-left: 15%;">
            <div class="profile-container">
                <form action="/submit-product" method="POST" enctype="multipart/form-data">
                    <div class="input-container">
                        <label for="name">Product Name:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="input-container">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" required></textarea>
                    </div>
                    <div class="input-container">
                        <label for="price">Price:</label>
                        <input type="number" step="0.01" id="price" name="price" required>
                    </div>
                    <div class="input-container image-upload">
                        <label for="image">Upload Image:</label>
                        <input type="file" id="image" name="image" required>
                    </div>
                    <button type="submit">Submit Product</button>
                    </form>
        </section>

      



    </section>

    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
    <script src="./JS/cartscreen.js"></script>
    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }
    </script>
    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }


    </script>

    <script>
        function toggleItems() {
            var profileSection = document.getElementById("profileSection");
            var itemsSection = document.getElementById("itemsSection");

            if (profileSection.style.display === "block") {
                profileSection.style.display = "none";
                itemsSection.style.display = "block";
            } else {
                itemsSection.style.display = "none";
                profileSection.style.display = "block";
            }
        }
    </script>
</body>

</html>