<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Wonderland</title>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="./css/payment.css?v=1.0" />
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
      style="margin-left: 10%; font-size: 30px; text-decoration: none; color: black; font-weight: bold; border: none; background: none; cursor: pointer;">
      <i class="fa fa-chevron-circle-left"></i> Back
    </button>

    <div class="center-content">
      <h1 style="font-size: 40px;">Scan & Make your payment</h1>
      <br>
      <img id="qrcode" src="./components/accounts/qrcode.jpeg" alt="QR Code" width="450" height="450">
      <br>
      <br>

      <h1 style="font-size: 30px;"> Open <a style="color:green;">Easy</a>paisa > <i class="fa fa-qrcode"
          style="color:green;"></i> > Scan</h1>
      <form id="paymentForm" action="./components/upload_receipt.php" method="post" enctype="multipart/form-data">
        <br>
        <br>
        <h1 style="font-size: 20px; font-weight: lighter;">(Press below button to upload transaction receipt screenshot)
        </h1>
        <div class="input-container image-upload">
          <input type="file" id="uploadfile" name="uploadfile" accept="image/*" required />
          <label for="uploadfile">Upload Transaction Receipt</label>
          <span class="file-name" id="file-name">No file chosen</span>
          <br>
          <input type="hidden" name="order_id" id="order_id">
          <br>
          <button class="btn btn-primary" type="submit" name="upload">Payment Confirm</button>
        </div>

      </form>
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
    function goBack() {
      window.history.back();
    }

    function getOrderIdFromURL() {
      const urlParams = new URLSearchParams(window.location.search);
      return urlParams.get('order_id');
    }

    function confirmOrder() {
      const orderId = getOrderIdFromURL();
      if (orderId) {
        document.getElementById('order_id').value = orderId;
      } else {
        alert("Order ID not found!");
      }
    }

    document.addEventListener("DOMContentLoaded", function () {
      confirmOrder();
    });

    document.getElementById('uploadfile').addEventListener('change', function () {
      const fileName = this.files[0] ? this.files[0].name : 'No file chosen';
      document.getElementById('file-name').textContent = fileName;
    });
  </script>
</body>

</html>