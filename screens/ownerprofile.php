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

if (isset($_GET['email'])) {
    $email = $_GET['email'];

    // Fetch user details from users table
    $userSql = "SELECT fullname, email, contact, rating FROM users WHERE email = '$email'";
    $userResult = $conn->query($userSql);

    if ($userResult->num_rows > 0) {
        $userRow = $userResult->fetch_assoc();
    } else {
        die("User details not found.");
    }
} else {
    die("Invalid email.");
}


$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details - Wonderland</title>
    <link rel="stylesheet" href="./css/ownerprofile.css?v=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700&display=swap">
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">

    <script>
        function visitProfile(email) {
            window.location.href = './ownersprofile.php?email=' + encodeURIComponent(email);
        }
    </script>
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

        <div class="user-details-container">

            <h2 style="font-size: 50px;">Owner Details</h2>
            <div class="section-break">
                <hr />
            </div>
            <br>
            <label style="font-size: 25px; font-weight: bold;">Name </label>
            <p style="font-size: 18px;"><?php echo htmlspecialchars($userRow['fullname']); ?></p>
            <br>
            <label style="font-size: 25px; font-weight: bold;">Email </label>
            <p style="font-size: 20px;"><?php echo htmlspecialchars($userRow['email']); ?></p>
            <br>
            <label style="font-size: 25px; font-weight: bold;">Contact </label>
            <p style="font-size: 20px;"><?php echo htmlspecialchars($userRow['contact']); ?></p>
            <br>
            <br>
            <div class="card" data-product-owner-email="<?php echo htmlspecialchars($row['email']); ?>">
                <h1>Owner's Rating</h1>
                <div>

                    <span onclick="gfg(1)" data-value="1" class="star">★
                    </span>
                    <span onclick="gfg(2)" data-value="2" class="star">★
                    </span>
                    <span onclick="gfg(3)" data-value="3" class="star">★
                    </span>
                    <span onclick="gfg(4)" data-value="4" class="star">★
                    </span>
                    <span onclick="gfg(5)" data-value="5" class="star">★
                    </span>
                </div>
                <form id="ratingForm" method="POST">
                    <input type="hidden" id="email" name="email" value="<?php echo $email; ?>">
                    <input type="hidden" id="rating" name="rating">
                    <button type="button" style="background-color: black; color: white;"
                        onclick="submitFeedback()">Submit Ratings</button>
                </form>
            </div>
            <br>
            <button onclick="showProducts('<?php echo htmlspecialchars($userRow['email']); ?>')">Show Products</button>
        </div>
        <br>
        <br>

    </section>
    <section2>

        <div class="section2">

            <div class="category-heading">
                <h1>Products</h1>
            </div>
            <div class="section-break-2">
                <hr />
            </div>
            <br>
            <br>
            <div class="display-image">
                <?php
                $conn = new mysqli($servername, $username, $password, $dbname); // Assume $conn is your active database connection
                $result = $conn->query("SELECT * FROM products WHERE status = 'approved'"); // Only select approved products
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="product-card">';
                        echo '<a href="product_details.php?id=' . htmlspecialchars($row['id']) . '">';
                        echo '<img class="product-image" src="./image/' . htmlspecialchars($row['filename']) . '" alt="' . htmlspecialchars($row['p_name']) . '">';
                        echo '<div class="product-info">';
                        echo '<p>' . htmlspecialchars($row['p_name']) . '</p>'; // Adjusted line
                        echo '</div>';
                        echo '</a>';
                        echo '<div class="section-break-2"> <hr/></div>';
                        echo '<div class="product-desc">' . htmlspecialchars($row['description']) . '</div>';
                        echo '<div class="price-cart-container">';

                        echo '<p class="product-price">Rs. ' . htmlspecialchars($row['price']) . '</p>';
                        echo '</div>';
                        echo '</div>'; // Close product-card
                    }
                } else {
                    echo "<p>No products found.</p>";
                }
                $conn->close();
                ?>


            </div>
        </div>
    </section2>

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
        function submitFeedback() {
            const rating = document.getElementById('rating').value;
            const email = document.getElementById('email').value;

            if (rating === "") {
                alert('Please select a rating');
                return;
            }

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "./components/submit_rating.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    const response = JSON.parse(xhr.responseText);
                    if (xhr.status === 200 && response.status === "success") {
                        alert(response.message);
                        window.location.reload();
                    } else {
                        alert(response.message || "Unexpected Error Occured");
                    }
                }
            };
            xhr.send(`rating=${rating}&email=${email}`);
        }

        function visitProfile(email) {
            window.location.href = './ownersprofile.php?email=' + encodeURIComponent(email);
        }

        function showProducts(email) {
            // Make section2 visible
            var section2 = document.querySelector('.section2');
            section2.style.display = 'block';

            // Optionally, you can scroll to section2 for better UX
            section2.scrollIntoView({ behavior: 'smooth' });

            // Perform AJAX or other actions if needed
            // This function currently only shows the section2
        }

    </script>
    <script>
        let stars =
            document.getElementsByClassName("star");
        let output =
            document.getElementById("output");

        // Funtion to update rating
        function gfg(n) {
            remove();
            selectedStars = n;
            document.getElementById('rating').value = n;

            document.querySelectorAll(' .star').forEach(star => {
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

    </script>
</body>

</html>