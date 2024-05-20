<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wonderland";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $full_name = $_POST['full_name'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $city = $_POST['city'];
  $state = $_POST['state'];
  $zip = $_POST['zip'];
  $total_price = $_POST['total_price']; // Total price of the order
  $cart = json_decode($_POST['cart'], true); // Decoded cart items

  // Insert customer data
  $stmt = $conn->prepare("INSERT INTO customers (full_name, email, address, city, state, zip) VALUES (?, ?, ?, ?, ?, ?)");
  if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
  }
  $stmt->bind_param("ssssss", $full_name, $email, $address, $city, $state, $zip);
  if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
  }
  $customer_id = $stmt->insert_id; // Get the inserted customer id
  $stmt->close();

  // Insert order data
  $stmt = $conn->prepare("INSERT INTO orders (customer_id, total_amount) VALUES (?, ?)");
  if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
  }
  $stmt->bind_param("id", $customer_id, $total_price);
  if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
  }
  $order_id = $stmt->insert_id; // Get the inserted order id
  $stmt->close();

  // Insert order items
  $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_name, product_price) VALUES (?, ?, ?)");
  if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
  }
  foreach ($cart as $item) {
    $stmt->bind_param("isd", $order_id, $item['name'], $item['price']);
    if (!$stmt->execute()) {
      die("Execute failed: " . $stmt->error);
    }
  }
  $stmt->close();
  $conn->close();

  // Clear the cart after order is placed and redirect to a confirmation page
  echo "<script>
localStorage.removeItem('cart');
window.location.href = './orderplaced.php';
</script>";
  exit();
}

$conn->close();
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
      font-size: 13px;
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

    .section2 .container {
      display: flex;
      width: 100%;
      height: max-content;
      flex-wrap: wrap;
      justify-content: center;
      margin: 10px auto;
    }

    .section2 .container .items {
      margin: 10px;
      width: 200px;
      height: 300px;
      background-color: white;
      border: 2.5px solid black;
      border-radius: 12px;
    }

    .section2 .container .items .name {
      text-align: center;
      background-color: rgb(240, 197, 6);
      height: 25px;
      padding-top: 4px;
      color: white;
      margin: 0;
    }

    .section2 .container .items .price {
      float: left;
      padding-left: 10px;
      display: block;
      width: 100%;
      color: rgb(255, 0, 0);
      font-weight: 650;
    }

    .section2 .container .items .info {
      padding-left: 10px;
      color: rgb(243, 168, 7);
    }

    .section2 .container .items .img img {
      width: 200px;
      height: 200px;
      margin: 0;
      padding: 0;
      border-radius: 12px;
      transition-duration: 0.8s;
    }

    .section2 .container .items .img {
      overflow: hidden;
      margin: 0;
    }

    .section2 .container .items:hover .img img {
      transform: scale(1.2);
      transition-duration: 0.8s;
      border-radius: 12px;
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

    .items {
      display: flex;
    }

    /*********************************************************************************/
    .row {
      display: -ms-flexbox;
      /* IE10 */
      display: flex;
      -ms-flex-wrap: wrap;
      /* IE10 */
      flex-wrap: wrap;
      margin: 0 -16px;
      margin-left: auto;
    }

    .col-25 {
      -ms-flex: 25%;
      /* IE10 */
      flex: 25%;
    }

    .col-50 {
      -ms-flex: 50%;
      /* IE10 */
      flex: 50%;
    }

    .col-75 {
      -ms-flex: 75%;
      /* IE10 */
      flex: 75%;
    }

    .col-25,
    .col-50,
    .col-75 {
      margin-top: 1%;
      padding: 0 16px;
    }

    .container {
      background-color: #f2f2f2;
      padding: 5px 20px 15px 20px;
      border: 1px solid lightgrey;
      border-radius: 3px;
    }

    input[type="email"],
    input[type="text"] {
      width: 100%;
      margin-bottom: 20px;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }

    label {
      margin-bottom: 10px;
      display: block;
      font-weight: bold;
    }

    .icon-container {
      margin-bottom: 20px;
      padding: 7px 0;
      font-size: 24px;
    }

    .btn {
      background-color: #04aa6d;
      color: white;
      padding: 12px;
      margin: 10px 0;
      border: none;
      width: 100%;
      border-radius: 13px;
      cursor: pointer;
      font-size: 17px;
    }

    .btn:hover {
      background-color: #45a049;
    }

    span.price {
      float: right;
      color: grey;
    }

    /* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (and change the direction - make the "cart" column go on top) */
    @media (max-width: 800px) {
      .row {
        flex-direction: column-reverse;
      }

      .col-25 {
        margin-bottom: 20px;
      }
    }
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
        <li><a href="./loginscreen.php" class="under">LOGIN/REGISTER</a></li>
        <li>
          <a href="#home"><i class="fa fa-user" style="font-size: 20px; color: white"></i></a>
        </li>
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
    <form action="./checkoutscreen.php" method="post" id="checkoutForm">
      <div class="row" style="margin-left: 1%; margin-right: 1%">
        <div class="col-50">
          <h1>Delivery Address</h1>
          <br>
          <label for="full_name"><i class="fa fa-user"></i> Full Name</label>
          <input type="text" id="full_name" name="full_name" placeholder="Your Full Name" required>
          <label for="email"><i class="fa fa-envelope"></i> Email</label>
          <input type="email" id="email" name="email" placeholder="abc@example.com" required>
          <label for="address"><i class="fa fa-address-card-o"></i> Address</label>
          <input type="text" id="address" name="address" placeholder="Your delivery address" required>
          <label for="city"><i class="fa fa-institution"></i> City</label>
          <input type="text" id="city" name="city" placeholder="Your City" required>
          <div class="row">
            <div class="col-50">
              <label for="state">State</label>
              <input type="text" id="state" name="state" placeholder="Name of state" required>
            </div>
            <div class="col-50">
              <label for="zip">Zip</label>
              <input type="text" id="zip" name="zip" placeholder="12345" maxlength="5" required
                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 5);">
            </div>
          </div>
          <br>
          <input type="hidden" id="total_price" name="total_price" value="0">
          <input type="hidden" id="cart" name="cart" value="[]">
          <button type="submit" class="btn">Confirm Order</button>
        </div>
        <div class="col-25">
          <div class="container">
            <h4>
              Cart
              <span class="price" style="color: black">
                <i class="fa fa-shopping-cart"></i>
                <b id="cartItemCount">0</b>
              </span>
            </h4>
            <div id="cartItems" style="margin-top: 20px; margin-bottom: 20px;"></div>
            <hr>
            <p>
              Total
              <span class="price" style="color: black">
                <b>Rs.<span id="totalPrice">0</span></b>
              </span>
            </p>
            <button type="button" onclick="clearCart()" class="btn">Clear Cart</button>
          </div>
        </div>
      </div>
    </form>
  </section>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      displayCart();
    });

    function displayCart() {
      let cart = JSON.parse(localStorage.getItem("cart")) || [];
      let cartItemsContainer = document.getElementById("cartItems");
      let totalPrice = 0;

      cartItemsContainer.innerHTML = ""; // Clear previous items

      cart.forEach(function (item) {
        cartItemsContainer.innerHTML +=
          "<p>" +
          item.name +
          ' <span class="price">Rs.' +
          item.price +
          "</span></p>";
        totalPrice += item.price;
      });

      document.getElementById("cartItemCount").textContent = cart.length;
      document.getElementById("totalPrice").textContent = totalPrice;
      document.getElementById("total_price").value = totalPrice; // Update hidden input with total price
      document.getElementById("cart").value = JSON.stringify(cart); // Update hidden input with cart items
    }

    function clearCart() {
      localStorage.removeItem("cart");
      displayCart(); // Update the cart display after clearing
    }
  </script>

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
    document.addEventListener("DOMContentLoaded", function () {
      displayCart();
    });

    function displayCart() {
      let cart = JSON.parse(localStorage.getItem("cart")) || [];
      let cartItemsContainer = document.getElementById("cartItems");
      let totalPrice = 0;

      cartItemsContainer.innerHTML = ""; // Clear previous items

      cart.forEach(function (item) {
        cartItemsContainer.innerHTML +=
          "<p>" +
          item.name +
          ' <span class="price">Rs.' +
          item.price +
          "</span></p>";
        totalPrice += item.price;
      });

      document.getElementById("cartItemCount").textContent = cart.length;
      document.getElementById("totalPrice").textContent = totalPrice;
      document.getElementById("total_price").value = totalPrice; // Update hidden input with total price
      document.getElementById("cart").value = JSON.stringify(cart); // Update hidden input with cart items
    }

    function clearCart() {
      localStorage.removeItem("cart");
      displayCart(); // Update the cart display after clearing
    }
  </script>
  <script>
    function submitOrder() {
      const cart = JSON.parse(localStorage.getItem("cart")) || [];
      document.getElementById('cartInput').value = JSON.stringify(cart);
      document.getElementById('totalPriceInput').value = document.getElementById('totalPrice').textContent;

      const form = document.getElementById('orderForm');
      const formData = new FormData(form);

      fetch('store_order.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.text())
        .then(data => {
          alert(data);
          clearCart();
        })
        .catch(error => {
          console.error('Error:', error);
        });
    }

  </script>
</body>

</html>