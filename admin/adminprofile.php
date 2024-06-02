<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in and is an admin.
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'admin@wonderland.com') {
  header('Location: loginscreen.php'); // Redirect to login page if not admin
  exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wonderland";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch counts for approved and rejected products
$sqlApproved = "SELECT COUNT(*) AS count_approved FROM products WHERE status = 'approved'";
$resultApproved = $conn->query($sqlApproved);
$approvedCount = $resultApproved->fetch_assoc()['count_approved'];

$sqlRejected = "SELECT COUNT(*) AS count_rejected FROM products WHERE status = 'rejected'";
$resultRejected = $conn->query($sqlRejected);
$rejectedCount = $resultRejected->fetch_assoc()['count_rejected'];

// Fetch product data for approval section
$sqlPending = "SELECT products.id, products.p_name, products.description, products.filename, products.p_condition, products.price, products.email, users.fullname 
               FROM products 
               JOIN users ON products.email = users.email
               WHERE products.status = 'pending'";
$resultPending = $conn->query($sqlPending);

// Fetch product data for listing section
$sql = "SELECT filename, id, p_name, description, price, category, p_condition, status, feedback 
        FROM products 
        WHERE status = 'Approved' OR status = 'Rejected' 
        ORDER BY id ASC";
$result = $conn->query($sql);
if ($result === false) {
  echo "Error fetching the products: " . $conn->error;
  $products = [];
} else {
  $products = $result->fetch_all(MYSQLI_ASSOC);
}

// Fetch orders and their items
$sqlOrders = "SELECT 
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
              WHERE orders.status = 'Pending'";

$resultOrders = $conn->query($sqlOrders);

if ($resultOrders === false) {
  echo "Error fetching orders: " . $conn->error;
  $orders = [];
} else {
  $orders = $resultOrders->fetch_all(MYSQLI_ASSOC);
}


// Check if "approve" or "reject" actions have been triggered
if (isset($_GET['action'], $_GET['id']) && in_array($_GET['action'], ['approve', 'reject'])) {
  $newStatus = $_GET['action'] === 'approve' ? 'approved' : 'rejected';
  $feedback = isset($_POST['feedback']) ? $_POST['feedback'] : '';

  $stmt = $conn->prepare("UPDATE products SET status = ?, feedback = ? WHERE id = ?");
  $stmt->bind_param('ssi', $newStatus, $feedback, $_GET['id']);
  $stmt->execute();
  $stmt->close();

  // Redirect to prevent resubmission
  header('Location: adminprofile.php');
  exit();
}

// Check if a product delete action has been triggered
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $productId = $_GET['id'];

  // SQL to delete the product
  $sql = "DELETE FROM products WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $productId);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    echo "<script>alert('Product deleted successfully.'); window.location.href='./adminprofile.php';</script>";
  } else {
    echo "<script>alert('Error deleting product.'); window.location.href='./adminprofile.php';</script>";
  }

  $stmt->close();
}

// Close database connection
$conn->close();
?>



<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Wonderland</title>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="./adminprofile.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700&display=swap" />
  <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />


</head>

<body>
  <header>
    <div id="mySidenav" class="sidenav">
      <a href="#" id="approvalButton" onclick="toggleSections('profile')">
        <i class="fas fa-user"></i>
        <span>Approvals</span>
      </a>
      <a href="#" id="listingButton" onclick="toggleSections('items')">
        <i class="material-icons">favorite</i>
        <span>Items Listings</span>
      </a>
      <a href="#" id="addedProductsButton" onclick="toggleSections('addedItems')">
        <i class="	fas fa-shopping-bag"></i>
        <span>Orders Approval</span>
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
        <li><a href="../screens/shopscreen.php" class="under">SHOP</a></li>


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
    <div id="approvalSection" style="background-color: white; color: black; padding: 20px; padding-left: 5%; ">
      <div class="profile-container">
        <h2>Products Approvals
          <button onclick="location.reload();" style="margin-left: 50px; cursor: pointer;" class="refresh-button">
            <i class="fa fa-refresh fa-spin"></i>
          </button>
        </h2>
        <div class="section-break">
          <hr />
        </div>
        <table style="width:100%">
          <tr>
            <th>Image</th>
            <th>Product Owner</th>
            <th>Owner's Email</th>
            <th>Product Name</th>
            <th>Description</th>
            <th>Condition</th>
            <th>Price</th>
            <th>Action</th>
          </tr>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td style="text-align: center;">
                <img src="../screens/image/<?= htmlspecialchars($row['filename']) ?>"
                  alt="<?= htmlspecialchars($row['p_name']) ?>" style="width: 100px; height: auto;">
              </td>
              <td style="text-align: center;"><?= htmlspecialchars($row['fullname']) ?></td>
              <td style="text-align: center;"><?= htmlspecialchars($row['email']) ?></td>
              <td style="text-align: center;"><?= htmlspecialchars($row['p_name']) ?></td>
              <td><?= htmlspecialchars($row['description']) ?></td>
              <td style="text-align: center;"><?= htmlspecialchars($row['p_condition']) ?></td>
              <td style="text-align: center;">Rs. <?= htmlspecialchars($row['price']) ?></td>
              <td style="text-align: center;">
                <a href="approve.php?id=<?= $row['id'] ?>&status=Approved" class="btn btn-approve">Approve</a>
                <a href="#" class="btn btn-reject" onclick="rejectProduct(<?= $row['id'] ?>)">Reject</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </table>
      </div>
    </div>
    <div id="itemsLisiting" style="background-color: white; color: black; padding: 20px; padding-left: 5%;">
      <div class="profile-container">
        <h2>Product Listing
          <button onclick="location.reload();" style="margin-left: 50px; cursor: pointer;" class="refresh-button">
            <i class="fa fa-refresh fa-spin"></i>
          </button>
        </h2>
        <div class="status-box approved">
          <strong>Approved Products: </strong> <?= $approvedCount ?>
        </div>
        <div class="status-box rejected">
          <strong>Rejected Products: </strong> <?= $rejectedCount ?>
        </div>

        <div class="section-break">
          <hr />
        </div>
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Image</th>
              <th>Product Name</th>
              <th>Description</th>
              <th>Price</th>
              <th>Category</th>
              <th>Condition</th>
              <th>Status</th>
              <th>Feedback</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product): ?>
              <tr>
                <td style="text-align: center;"><?= htmlspecialchars($product['id']) ?></td>
                <td style="text-align: center;">
                  <img src="../screens/image/<?= htmlspecialchars($product['filename']) ?>"
                    alt="<?= htmlspecialchars($product['p_name']) ?>" style="width: 100px; height: auto;">
                </td>
                <td><?= htmlspecialchars($product['p_name']) ?></td>
                <td><?= htmlspecialchars($product['description']) ?></td>
                <td style="text-align: center;">Rs. <?= htmlspecialchars($product['price']) ?></td>
                <td style="text-align: center;"><?= htmlspecialchars($product['category']) ?></td>
                <td style="text-align: center;"><?= htmlspecialchars($product['p_condition']) ?></td>
                <td style="text-align: center;"><?= htmlspecialchars($product['status']) ?></td>
                <td style="text-align: center;"><?= htmlspecialchars($product['feedback']) ?></td>
                <td style="text-align: center;">
                  <button onclick="deleteProduct(<?= $product['id']; ?>);" class="delete-button">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
            <?php if (empty($products)): ?>
              <tr>
                <td colspan="8">No products found</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div id="itemsAdded"
    style="width:100%; background-color: white; color: black; padding: 20px; padding-left: 15%; padding-top: 5%;">

    <h1>Orders Approval</h1>
    <div class="section-break">
      <hr />
    </div>
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
        <th>Action</th>
      </tr>
      <?php if (!empty($orders)): ?>
        <?php foreach ($orders as $order): ?>
          <tr>
            <td><?= htmlspecialchars($order['order_id']) ?></td>
            <td style="text-align: center;">
              <img src="../screens/image/<?= htmlspecialchars($order['filename']) ?>"
                alt="<?= htmlspecialchars($order['product_name']) ?>" style="width: 100px; height: auto;">
            </td>
            <td><?= htmlspecialchars($order['product_name']) ?></td>
            <td style="text-align: center;">Rs. <?= htmlspecialchars($order['product_price']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($order['product_quantity']) ?></td>
            <td><?= htmlspecialchars($order['customer_name']) ?></td>
            <td><?= htmlspecialchars($order['customer_email']) ?></td>
            <td><?= htmlspecialchars($order['address']) ?></td>
            <td><?= htmlspecialchars($order['city']) ?></td>
            <td><?= htmlspecialchars($order['state']) ?></td>
            <td><?= htmlspecialchars($order['zip']) ?></td>
            <td><?= htmlspecialchars($order['order_date']) ?></td>

            <td style="text-align: center;">

              <a href="./orders/approve_order.php?id=<?= $order['order_id'] ?>&status=Approved"
                class="btn btn-approve">Approve</a>
              <a href="./orders/reject_order.php?id=<?= $order['order_id'] ?>&status=Rejected"
                class="btn btn-reject">Reject</a>

            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="13" style="text-align: center;">No orders pending approval</td>
        </tr>
      <?php endif; ?>
    </table>

  </div>



  </div>

  <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
  <script src="./JS/cartscreen.js"></script>
  <script>
    function deleteProduct(productId) {
      if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
        window.location.href = './adminprofile.php?id=' + productId;
      }
    }
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {

      function toggleSections(section) {
        var approvalSection = document.getElementById("approvalSection");
        var itemsLisiting = document.getElementById("itemsLisiting");
        var itemsAdded = document.getElementById("itemsAdded");

        if (section === 'profile') {
          approvalSection.style.display = "block";
          itemsLisiting.style.display = "none";
          itemsAdded.style.display = "none";
        } else if (section === 'items') {
          approvalSection.style.display = "none";
          itemsLisiting.style.display = "block";
          itemsAdded.style.display = "none";

        } else if (section === 'addedItems') {
          approvalSection.style.display = "none";
          itemsLisiting.style.display = "none";
          itemsAdded.style.display = "block";
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
        } else {
          toggleSections('addedItems');
        }
      }


      // Restore sections on page load based on saved state or default to profile
      restoreSections();

      // Event listeners for menu buttons
      document.getElementById("approvalButton").addEventListener("click", function () {
        toggleSections('profile');
      });

      document.getElementById("listingButton").addEventListener("click", function () {
        toggleSections('items');
      });

      document.getElementById("addedProductsButton").addEventListener("click", function () {
        toggleSections('addedItems');
      });
    });
  </script>

  <script>
    function rejectProduct(productId) {
      var feedback = prompt("Please provide the reason for rejection:");
      if (feedback != null && feedback.trim() != "") {
        var form = document.createElement("form");
        form.method = "POST";
        form.action = "./adminprofile.php?action=reject&id=" + productId;

        var feedbackInput = document.createElement("input");
        feedbackInput.type = "hidden";
        feedbackInput.name = "feedback";
        feedbackInput.value = feedback;
        form.appendChild(feedbackInput);

        document.body.appendChild(form);
        form.submit();
      } else {
        alert("Feedback is required for rejection.");
      }
    }
  </script>





</body>

</html>