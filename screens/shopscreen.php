<?php
// DB credentials.
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wonderland";
if (isset($_SESSION['email']) && $_SESSION['email'] !== 'admin@wonderland.com') {
  $showProfileIcon = true;
} else {
  $showProfileIcon = false;
}
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Wonderland</title>
  <link rel="stylesheet" href="./css/shopscreen.css?v=1.0" />
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700&display=swap" />
  <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet" />
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
        <li><a href="./loginscreen.php" class="under">LOGIN/REGISTER</a></li>
        <?php if ($showProfileIcon): ?>
          <li>
            <a href="./profilescreen.php"><i class="fa fa-user" style="font-size: 20px; color: white"></i></a>
          </li>
        <?php endif; ?>
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
          <li><a href="#" class="under">LOGIN/REGISTER</a></li>
          <li><a href="#" class="under">ABOUT US</a></li>
        </ul>
      </div>
    </div>
  </header>
  <section>
    <div class="category-heading">
      <h1>Clothing Categories</h1>
    </div>
    <div class="section2">
      <div class="container">
        <div class="circle-card" onclick="toggleCategory('men')">
          <div class="circle-image">
            <img src="../collection/men/6cd89aa0a4f5332635198f49b1d8a453.jpg" alt="" />
            <br />
            <br />
            <p>Men</p>
          </div>
        </div>
        <div class="circle-card" onclick="toggleCategory('women')">
          <div class="circle-image">
            <img src="../collection/women/MF-114.jpg" alt="" />
            <br />
            <br />
            <p>Women</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Sections for displaying types of products -->
    <div id="menTypesSection" style="display: none" class="container animated-container">
      <div class="section-break">
        <hr />
      </div>
      <div class="category-heading">
        <h1>Men's Clothing </h1>
      </div>
      <div class="section2">
        <div class="container">
          <div class="circle-card" onclick="showProducts('men', 'Shirts')">
            <div class="circle-image2">
              <p>Shirts</p>
            </div>
          </div>
          <div class="circle-card" onclick="showProducts('men', 'Jackets')">
            <div class="circle-image2">
              <p>Jackets</p>
            </div>
          </div>
          <div class="circle-card" onclick="showProducts('men', 'Jeans')">
            <div class="circle-image2">
              <p>Jeans</p>
            </div>
          </div>

          <!-- Add more types as needed -->
        </div>
      </div>
    </div>

    <div id="womenTypesSection" style="display: none" class="container animated-container">
      <div class="section-break">
        <hr />
      </div>
      <div class="category-heading">
        <h1>Women's Clothing</h1>
      </div>
      <div class="section2">
        <div class="container">
          <div class="circle-card" onclick="showProducts('women', 'Shirts')">
            <div class="circle-image2">
              <p>Shirts</p>
            </div>
          </div>
          <div class="circle-card" onclick="showProducts('women', 'Jackets')">
            <div class="circle-image2">
              <p>Jackets</p>
            </div>
          </div>
          <div class="circle-card" onclick="showProducts('women', 'Jeans')">
            <div class="circle-image2">
              <p>Jeans</p>
            </div>
          </div>
          <div class="circle-card" onclick="showProducts('women', 'Tops')">
            <div class="circle-image2">
              <p>Tops</p>
            </div>
          </div>
          <div class="circle-card" onclick="showProducts('women', 'Frocks')">
            <div class="circle-image2">
              <p>Frocks</p>
            </div>
          </div>
          <!-- Add more types as needed -->
        </div>
      </div>
    </div>

    <div id="menClothingSection" style="display: none" class="container animated-container">
      <div class="section2">
        <div class="display-image" id="menProducts">
        </div>
      </div>
    </div>

    <div id="womenClothingSection" style="display: none" class="container animated-container">
      <div class="section2">
        <div class="display-image" id="womenProducts">
        </div>
      </div>
    </div>
  </section>

  <footer>
    <div class="footer0">
      <h1>Wonderland</h1>
    </div>
    <div class="footer1">
      Connect with us at
      <div class="social-media">
        <a href="#">
          <ion-icon name="logo-facebook"></ion-icon>
        </a>
        <a href="#">
          <ion-icon name="logo-linkedin"></ion-icon>
        </a>
        <a href="#">
          <ion-icon name="logo-youtube"></ion-icon>
        </a>
        <a href="#">
          <ion-icon name="logo-instagram"></ion-icon>
        </a>
        <a href="#">
          <ion-icon name="logo-twitter"></ion-icon>
        </a>
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
  <script src="./JS/cartscreen.js"></script>
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

    // Function to toggle visibility of category sections
    function toggleCategory(category) {
      if (category === "women") {
        document.getElementById("womenTypesSection").style.display = "block";
        document.getElementById("menTypesSection").style.display = "none";
        document.getElementById("womenClothingSection").style.display = "none";
        document.getElementById("menClothingSection").style.display = "none";
      } else if (category === "men") {
        document.getElementById("womenTypesSection").style.display = "none";
        document.getElementById("menTypesSection").style.display = "block";
        document.getElementById("womenClothingSection").style.display = "none";
        document.getElementById("menClothingSection").style.display = "none";
      }
    }

    // Function to show products based on selected type
    function showProducts(category, type) {
      if (category === "women") {
        document.getElementById("womenClothingSection").style.display = "block";
        document.getElementById("menClothingSection").style.display = "none";
        fetchProducts(category, type, 'womenProducts');
      } else if (category === "men") {
        document.getElementById("womenClothingSection").style.display = "none";
        document.getElementById("menClothingSection").style.display = "block";
        fetchProducts(category, type, 'menProducts');
      }
    }

    // Function to fetch products from server based on category and type
    function fetchProducts(category, type, containerId) {
      // Make an AJAX request to fetch products based on category and type
      const xhr = new XMLHttpRequest();
      xhr.open('GET', `./components/fetch_products.php?category=${category}&type=${type}`, true);
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          document.getElementById(containerId).innerHTML = xhr.responseText;
        }
      };
      xhr.send();
    }
  </script>
</body>

</html>