<?php
    session_start();

    if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
      echo 'You are not allowed in this page. Please log in and try again';
      exit();
    }
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
  <meta charset="utf-8">
  <title>SKTETUAN|ADMIN</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

  <link rel="shortcut icon" type="image/x-icon" href="assets/img/sklogo.png">

  <link href="../../../../css?family=Roboto:300,400,500,700,900" rel="stylesheet">

  <link rel="stylesheet" href="assets/css/bootstrap.min.css">

  <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">

  <link rel="stylesheet" href="assets/css/fullcalendar.min.css">

  <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">

  <link rel="stylesheet" href="assets/plugins/morris/morris.css">

  <link rel="stylesheet" href="assets/css/style.css">
    <style>
  /* Define your custom colors */
  :root {
      --primary-color: #ff0000;
      --secondary-color: #0080ff; 
      --list-color: #0000ff;
  }

  .header {
      background-color: var(--secondary-color);
  }

  .sidebar-ul li a {
      color: var(--list-color);
  }

  /* Change the hover color of links */
  .sidebar-ul li a:hover {
      color: #ff0000;
  }

  .sidebar-ul li.active {
      background-color: blue !important; /* Change to your preferred shade of blue */
  }
  </style>
  </head>


  <body>

  <div class="main-wrapper">

  <div class="header-outer">
  <div class="header">
  <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fas fa-bars" aria-hidden="true" ></i></a>
  <a id="toggle_btn" class="float-left" href="javascript:void(0);">
  <img src="assets/img/sidebar/1q.png" alt="">
  </a>

  <ul class="nav float-left">
  <li>
  <div class="top-nav-search">
  <a href="javascript:void(0);" class="responsive-search">
  <i class="fa fa-search"></i>
  </a>
  </div>
  </li>
  <li>
  <a href="#" class="mobile-logo d-md-block d-lg-none d-block"><img src="assets/img/sklogo.png" alt="" width="30" height="30"></a>
  </li>
  </ul>

  <ul class="nav user-menu float-right">
  <li class="nav-item dropdown d-none d-sm-block">


  </a>
  <div class="dropdown-menu notifications">
  <div class="topnav-dropdown-header">
  <span>Notifications</span>
  </div>
  <div class="drop-scroll">
  <ul class="notification-list">
  <li class="notification-message">
  <a href="#">
  <div class="media">
  <span class="avatar">
  <img alt="John Doe" src="assets/img/user-06.jpg" class="img-fluid rounded-circle">
  </span>
  <div class="media-body">
  <p class="noti-details"><span class="noti-title">John Doe</span> is now following you </p>
  <p class="noti-time"><span class="notification-time">4 mins ago</span></p>
  </div>
  </div>
  </a>
  </li>
  <li class="notification-message">
  <a href="#">
  <div class="media">
  <span class="avatar">T</span>
  <div class="media-body">
  <p class="noti-details"><span class="noti-title">Tarah Shropshire</span> sent you a message.</p>
  <p class="noti-time"><span class="notification-time">6 mins ago</span></p>
  </div>
  </div>
  </a>
  </li>
  <li class="notification-message">
  <a href="#">
  <div class="media">
  <span class="avatar">L</span>
  <div class="media-body">
  <p class="noti-details"><span class="noti-title">Misty Tison</span> like your photo.</p>
  <p class="noti-time"><span class="notification-time">8 mins ago</span></p>
  </div>
  </div>
  </a>
  </li>
  <li class="notification-message">
  <a href="#">
  <div class="media">
  <span class="avatar">G</span>
  <div class="media-body">
  <p class="noti-details"><span class="noti-title">Rolland Webber</span> booking appoinment for meeting.</p>
  <p class="noti-time"><span class="notification-time">12 mins ago</span></p>
  </div>
  </div>
  </a>
  </li>
  <li class="notification-message">
  <a href="#">
  <div class="media">
  <span class="avatar">T</span>
  <div class="media-body">
  <p class="noti-details"><span class="noti-title">Bernardo Galaviz</span> like your photo.</p>
  <p class="noti-time"><span class="notification-time">2 days ago</span></p>
  </div>
  </div>
  </a>
  </li>
  </ul>
  </div>
  <div class="topnav-dropdown-footer">
  <a href="#">View all Notifications</a>
  </div>
  </div>
  </li>

  <li class="nav-item dropdown d-none d-sm-block">
  </li>
  <li class="nav-item dropdown has-arrow">
      <a href="#" class=" nav-link user-link" data-toggle="dropdown">      
          <span class="status online"></span>
          <span><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?></span>
      </a>
  <div class="dropdown-menu">
  <a class="dropdown-item" href="loginform/logout.php">Logout</a>
  </div>
  </li>
  </ul>
  <div class="dropdown mobile-user-menu float-right"> 
  <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
  <div class="dropdown-menu dropdown-menu-right">

  <a class="dropdown-item" href="loginform/logout.php">Logout</a>
  </div>
  </div>
  </div>
  </div>


  <div class="sidebar" id="sidebar">
  <div class="sidebar-inner slimscroll">
  <div id="sidebar-menu" class="sidebar-menu">
  <div class="header-left">
  <a href="dashboard.php" class="logo">
  <img src="assets/img/sklogo.png" width="40" height="40" alt="">
  <span class="text-uppercase">sk tetuan</span>
  </a>
  </div>
  <ul class="sidebar-ul">
  <li class="menu-title">Menu</li>
  <li class="">
  <a href="dashboard.php"><img src="assets/img/sidebar/da.png" alt="icon"><span>Dashboard</span></a>
  </li>
  <li class="submenu">
  <a href="#"><img src="assets/img/sidebar/smem.png" alt="icon"> <span> sk members</span> <span class="menu-arrow"></span></a>
  <ul class="list-unstyled" style="display: none;">
  <li><a href="skmem.php"><span>All SK MEMBERS</span></a></li>
  </ul>
  </li>
  <li class="submenu">
  <a href="#"><img src="assets/img/sidebar/ann1.png" alt="icon"> <span>announcement</span> <span class="menu-arrow"></span></a>
  <ul class="list-unstyled" style="display: none;">
  <li><a href="crudann.php"><span>All announcement</span></a></li>
  <li><a href="add_an.php"><span>Add announcement</span></a></li>

  </ul>
  </li>
  <li class="submenu">
  <a href="#"><img src="assets/img/sidebar/app1.png" alt="icon"> <span> appointments</span> <span class="menu-arrow"></span></a>
  <ul class="list-unstyled" style="display: none;">
  <li><a href="rev_app.php"><span>appoinment schedule</span></a></li>
  <li><a href="pendingapp.php"><span>pending schedule</span></a></li>
  </ul>
  </li>

  <li class="submenu">
  <a href="#"><img src="assets/img/sidebar/app1.png" alt="icon"> <span> inventory</span> <span class="menu-arrow"></span></a>
  <ul class="list-unstyled" style="display: none;">
  <li><a href="borrows.php"><span>borrowed</span></a></li>
  <li><a href="supplies.php"><span>supplies</span></a></li>
  <li><a href="category.php"><span>categories</span></a></li>
  </ul>
  </li>


  <li class="submenu">
  <ul style="display: none;">
  <li class="submenu">
  <a href="javascript:void(0);"><span>Email</span> <span class="menu-arrow"></span></a>
  <ul style="display: none;">
  <li><a href="#"><span>Compose Mail</span></a></li>
  <li>
  <a href="inbox.html"> <span> Inbox</span> </a>
  </li>
  <li><a href="inbox.html"><span>Mailview</span></a></li>
  </ul>
  </li>
  <li>
  <a href="#"> Chat <span class="badge badge-pill bg-primary float-right">5</span></a>
  </li>
  <li class="submenu">
  <a href="#"><span> Calls</span> <span class="menu-arrow"></span></a>
  <ul class="list-unstyled" style="display: none;">
  <li><a href="inbox.html"><span>Voice Call</span></a></li>
  <li><a href="inbox.html"><span>Video Call</span></a></li>
  <li><a href="inbox.html"><span>Incoming Call</span></a></li>
  </ul>
  </li>
  <li>
  <a href="inbox.html"><span> Contacts</span></a>
  </li>
  </ul>
  </li>
  <li>
  <a href="profilingyouth.php"><img src="assets/img/sidebar/y.png" alt="icon"> <span>youth profiling</span></a>
  </li>
  <li>
  <a href="users.php"><img src="assets/img/sidebar/y.png" alt="icon"> <span>users</span></a>
  </li>
  <li>
  <a href="report.php"><img src="assets/img/sidebar/y.png" alt="icon"> <span>reports</span></a>
  </li>
  <li>
  <a href="submission.php"><img src="assets/img/sidebar/y.png" alt="icon"> <span>submission box</span></a>
  </li>


  <li class="submenu">

  <ul class="list-unstyled" style="display: none;">
  <li><a href="inbox.html"><span>Invoices</span></a></li>
  <li><a href="inbox.html"><span>Payments</span></a></li>
  <li><a href="inbox.html"><span>Expenses</span></a></li>
  <li><a href="inbox.html"><span>Provident Fund</span></a></li>
  <li><a href="inbox.html"><span>Taxes</span></a></li>
  </ul>
  </li>
  <li class="submenu">

  <ul class="list-unstyled" style="display: none;">
  <li><a href="inbox.html"><span> Employee Salary </span></a></li>
  <li><a href="inbox.html"><span> Payslip </span></a></li>
  </ul>
  </li>
  <li class="submenu">

  <ul class="list-unstyled" style="display: none;">
  <li><a href="inbox.html"><span>Blog</span></a></li>
  <li><a href="inbox.html"><span>Blog View</span></a></li>
  <li><a href="inbox.html"><span>Add Blog</span></a></li>
  <li><a href="inbox.html"><span>Edit Blog</span></a></li>
  </ul>
  </li>
  <li class="submenu">

  <ul style="display: none;">
  <li class="submenu">
  <a href="#"><span> Employees</span> <span class="menu-arrow"></span></a>
  <ul class="list-unstyled" style="display: none;">
  <li><a href="inbox.html"><span>All Employees</span></a></li>
  <li><a href="inbox.html"><span>Holidays</span></a></li>
  <li><a href="inbox.html"><span>Leave Requests</span> <span class="badge badge-pill bg-primary float-right">1</span></a></li>
  <li><a href="inbox.html"><span>Attendance</span></a></li>
  <li><a href="inbox.html"><span>Departments</span></a></li>
  <li><a href="inbox.html"><span>Designations</span></a></li>
  </ul>
  </li>
  <li>
  <a href="#"><span>Activities</span></a>
  </li>
  <li>
  <a href="inbox.html"><span>Users</span></a>
  </li>
  <li class="submenu">
  <a href="#"><span> Reports </span> <span class="menu-arrow"></span></a>
  <ul class="list-unstyled" style="display: none;">
  <li><a href="inbox.html"> <span>Expense Report </span></a></li>
  <li><a href="inbox.html"> <span>Invoice Report</span> </a></li>
  </ul>
  </li>
  </ul>
  </li>
  <li>


  </ul>
  </li>

  </ul>
  </div>
  </div>
  </div>

  
  <div class="page-wrapper">
  <div class="content container-fluid">

    <!-- Modal for adding items -->
    <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addItemModalLabel">Add New Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Replace your existing form with the updated one -->
                <form id="addItemForm" method="POST" action="add_items.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="itemName">Item Name</label>
                        <input type="text" class="form-control" id="itemName" name="itemName" required>
                    </div>
                    <div class="form-group">
                        <label for="itemQuantity">Quantity</label>
                        <input type="number" class="form-control" id="itemQuantity" name="itemQuantity" required>
                    </div>
                    <div class="form-group">
                        <label for="itemCategory">Category</label>
                        <select class="form-control" id="itemCategory" name="itemCategory" required>
                            <!-- Categories will be dynamically populated here -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="itemPhoto">Photo</label>
                        <input type="file" class="form-control-file" id="itemPhoto" name="itemPhoto" accept="image/*" required>
                    </div>
                    <!-- Add more fields as needed -->
                    <button type="submit" class="btn btn-primary">Add Item</button>
                </form>
            </div>
        </div>
    </div>
</div>


    <div class="page-header">
      <div class="row">
        <div class="col-md-6">
          <h3 class="page-title mb-0">Supplies</h3>
        </div>
        <!-- Button to trigger the modal -->
        <div class="col-md-6 text-right">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addItemModal">
            Add Item
          </button>
        </div>
      </div>
    </div>



    <div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>Category</th>
                                <th>Photo</th>
                                <th>Actions</th> <!-- Add a new column for actions -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            error_reporting(E_ALL);
                            ini_set('display_errors', 1);
                            // Include database connection file
                            include("../db_conn.php");

                            // Check if connection is successful
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            // Query to retrieve items from the database
                            $sql = "SELECT items.id, items.name AS itemName, items.quantity, categories.name AS categoryName, items.photo_path
                                    FROM items
                                    INNER JOIN categories ON items.category_id = categories.id";
                            $result = $conn->query($sql);

                            // Check if the query executed successfully
                            if (!$result) {
                                die("Query failed: " . $conn->error);
                            }

                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["id"] . "</td>";
                                    echo "<td>" . $row["itemName"] . "</td>";
                                    echo "<td>" . $row["quantity"] . "</td>";
                                    echo "<td>" . $row["categoryName"] . "</td>";
                                    echo "<td><img src='../admin/" . $row["photo_path"] . "' alt='Item Photo' style='max-width: 100px; max-height: 100px;'></td>";
                                    // Add edit and delete buttons
                                    echo "<td>";
                                    echo "<button class='btn btn-sm btn-primary' onclick='editItem(" . $row["id"] . ", \"" . $row["itemName"] . "\", \"" . $row["photo_path"] . "\", " . $row["quantity"] . ")'>Edit</button> ";
                                    echo "<button class='btn btn-sm btn-danger' onclick='deleteItem(" . $row["id"] . ")'>Delete</button>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No items found</td></tr>";
                            }

                            // Close connection
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Edit Item Modal -->
<div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="editItemModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editItemModalLabel">Edit Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editItemForm" enctype="multipart/form-data">
                    <input type="hidden" id="editItemId" name="editItemId" value="">
                    <div class="form-group">
                        <label for="editItemName">Item Name</label>
                        <input type="text" class="form-control" id="editItemName" name="editItemName" required>
                    </div>
                    <div class="form-group">
                        <label for="editItemQuantity">Quantity</label>
                        <input type="number" class="form-control" id="editItemQuantity" name="editItemQuantity" required>
                    </div>
                    <div class="form-group">
                        <label for="editItemPhoto">Photo</label>
                        <input type="file" class="form-control-file" id="editItemPhoto" name="editItemPhoto" accept="image/*">
                        <div id="editItemPhotoPreview"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>



<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/select2.min.js"></script>
<script src="assets/js/moment.min.js"></script>
<script src="assets/js/fullcalendar.min.js"></script>
<script src="assets/js/jquery.fullcalendar.js"></script>
<script src="assets/plugins/morris/morris.min.js"></script>
<script src="assets/plugins/raphael/raphael-min.js"></script>
<script src="assets/js/apexcharts.js"></script>
<script src="assets/js/chart-data.js"></script>
<script src="assets/js/chart.js"></script>
<script src="assets/js/app.js"></script>

<script>
    $(document).ready(function() {
        // AJAX request to fetch categories
        $.ajax({
            url: 'get_categories.php',
            type: 'GET',
            success: function(response) {
                // Populate the category dropdown with received data
                $('#itemCategory').html(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    // Function to handle editing an item
    function editItem(itemId, itemName, photoPath, quantity) {
        // Populate the modal fields with the item data
        $('#editItemId').val(itemId);
        $('#editItemName').val(itemName);
        $('#editItemPhoto').html('<img src="../admin/' + photoPath + '" alt="Item Photo" style="max-width: 100px; max-height: 100px;">');
        $('#editItemQuantity').val(quantity);

        // Show the edit item modal
        $('#editItemModal').modal('show');
    }

    // Function to handle submitting the edited item via AJAX
    function submitEditedItem() {
        // Get form data
        var formData = new FormData($('#editItemForm')[0]);

        // AJAX request to edit the item
        $.ajax({
            url: 'edit_item.php', // PHP script to handle item editing
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // If item edited successfully, reload the page to display the updated list
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    // Submit form on form submission
    $('#editItemForm').submit(function(event) {
        event.preventDefault();
        submitEditedItem();
    });

    // Function to handle deleting an item
    function deleteItem(itemId) {
        // Confirm deletion
        if (confirm('Are you sure you want to delete this item?')) {
            // AJAX request to delete the item
            $.ajax({
                url: 'delete_item.php', // PHP script to handle item deletion
                type: 'POST',
                data: { id: itemId },
                success: function(response) {
                    // If item deleted successfully, reload the page to reflect the changes
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    }
</script>

</body>
</html>

