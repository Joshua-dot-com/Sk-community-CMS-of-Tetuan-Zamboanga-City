<?php
  session_start();

  if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    echo 'You are not allowed in this page. Please log in and try again';
    exit();
  }
 include_once "../db_conn.php";

// Query to select all SK members
$sql = "SELECT * FROM sk_kagawads";
$result = mysqli_query($conn, $sql);
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

<!-- Plus button modal -->
<div class="modal fade" id="addMemberModal" tabindex="-1" role="dialog" aria-labelledby="addMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMemberModalLabel">Add SK Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add SK member form -->
                <form id="addMemberForm" method="POST" action="add_member.php">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="position">Position</label>
                        <input type="text" class="form-control" id="position" name="position" required>
                    </div>
                    <div class="form-group">
                        <label for="barangay">Barangay</label>
                        <input type="text" class="form-control" id="barangay" name="barangay" required>
                    </div>
                    <div class="form-group">
                        <label for="municipality">Municipality</label>
                        <input type="text" class="form-control" id="municipality" name="municipality" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="contact_number">Contact Number</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number">
                    </div>
                    <div class="form-group">
                        <label for="about_me">About Me</label>
                        <textarea class="form-control" id="about_me" name="about_me" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="profile_picture">Profile Picture</label>
                        <input type="file" class="form-control-file" id="profile_picture" name="profile_picture">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Member Modal -->
<div class="modal fade" id="editMemberModal" tabindex="-1" role="dialog" aria-labelledby="editMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMemberModalLabel">Edit SK Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <!-- Edit SK member form -->
                <form id="editMemberForm" method="POST" action="edit_member.php">
                    <input type="hidden" id="edit_member_id" name="edit_member_id">
                    <div class="form-group">
                        <label for="edit_name">Name</label>
                        <input type="text" class="form-control" id="edit_name" name="edit_name" >
                    </div>
                    <div class="form-group">
                        <label for="edit_position">Position</label>
                        <input type="text" class="form-control" id="edit_position" name="edit_position" >
                    </div>
                    <div class="form-group">
                        <label for="edit_barangay">Barangay</label>
                        <input type="text" class="form-control" id="edit_barangay" name="edit_barangay" >
                    </div>
                    <div class="form-group">
                        <label for="edit_municipality">Municipality</label>
                        <input type="text" class="form-control" id="edit_municipality" name="edit_municipality" >
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="edit_email">
                    </div>
                    <div class="form-group">
                        <label for="edit_contact_number">Contact Number</label>
                        <input type="text" class="form-control" id="edit_contact_number" name="edit_contact_number">
                    </div>
                    <div class="form-group">
                        <label for="edit_about_me">About Me</label>
                        <textarea class="form-control" id="edit_about_me" name="edit_about_me" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_profile_picture">Profile Picture</label>
                        <input type="file" class="form-control-file" id="edit_profile_picture" name="edit_profile_picture">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <!-- Plus button -->
                <div class="col-md-6">
                    <h3 class="page-title mb-0">SK MEMBERS</h3>
                </div>
                <div class="col-md-6 text-right">
                    <div class="plus-btn">
                        <!-- Trigger modal on button click -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMemberModal">
                            <i class="fas fa-plus"></i> Add SK Member
                        </button>
                    </div>
                </div>
            </div>
        </div>




          <div class="row">
          <?php
// Display SK members
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="col-md-4">';
        echo '<div class="card">';
        echo '<img src="' . $row["profile_picture"] . '" class="card-img-top" alt="Profile Picture">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $row["name"] . '</h5>';
        echo '<p class="card-text">Position: ' . $row["position"] . '</p>';
        echo '<p class="card-text">Barangay: ' . $row["barangay"] . '</p>';
        echo '<p class="card-text">Municipality: ' . $row["municipality"] . '</p>';
        echo '<p class="card-text">Email: ' . $row["email"] . '</p>';
        echo '<p class="card-text">Contact Number: ' . $row["contact_number"] . '</p>';
        echo '<p class="card-text">About Me: ' . $row["about_me"] . '</p>';

        // Add edit and delete buttons
        echo '<div class="btn-group" role="group" aria-label="Edit and Delete">';
        echo '<button type="button" class="btn btn-primary" onclick="editMember(' . $row["id"] . ')">Edit</button>';
        echo '<button type="button" class="btn btn-danger" onclick="deleteMember(' . $row["id"] . ')">Delete</button>';
        echo '</div>';

        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<div class="col-md-12">';
    echo '<p>No SK members found.</p>';
    echo '</div>';
}
?>

            </div>
        </div>
    </div>


    <div class="plus-btn">
    <a href="add_member.php"><i class="fas fa-plus"></i></a>
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

<script src="assets/js/app.js"></script>

<script>
$(document).ready(function() {
    $('#addMemberForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'add_member.php',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.trim() === 'success') {
                    // Display success message
                    alert('SK member added successfully.');
                    // Close modal
                    $('#addMemberModal').modal('hide');
                    // Optionally, reload or update the page to reflect the changes
                    window.location.reload(true);
                } else {
                    alert('Error: ' + response);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Error: ' + xhr.responseText);
            }
        });
    });
});
</script>

<script>
        // Edit SK Member
        function editMember(memberId) {
            // Fetch member details via AJAX and populate the edit form
            $.ajax({
                type: 'GET',
                url: 'get_member_details.php', // Replace with your endpoint to fetch member details
                data: { member_id: memberId },
                dataType: 'json',
                success: function(response) {
                    // Populate the edit form with member details
                    $('#edit_member_id').val(response.id);
                    $('#edit_name').val(response.name);
                    $('#edit_position').val(response.position);
                    // Update other fields as needed
                    // Show the edit modal
                    $('#editMemberModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Error: ' + xhr.responseText);
                }
            });
        }
    </script>

<script>
// Handle edit form submission
$('#editMemberForm').submit(function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'edit_member.php', // Replace with your endpoint to edit member details
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.trim() === 'success') {
                // Display success message
                alert('SK member details updated successfully.');
                // Close modal
                $('#editMemberModal').modal('hide');
                // Optionally, reload or update the page to reflect the changes
                window.location.reload(true);
            } else {
                alert('Error: ' + response);
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('Error: ' + xhr.responseText);
        }
    });
});
</script>

<script>
// Handle member deletion
function deleteMember(memberId) {
    // Confirm deletion
    if (confirm('Are you sure you want to delete this member?')) {
        // Send AJAX request to delete_member.php
        $.ajax({
            type: 'POST',
            url: 'delete_member.php',
            data: { member_id: memberId },
            success: function(response) {
                if (response.trim() === 'success') {
                    // Display success message
                    alert('SK member deleted successfully.');
                    // Optionally, reload or update the page to reflect the changes
                    window.location.reload(true);
                } else {
                    // Display error message
                    alert('Error: ' + response);
                }
            },
            error: function(xhr, status, error) {
                // Display error message
                console.error(xhr.responseText);
                alert('Error: ' + xhr.responseText);
            }
        });
    }
}
</script>

</body>
</html>