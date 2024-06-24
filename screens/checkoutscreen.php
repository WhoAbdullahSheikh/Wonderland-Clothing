<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Wonderland</title>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="./css/checkoutscreen.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700&display=swap" />
  <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet" />
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
          <a href="./profilescreen.php"><i class="fa fa-user" style="font-size: 20px; color: white"></i></a>
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
    <br>
    <button onclick="goBack()"
      style="margin-left: 2%; font-size: 30px; text-decoration: none; color: black; font-weight: bold; border: none; background: none; cursor: pointer;">
      <i class="fa fa-chevron-circle-left"></i> Back
    </button>
    <br>
    <br>
    <div class="row" style="margin-left: 2%; margin-right: 1%">
      <div class="col-50">
        <h1>Delivery Address</h1>
        <form id="orderForm" method="POST" action="./processOrder.php">
          <br />
          <label for="fullname"><i class="fa fa-user"></i> Full Name</label>
          <input type="text" id="fullname" name="fullname" placeholder="Your Full Name" required />
          <label for="email"><i class="fa fa-envelope"></i> Email</label>
          <input type="email" id="email" name="email" placeholder="abc@example.com" required />
          <label for="address"><i class="fa fa-address-card-o"></i> Address</label>
          <input type="text" id="address" name="address" placeholder="Your delivery address" required />
          <label for="city"><i class="fa fa-institution"></i> City</label>
          <input type="text" id="city" name="city" placeholder="Your City" required />
          <div class="row">
            <div class="col-50">
              <label for="state">State</label>
              <input type="text" id="state" name="state" placeholder="Name of state" required />
            </div>
            <div class="col-50">
              <label for="zip">Zip</label>
              <input type="text" id="zip" name="zip" placeholder="12345" maxlength="5"
                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 5);" required />
            </div>
          </div>
          <br />
          <label for="cashondelivery">
            <input type="checkbox" name="cashondelivery" id="cashondelivery" />
            Cash on Delivery</label>
          <input type="hidden" id="cartData" name="cartData" />
          <button type="button" onclick="submitOrder()" class="btn">Confirm Order</button>
        </form>
      </div>
      <div class="col-25">
        <div class="container">
          <h4>
            Cart
            <span class="price" style="color: black"><i class="fa fa-shopping-cart"></i>
              <b id="cartItemCount">0</b></span>
          </h4>
          <div id="cartItems" style="margin-top: 20px; margin-bottom: 20px;"></div>
          <hr />
          <p>
            Total
            <span class="price" style="color: black"><b>Rs.<span id="totalPrice">0</span></b></span>
          </p>
          <button onclick="clearCart()" class="btn">Clear Cart</button>
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
    }

    function clearCart() {
      localStorage.removeItem("cart");
      displayCart(); // Update the cart display after clearing
    }

    function submitOrder() {
      const cart = JSON.parse(localStorage.getItem("cart")) || [];
      if (cart.length === 0) {
        alert("Your cart is empty!");
        return;
      }

      const orderData = {
        fullname: document.getElementById("fullname").value,
        email: document.getElementById("email").value,
        address: document.getElementById("address").value,
        city: document.getElementById("city").value,
        state: document.getElementById("state").value,
        zip: document.getElementById("zip").value,
        cashondelivery: document.getElementById("cashondelivery").checked,
        cartData: JSON.stringify(cart) // Correctly stringify cart data
      };

      const formData = new FormData();
      for (const [key, value] of Object.entries(orderData)) {
        formData.append(key, value);
      }

      fetch("./processOrder.php", {
        method: "POST",
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          if (data.status === "success") {
            if (orderData.cashondelivery) {
              window.location.href = "./orderplace.php?order_id=" + data.order_id; // Navigate to confirmation page for Cash on Delivery
            } else {
              window.location.href = "./payment.php?order_id=" + data.order_id; // Navigate to payment page
            }
            clearCart();
            document.getElementById("orderForm").reset();
          } else {
            alert("Error placing order: " + data.message);
          }
        })
        .catch(error => {
          console.error("Error:", error);
          alert("An error occurred while placing the order.");
        });
    }
  </script>
  <script>
    function goBack() {
      window.history.back();
    }
  </script>

</body>

</html>
