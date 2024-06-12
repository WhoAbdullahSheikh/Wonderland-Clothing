<?php

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



?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details - Wonderland</title>
    <link rel="stylesheet" href="./css/product_details.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700&display=swap">
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">

</head>

<body>
    <header>
        <div class="logo">
            <a href="#">Wonderland</a>
        </div>
        <div class="heading">
            <ul>
                <li><a href="../home.php" class="under">HOME</a></li>
                <li><a href="./shopscreen.php" class="under">SHOP</a></li>
                <?php if (isset($_SESSION['email']) && $_SESSION['email'] !== 'admin@wonderland.com'): ?>
                    <li>
                        <a href="./profilescreen.php"><i class="fa fa-user" style="font-size: 20px; color: white"></i></a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </header>

    <section>
        <?php
        
        if (isset($_GET['id'])) {
            $productId = $_GET['id'];

            $sql = "SELECT p_name, description, email, p_condition, price, filename, filename2, filename3 FROM products WHERE id = '$productId'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $image1 = $row['filename'];
                $image2 = $row['filename2'];
                $image3 = $row['filename3'];
                // Display product details
                ?>
                <br>
                <button onclick="goBack()"
                    style="margin-left: 10%; font-size: 34px; text-decoration: none; color: black; font-weight: bold; border: none; background: none; cursor: pointer;">
                    <i class="fa fa-chevron-circle-left"></i> Back
                </button>

                <div class="product-details-container">

                    <div class="product-image-container">

                        <div class="slideshow-container">

                            <!-- Full-width images with number and caption text -->
                            <div class="mySlides fade">
                                
                                <img src="./image/<?php echo htmlspecialchars($row['filename']); ?>" style="width:100%">
                            </div>

                            <div class="mySlides fade">
                              
                                <img src="./image/<?php echo htmlspecialchars($row['filename2']); ?>" style="width:100%">
                            </div>

                            <div class="mySlides fade">
                                
                                <img src="./image/<?php echo htmlspecialchars($row['filename3']); ?>" style="width:100%">
                            </div>

                            <!-- Next and previous buttons -->
                            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                            <a class="next" onclick="plusSlides(1)">&#10095;</a>
                        </div>
                        <br>
                        <br>

                
                        <div style="text-align:center">
                            <span class="dot" onclick="currentSlide(1)"></span>
                            <span class="dot" onclick="currentSlide(2)"></span>
                            <span class="dot" onclick="currentSlide(3)"></span>
                        </div>
                    </div>

                    <div class="product-info-container">
                        <h2 style="font-size: 50px;"><?php echo htmlspecialchars($row['p_name']); ?></h2>
                        <div class="section-break">
                            <hr/>
                        </div>
                        <br>
                        <p style="font-size: 32px; font-weight: bold;">Description: </p>
                        <p style="font-size: 20px;"><?php echo htmlspecialchars($row['description']); ?></p>
                        <br>
                        <p style="font-size: 32px; font-weight: bold;">Condition: </p>
                        <p style="font-size: 20px;"><?php echo htmlspecialchars($row['p_condition']); ?></p>
                        <br>
                        <p style="font-size: 32px; font-weight: bold;">Price: </p>
                        <p style="font-size: 20px;">Rs. <?php echo htmlspecialchars($row['price']); ?>/-</p>
                        <br>
                        <p style="font-size: 32px; font-weight: bold;">Product Owner: </p>
                        <p style="font-size: 20px;"><?php echo htmlspecialchars($row['email']); ?></p>
                        <!-- Add additional product details as needed -->
                        <?php echo ' <button class="add-to-cart-btn" onclick="addToCartAndRedirect(\'' . htmlspecialchars($row['p_name']) . '\', ' . htmlspecialchars($row['price']) . ')">Add to Cart</button>';
                        ?>
                    </div>
                </div>
                <?php
            } else {
                echo "Product not found.";
            }
        } else {
            echo "Invalid product ID.";
        }

        $conn->close();
        ?>
    </section>

    <footer>
        <div class="footer0">
            <h1>Wonderland</h1>
        </div>
        <div class="footer1">
            Connect with us at
            <div class="social-media">
                <a href="#"><ion-icon name="logo-facebook"></ion-icon></a>
                <a href="#"><ion-icon name="logo-linkedin"></ion-icon></a>
                <a href="#"><ion-icon name="logo-youtube"></ion-icon></a>
                <a href="#"><ion-icon name="logo-instagram"></ion-icon></a>
                <a href="#"><ion-icon name="logo-twitter"></ion-icon></a>
            </div>
        </div>
        <div class="footer2">
            <div class="product">
                <div class="heading-footer">Products</div>
                <div class="div">Women Clothing</div>
                <div class="div">Men Clothing</div>
                <div class="div">Accessories</div>
            </div>
            <div class="services">
                <div class="heading-footer">Customer Care</div>
                <div class="div">Return</div>
                <div class="div">Cash Back</div>
                <div class="div">Complaint</div>
                <div class="div">Others</div>
            </div>

            <div class="Get Help">
                <div class="heading-footer">Get Help</div>
                <div class="div">Help Center</div>
                <div class="div">Privacy Policy</div>
                <div class="div">Terms</div>
                <div class="div">Support</div>
            </div>
        </div>
        <div class="footer3">
            Copyright ©
            <h4>Wonderland</h4>
            2024
        </div>
    </footer>
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>

    <script>
        // Function to handle adding items to cart and redirecting
        function addToCartAndRedirect(productName, price, description) {
            // Retrieve the current cart from local storage or initialize a new one if none exists
            let cart = JSON.parse(localStorage.getItem('cart')) || [];

            // Create a product object with name and price
            const product = {
                name: productName,
                description: description,
                price: price
            };

            // Add the new product to the cart array
            cart.push(product);

            // Update the cart in local storage with the new product added
            localStorage.setItem('cart', JSON.stringify(cart));

            // Optionally: Display a confirmation message
            alert('Product added to cart!');

            // Redirect the user to the cart page (ensure you have a 'cart.html' or appropriate URL)
            window.location.href = './checkoutscreen.php'; // Change this URL to where your cart page is located
        }

        function goBack() {
            window.history.back();
        }

        // Slideshow functions
        let slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("dot");
            if (n > slides.length) { slideIndex = 1 }
            if (n < 1) { slideIndex = slides.length }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
        }
    </script>
</body>

</html>