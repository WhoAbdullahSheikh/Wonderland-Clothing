<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

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

  $email = $_SESSION['email'];
  $sql = "SELECT id, fullname, email, contact, dob FROM users WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $fullname = isset($row['fullname']) ? htmlspecialchars($row['fullname']) : '';
    $email = isset($row['email']) ? htmlspecialchars($row['email']) : '';
    $contact = isset($row['contact']) ? htmlspecialchars($row['contact']) : '';
    $dob = isset($row['dob']) ? htmlspecialchars($row['dob']) : '';
  } else {
    $fullname = '';
    $email = '';
    $contact = '';
    $dob = '';
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $contact = isset($_POST['contact']) ? $_POST['contact'] : '';
    $dob = isset($_POST['dob']) ? $_POST['dob'] : '';

    // Validate fields to ensure they are not empty or null
    if (!empty($fullname) && !empty($email) && !empty($contact) && !empty($dob)) {
      $sql = "UPDATE users SET fullname = ?, email = ?, contact = ?, dob = ? WHERE email = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sssss", $fullname, $email, $contact, $dob, $email);
      $stmt->execute();
    }
  }

  $msg = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload'])) {
    $filenames = $_FILES["uploadfile"]["name"];
    $tempnames = $_FILES["uploadfile"]["tmp_name"];

    // Check if exactly 3 images are uploaded
    if (count($filenames) != 3 || count($tempnames) != 3) {
      echo '<script>alert("Error: You must upload exactly 3 images.");</script>';
      exit;
    }

    $category = $conn->real_escape_string($_POST['category']);
    $type = $conn->real_escape_string($_POST['type']);
    $p_condition = $_POST['p_condition'];
    $description = $_POST['description'];
    $p_name = $_POST['p_name'];
    $price = $_POST['price'];
    $status = 'pending';
    $email = $_SESSION['email'];

    $target_dir = "./image/";
    $uploaded_files = array();

    for ($i = 0; $i < 3; $i++) {
      $target_file = $target_dir . basename($filenames[$i]);
      if (move_uploaded_file($tempnames[$i], $target_file)) {
        $uploaded_files[] = $filenames[$i];
      } else {
        echo '<script>alert("Failed to upload file ' . htmlspecialchars($filenames[$i]) . '");</script>';
        exit;
      }
    }

    // Prepare the SQL statement to avoid SQL injection
    $sql = "INSERT INTO products (email, p_name, description, price, category, type, p_condition, filename, filename2, filename3, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdsssssss", $email, $p_name, $description, $price, $category, $type, $p_condition, $uploaded_files[0], $uploaded_files[1], $uploaded_files[2], $status);
    $stmt->execute();
    $_SESSION['message'] = "Thank You! Your Product will go live after it gets approved by our team!";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
  }

  if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = $_GET['id'];
    $conn = new mysqli("localhost", "root", "", "wonderland");
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Ensure the product belongs to the user to prevent unauthorized deletions
    $sql = "DELETE FROM products WHERE id = ? AND email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $productId, $_SESSION['email']);
    if ($stmt->execute()) {
      echo "Product deleted successfully.";
    } else {
      echo "Error deleting product: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
    header('Location: ./profilescreen.php'); // Redirect back to the listing page
    exit;
  }

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
  <link rel="stylesheet" href="./css/profilescreen.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700&display=swap" />
  <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />


</head>

<body>
  <header>
    <div id="mySidenav" class="sidenav">
      <a href="#" id="profileButton" onclick="toggleSections('profile')">
        <i class="fas fa-user"></i>
        <span>Profile</span>
      </a>
      <a href="#" id="itemsButton" onclick="toggleSections('items')">
        <i class="material-icons">favorite</i>
        <span>Sell Product</span>
      </a>
      <a href="#" id="ordersButton" onclick="toggleSections('productStatus')">
        <i class="fa fa-shopping-bag"></i>
        <span>Orders</span></span>
      </a>
      <a href="#" id="addedProductsButton" onclick="toggleSections('itemsAdded')">
        <i class="fa fa-shopping-bag"></i>
        <span>Added Products</span>
      </a>
      <a href="#" id="statusButton" onclick="toggleSections('productStatus')">
        <i class="fa fa-clock-o"></i>
        <span>Product Status</span></span>
      </a>
      <hr>
      <a href="./logout.php">
        <i class="fas fa-sign-out-alt"></i>
        <span>Signout</span>
      </a>
    </div>

    <div class="logo">
      <a href="../home.php">Wonderland</a>
    </div>

    <div class="heading">
      <ul>
        <li><a href="../home.php" class="under">HOME</a></li>
        <li><a href="./shopscreen.php" class="under">SHOP</a></li>

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

  <div id="contentContainer">
    <div id="profileSection" style="background-color: white; color: black; padding: 20px; padding-left: 15%; ">
      <div class="profile-container">
        <h2>Personal Information
          <button onclick="location.reload();" style="margin-left: 70px; cursor: pointer;" class="refresh-button">
            <i class="fa fa-refresh fa-spin"></i>
          </button>
        </h2>
        <div class="section-break">
          <hr />
        </div>
        <div>
          <form action="profilescreen.php" method="post">
            <label for="fullname">Full Name</label>
            <input placeholder="Name" type="text" id="fullname" name="fullname" value="<?php echo $fullname; ?>">
            <br>
            <br>
            <label for="email">Email</label>
            <input placeholder="abc@example.com" type="email" id="email" name="email" value="<?php echo $email; ?>">
            <br>
            <br>
            <label for="contact">Contact</label>
            <input placeholder="+92-xxx-xxxxxxx" style="font-family:  Geneva, sans-serif" type="text" id="contact"
              name="contact" value="<?php echo $contact; ?>">
            <br>
            <br>
            <label for="dob">Date of Birth</label>
            <input style="width: 30%; padding: 10px; border: 1px solid black; border-radius: 10px; font-size: 15px;"
              type="date" id="dob" name="dob" value="<?php echo $dob; ?>">
            <br>
            <br>
            <button type="submit">Update</button>
          </form>
        </div>
      </div>
    </div>
    <div id="itemsSection" style="background-color: white; color: black; padding: 20px; padding-left: 15%;">
      <div class="profile-container">
        <h2>Product Details
          <button onclick="location.reload();" style="margin-left: 70px; cursor: pointer;" class="refresh-button">
            <i class="fa fa-refresh fa-spin"></i>
          </button>
        </h2>
        <div class="section-break">
          <hr />
        </div>
        <form id="productForm" action="./profilescreen.php" method="POST" enctype="multipart/form-data"
          onsubmit="return validateForm()">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" value="<?php echo $email; ?>">
          <div class="input-container">
            <label for="p_name">Product Name:</label>
            <input type="text" id="p_name" name="p_name" required>
          </div>
          <div class="input-container">
            <label for="category">Category:</label>
            <select id="category" name="category" required style="border-radius: 10px; padding: 10px; font-size: 15px;">
              <option value="">Select a Category</option>
              <option value="Men">Men's</option>
              <option value="Women">Women's</option>
            </select>
          </div>
          <div class="input-container">
            <label for="type">Type:</label>
            <select id="type" name="type" required style="border-radius: 10px; padding: 10px; font-size: 15px;">
              <option value="">Select Type</option>
              <option value="T-Shirts">T-Shirts</option>
              <option value="Jackets">Jackets</option>
              <option value="Jeans">Jeans</option>
              <option value="Tops">Tops</option>
              <option value="Frocks">Frocks</option>
            </select>
          </div>
          <div class="input-container">
            <label for="description">Description:</label>
            <textarea id="description" name="description" required
              style="border-radius: 10px; height: 200px; width: 40%; font-size: 15px; padding: 10px"></textarea>
          </div>
          <div class="input-container">
            <label for="p_condition">Condition:</label>
            <select id="p_condition" name="p_condition" required
              style="border-radius: 10px; padding: 10px; font-size: 15px;">
              <option value="">Select condition</option>
              <option value="Fair">Fair</option>
              <option value="Good">Good</option>
              <option value="Very Good">Very Good</option>
              <option value="Excellent">Excellent</option>
            </select>
          </div>
          <div class="input-container">
            <label for="price">Price:</label>
            <div class="price-wrapper">
              <span class="currency-prefix">Rs.</span>
              <input type="number" step="10" id="price" name="price" required
                style="border-radius: 10px; padding: 10px; font-size: 15px;">
            </div>
          </div>
          <div class="input-container image-upload">
            <input type="file" id="uploadfile" name="uploadfile[]" multiple required />
            <br>
            <br>
            <button class="btn btn-primary" type="submit" name="upload">Submit Product</button>
          </div>
          <br>
          <div class="section-break">
            <hr />
          </div>
        </form>
        <div id="display-image">
          <?php
          $conn = new mysqli($servername, $username, $password, $dbname); // Assume $conn is your active database connection
          $result = $conn->query("SELECT * FROM products WHERE email = '" . $conn->real_escape_string($_SESSION['email']) . "'");
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo '<div class="product-card">';
              echo '<img class="product-image" src="./image/' . htmlspecialchars($row['filename']) . '" alt="' . htmlspecialchars($row['p_name']) . '">';
              echo '<div class="product-info">';
              echo '<p>' . htmlspecialchars($row['p_name']) . '</p>';
              echo '<p>Type: ' . htmlspecialchars($row['type']) . '</p>';
              echo '</div>';
              echo '<div class="section-break-2"><hr/></div>';
              echo '<div class="product-desc">' . htmlspecialchars($row['description']) . '</div>';
              echo '<p class="product-price">Rs. ' . htmlspecialchars($row['price']) . '</p>';
              echo '</div>';
            }
          } else {
            echo "<p>No products found.</p>";
          }
          $conn->close();
          ?>
        </div>
      </div>
    </div>


    <div id="itemsAdded" style="background-color: white; color: black; padding: 20px; padding-left: 15%;">
      <div class="profile-container">
        <h2>Your Added Products
          <button onclick="location.reload();" style="margin-left: 70px; cursor: pointer;" class="refresh-button">
            <i class="fa fa-refresh fa-spin"></i>
          </button>
        </h2>
        <div class="section-break">
          <hr />
        </div>
        <div id="display-image">
          <?php
          $conn = new mysqli($servername, $username, $password, $dbname); // Assume $conn is your active database connection
          $result = $conn->query("SELECT * FROM products WHERE email = '" . $conn->real_escape_string($_SESSION['email']) . "'");
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo '<div class="product-card">';
              echo '<img class="product-image" src="./image/' . htmlspecialchars($row['filename']) . '" alt="' . htmlspecialchars($row['p_name']) . '">';
              echo '<div class="product-info">';
              echo '<p>' . htmlspecialchars($row['p_name']) . '</p>';
              echo '</div>';
              echo '<div class="section-break-2"> <hr/></div>';
              echo '<div class="product-desc">' . htmlspecialchars($row['description']) . '</div>';
              echo '<p class="product-price">Rs. ' . htmlspecialchars($row['price']) . '</p>';
              echo '</div>';
            }
          } else {
            echo "<p>No products found.</p>";
          }
          $conn->close();
          ?>
        </div>
      </div>
    </div>
    <div id="productStatus" style="background-color: white; color: black; padding: 20px; padding-left: 15%;">
      <div class="profile-container">
        <h2>Product Status
          <button onclick="location.reload();" style="margin-left: 70px; cursor: pointer;" class="refresh-button">
            <i class="fa fa-refresh fa-spin"></i>
          </button>
        </h2>
        <div class="section-break">
          <hr />
        </div>
        <?php
        $email = $_SESSION['email'] ?? null;

        if ($email) {
          $conn = new mysqli($servername, $username, $password, $dbname);

          if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }

          $sql = "SELECT id, filename, p_name, description, price, p_condition, status, feedback FROM products WHERE email = ?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("s", $email);
          $stmt->execute();
          $result = $stmt->get_result();

          ?>
          <table style="width:100%">
            <thead>
              <tr>

                <th>Image</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Condition</th>
                <th>Status</th>
                <th>Feedback</th>
                <th>Action</th> <!-- New column for delete action -->
              </tr>
            </thead>
            <tbody>
              <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td style="text-align: center;">
                    <img src="./image/<?= htmlspecialchars($row['filename']) ?>"
                      alt="<?= htmlspecialchars($row['p_name']) ?>" style="width: 100px; height: auto;">
                  </td>
                  <td style="text-align: center;"><?= htmlspecialchars($row['p_name']) ?></td>
                  <td><?= htmlspecialchars($row['description']) ?></td>
                  <td style="text-align: center;">Rs. <?= htmlspecialchars($row['price']) ?></td>
                  <td style="text-align: center;"><?= htmlspecialchars($row['p_condition']) ?></td>
                  <td style="text-align: center;">
                    <span class="<?= 'status-' . strtolower(htmlspecialchars($row['status'])) ?>">
                      <?= htmlspecialchars($row['status']) ?>
                    </span>
                  </td>
                  <td style="text-align: center; color: "><?= htmlspecialchars($row['feedback']) ?></td>
                  <td style="text-align: center;">
                    <button onclick="deleteProduct(<?= $row['id'] ?>);" class="delete-button">
                      <i class="fas fa-trash"></i>
                    </button>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>


          <?php
          $stmt->close();
          $conn->close();
        } else {
          // Redirect user to login page or inform them to log in
          echo "Please log in to view this page.";
        }
        ?>
      </div>
    </div>
    <div id="orders"
      style="width:100%; background-color: white; color: black; padding: 20px; padding-left: 15%; padding-top: 5%">
      <h1>Orders

      </h1>
      <div class="section-break">
        <hr />
      </div>
      <?php
      $email = $_SESSION['email'] ?? null;

      if ($email) {
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT 
                orders.id AS order_id,
                orders.fullname AS customer_name,
                orders.email AS customer_email,
                orders.address,
                orders.city,
                orders.state,
                orders.zip,
                orders.created_at AS order_date,
                order_items.product_name,
                order_items.product_price,
                order_items.product_quantity,
                products.filename
            FROM orders
            JOIN order_items ON orders.id = order_items.order_id
            JOIN products ON order_items.product_id = products.id
            WHERE products.email = ? AND orders.status = 'Approved'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        ?>

        <table style="width: 100%;">
          <tr>
            <th>Order ID</th>
            <th>Product Image</th>
            <th>Product Name</th>
            <th>Product Price</th>
            <th>Product Quantity</th>
            <th>Customer Name</th>
            <th>Customer Email</th>
            <th>Address</th>
            <th>City</th>
            <th>State</th>
            <th>ZIP</th>
            <th>Order Date</th>
          </tr>
          <?php
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              ?>
              <tr>
                <td><?= htmlspecialchars($row['order_id']) ?></td>
                <td><img src="./image/<?= htmlspecialchars($row['filename']) ?>"
                    alt="<?= htmlspecialchars($row['product_name']) ?>" style="width: 100px; height: auto;"></td>
                <td><?= htmlspecialchars($row['product_name']) ?></td>
                <td>Rs. <?= htmlspecialchars($row['product_price']) ?></td>
                <td><?= htmlspecialchars($row['product_quantity']) ?></td>
                <td><?= htmlspecialchars($row['customer_name']) ?></td>
                <td><?= htmlspecialchars($row['customer_email']) ?></td>
                <td><?= htmlspecialchars($row['address']) ?></td>
                <td><?= htmlspecialchars($row['city']) ?></td>
                <td><?= htmlspecialchars($row['state']) ?></td>
                <td><?= htmlspecialchars($row['zip']) ?></td>
                <td><?= htmlspecialchars($row['order_date']) ?></td>
              </tr>
              <?php
            }
          } else {
            ?>
            <tr>
              <td colspan="12" style="text-align: center;">No orders for delivery &#128577;</td>
            </tr>
            <?php
          }
          ?>
        </table>

        <?php
        $stmt->close();
        $conn->close();
      } else {
        echo "<p>Please log in to view this page.</p>";
      }
      ?>
    </div>

    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
    <script src="./JS/cartscreen.js"></script>
    <script>
      function deleteProduct(productId) {
        if (confirm('Are you sure you want to delete this product?')) {
          window.location.href = 'profilescreen.php?id=' + productId;
        }
      }
    </script>
    <script>
      function validateForm() {
        const uploadfile = document.getElementById('uploadfile');
        if (uploadfile.files.length !== 3) {
          alert("Error: You must upload exactly 3 images.");
          return false;
        }
        return true;
      }
    </script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {

        function toggleSections(section) {
          var profileSection = document.getElementById("profileSection");
          var itemsSection = document.getElementById("itemsSection");
          var itemsAdded = document.getElementById("itemsAdded");
          var productStatus = document.getElementById("productStatus");
          var orders = document.getElementById("orders");

          if (section === 'profile') {
            profileSection.style.display = "block";
            itemsSection.style.display = "none";
            itemsAdded.style.display = "none";
            productStatus.style.display = "none";
            orders.style.display = "none";

          } else if (section === 'items') {
            profileSection.style.display = "none";
            itemsSection.style.display = "block";
            itemsAdded.style.display = "none";
            productStatus.style.display = "none";
            orders.style.display = "none";

          } else if (section === 'itemsAdded') {
            profileSection.style.display = "none";
            itemsSection.style.display = "none";
            itemsAdded.style.display = "block";
            productStatus.style.display = "none";
            orders.style.display = "none";

          } else if (section === 'productStatus') {
            profileSection.style.display = "none";
            itemsSection.style.display = "none";
            itemsAdded.style.display = "none";
            productStatus.style.display = "block";
            orders.style.display = "none";

          } else if (section === 'orders') {
            profileSection.style.display = "none";
            itemsSection.style.display = "none";
            itemsAdded.style.display = "none";
            productStatus.style.display = "none";
            orders.style.display = "block";
          }
          localStorage.setItem("lastOpenedSection", section);
        }

        // Function to restore the section visibility from local storage or default to profile
        function restoreSections() {
          var lastOpenedSection = localStorage.getItem("lastOpenedSection");
          if (lastOpenedSection === 'items') {
            toggleSections('items');
          } else if (lastOpenedSection === 'profile') {
            toggleSections('profile');
          } else if (lastOpenedSection === 'itemsAdded') {
            toggleSections('itemsAdded');
          } else if (lastOpenedSection === 'productStatus') {
            toggleSections('productStatus');
          } else {
            toggleSections('orders');
          }
        }


        // Restore sections on page load based on saved state or default to profile
        restoreSections();

        // Event listeners for menu buttons
        document.getElementById("profileButton").addEventListener("click", function () {
          toggleSections('profile');
        });

        document.getElementById("itemsButton").addEventListener("click", function () {
          toggleSections('items');
        });

        document.getElementById("addedProductsButton").addEventListener("click", function () {
          toggleSections('itemsAdded');
        });
        document.getElementById("statusButton").addEventListener("click", function () {
          toggleSections('productStatus');
        });
        document.getElementById("ordersButton").addEventListener("click", function () {
          toggleSections('orders');
        });

      });
    </script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        <?php if (isset($_SESSION['message'])): ?>
          alert("<?= $_SESSION['message']; ?>");
          <?php unset($_SESSION['message']); // Clear the message after displaying it    
            ?>                                                <?php endif; ?>
      });
    </script>





</body>

</html>