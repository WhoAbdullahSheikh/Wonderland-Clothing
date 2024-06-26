<?php
$order_id = $_GET['order_id'];
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Wonderland</title>
    <script
      src="https://kit.fontawesome.com/a076d05399.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="./ecommerce.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700&display=swap"
    />
    <link
      href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css"
      rel="stylesheet"
    />

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
        justify-content: flex-end; /* Align items to the right */
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
        width: 85%; /* Adjust the width as needed */
        border: none;
        height: 1px;
        margin: 0 auto; /* Center the line horizontally */
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
      .maintenance-message {
        text-align: center;
        margin-top: 10%;
        font-size: 34px;
        color: rgb(0, 0, 0);
 
        padding-bottom: 13%;
        justify-content: center;
        align-items: center;
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
            <a href="./profilescreen.php"
              ><i class="fa fa-user" style="font-size: 20px; color: white"></i
            ></a>
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
      <div class="maintenance-message">
        <dotlottie-player
          style="
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 200px;
          "
          src="https://lottie.host/fb11aebf-2fec-471b-90c5-b6f832d5d85f/xaqaB9ZGHS.json"
          background="transparent"
          speed="1"
          loop
          autoplay
        ></dotlottie-player>
        <h2>Congratulations</h2>
        <br>
        Your order has been placed. <br> Your order ID is "<strong><?php echo htmlspecialchars($order_id); ?></strong>" 
      </div>
      <script
        src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs"
        type="module"
      ></script>
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
   
  </body>
</html>
