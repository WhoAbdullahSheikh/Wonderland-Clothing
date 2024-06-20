<?php
session_start(); // Start the session if not already started

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
function sanitize($conn, $input)
{
    return mysqli_real_escape_string($conn, $input);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle rating submission
    if (isset($_POST['rating'])) {
        $rating = sanitize($conn, $_POST['rating']);
        $productId = sanitize($conn, $_POST['productId']);

        // Retrieve the email of the product owner from the products table
        $getEmailSql = "SELECT email FROM products WHERE id = '$productId'";
        $result = $conn->query($getEmailSql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $email = $row['email'];

            // Update the user's rating in the database
            $updateRatingSql = "UPDATE users SET rating = '$rating' WHERE email = '$email'";
            if ($conn->query($updateRatingSql) === TRUE) {
                // Rating updated successfully
                echo '<script>alert("Rating updated successfully"); window.location.href = window.location.href;</script>';
            } else {
                // Error updating rating
                echo '<script>alert("Unexpected Error Occured"); window.location.href = window.location.href;</script>';
            }
        } else {
            // Product not found
            echo json_encode(["status" => "error", "message" => "Product not found"]);
        }
        exit; // Stop further execution
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details - Wonderland</title>
    <link rel="stylesheet" href="./css/product_details.css?v=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700&display=swap">
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
    <style>

    </style>
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
                $ownerEmail = $row['email'];

                // Fetch the owner's rating from the users table
                $ratingSql = "SELECT rating FROM users WHERE email = '$ownerEmail'";
                $ratingResult = $conn->query($ratingSql);
                $rating = 0;
                if ($ratingResult->num_rows > 0) {
                    $ratingRow = $ratingResult->fetch_assoc();
                    $rating = $ratingRow['rating'];
                }
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
                            <!-- Slideshow images -->
                            <div class="mySlides fade">
                                <img src="./image/<?php echo htmlspecialchars($row['filename']); ?>" style="width:100%">
                            </div>
                            <div class="mySlides fade">
                                <img src="./image/<?php echo htmlspecialchars($row['filename2']); ?>" style="width:100%">
                            </div>
                            <div class="mySlides fade">
                                <img src="./image/<?php echo htmlspecialchars($row['filename3']); ?>" style="width:100%">
                            </div>
                            <!-- Previous and Next buttons -->
                            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                            <a class="next" onclick="plusSlides(1)">&#10095;</a>
                        </div>
                        <br>
                        <br>
                        <!-- Dots for slideshow -->
                        <div style="text-align:center">
                            <span class="dot" onclick="currentSlide(1)"></span>
                            <span class="dot" onclick="currentSlide(2)"></span>
                            <span class="dot" onclick="currentSlide(3)"></span>
                        </div>
                    </div>

                    <div class="product-info-container">
                        <h2 style="font-size: 50px;"><?php echo htmlspecialchars($row['p_name']); ?></h2>
                        <div class="section-break">
                            <hr />
                        </div>
                        <br>
                        <div style="display: flex; align-items: flex-start;">
                            <div>
                                <p style="font-size: 32px; font-weight: bold;">Description </p>
                                <p style="font-size: 20px;"><?php echo htmlspecialchars($row['description']); ?></p>
                                <br>
                                <p style="font-size: 32px; font-weight: bold;">Condition </p>
                                <p style="font-size: 20px;"><?php echo htmlspecialchars($row['p_condition']); ?></p>
                                <br>
                                <p style="font-size: 32px; font-weight: bold;">Price </p>
                                <p style="font-size: 20px;">Rs. <?php echo htmlspecialchars($row['price']); ?>/-</p>
                                <br>
                                <p style="font-size: 32px; font-weight: bold;">Product Owner </p>
                                <p style="font-size: 20px;"><?php echo htmlspecialchars($row['email']); ?></p>
                                <button class="visit-profile-btn"
                                    onclick="visitProfile('<?php echo htmlspecialchars($row['email']); ?>')">Visit
                                    Profile</button>
                                <br>
                                <br>
                                <p style="font-size: 32px; font-weight: bold;"
                                    data-product-owner-email="<?php echo htmlspecialchars($row['email']); ?>">Owner Rating </p>
                                <div>

                                    <span data-value="1" class="star">★
                                    </span>
                                    <span data-value="2" class="star">★
                                    </span>
                                    <span data-value="3" class="star">★
                                    </span>
                                    <span data-value="4" class="star">★
                                    </span>
                                    <span data-value="5" class="star">★
                                    </span>
                                    <span
                                        style="font-size: 26px; margin-left: 10px;">(<?php echo htmlspecialchars($ratingRow['rating']); ?>)</span>
                                </div>
                                <form id="ratingForm" method="POST">
                                    <input type="hidden" id="productId" name="productId" value="<?php echo $productId; ?>">
                                    <input type="hidden" id="rating" name="rating">

                                </form>
                            </div>
                        </div>

                        <?php echo ' <button class="add-to-cart-btn" onclick="addToCartAndRedirect(\'' . htmlspecialchars($row['p_name']) . '\', ' . htmlspecialchars($row['price']) . ')">Add to Cart</button>'; ?>
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
        function visitProfile(email) {
            // Assuming you have a profile page that takes an email parameter
            window.location.href = './ownerprofile.php?email=' + encodeURIComponent(email);
        }
    </script>

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
    <script>
        let stars = document.getElementsByClassName("star");
        let output = document.getElementById("output");

        // Function to update rating
        function gfg(n) {
            remove();
            selectedStars = n;
            document.getElementById('rating').value = n;

            document.querySelectorAll('.star').forEach(star => {
                star.classList.remove('active');
            });
            for (let i = 0; i < n; i++) {
                if (n == 1) cls = "one";
                else if (n == 2) cls = "two";
                else if (n == 3) cls = "three";
                else if (n == 4) cls = "four";
                else if (n == 5) cls = "five";
                stars[i].className = "star " + cls;
            }
            output.innerText = "Rating is: " + n + "/5";
        }

        // To remove the pre-applied styling
        function remove() {
            let i = 0;
            while (i < 5) {
                stars[i].className = "star";
                i++;
            }
        }

        function submitFeedback() {
            const rating = selectedStars;
            if (rating === 0) {
                alert('Please select a rating');
                return;
            }

            document.getElementById('ratingForm').submit();
        }

        // Highlight stars based on rating from the database
        window.onload = function () {
            const ownerRating = <?php echo $rating; ?>;
            gfg(ownerRating);
        };
    </script>

</body>

</html>