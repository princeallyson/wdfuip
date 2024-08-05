<?php
require ("../config/db_connection.php");

session_start();
require ("../config/session_timeout.php");

if(!isset($_SESSION['id'])){
  header("location: ../config/not_login-error.html");
}
else{
  if($_SESSION['user_level'] == "Faculty"){
    header("location: ../config/user_level-error.html");
  }
  if($_SESSION['user_level'] == "Student"){
    header("location: ../config/user_level-error.html");
  }
}
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact " dir="ltr"
data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template">

<head>
  <meta charset="utf-8" />
  <meta name="viewport"
  content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Users</title>
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../assets/img/icon.png" />
  <!-- Fonts -->
  <link
  href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
  rel="stylesheet">
  <!-- Icons -->
  <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
  <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome.css" />
  <link rel="stylesheet" href="../assets/vendor/fonts/flag-icons.css" />
  <!-- Core CSS -->
  <link rel="stylesheet" href="../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../assets/css/demo.css" />
  <!-- Vendors CSS -->
  <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/typeahead-js/typeahead.css" />
  <!-- Include jQuery -->
  <script type="text/javascript" src="../assets/js/jquery.min.js"></script>

  <!-- Include DataTables CSS and JS -->
  <link rel="stylesheet" type="text/css" href="../assets/css/datatable.min.css">
  <script src="../assets/js/datatable.min.js"></script>
  <!-- Helpers -->
  <script src="../assets/vendor/js/helpers.js"></script>
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="../assets/js/config.js"></script>
  <script src="../login and register/register.js"></script>
  <script src="../assets/js/toastr.min.js"></script>
  <link rel="stylesheet" href="../assets/css/toastr.css"/>
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar  ">
    <div class="layout-container">
      <!-- Menu -->
      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo ">
          <a href="dashboard.php" class="app-brand-link">
            <span class="app-brand-logo demo">
              <img src="../assets/img/icon.png" alt="" width="50">
            </span>
            <span class="app-brand-text menu-text fw-bold ms-2">GSREO Document<br>Management System</span>
          </a>
          <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
          </a>
        </div>
        <div class="menu-inner-shadow"></div>
        <ul class="menu-inner py-1">
          <!-- Dashboard -->
          <li class="menu-item">
            <a href="dashboard.php" class="menu-link">
              <i class="menu-icon tf-icons bx bx-home-circle"></i>
              <div class="text-truncate" data-i18n="Dashboards">Dashboard</div>
            </a>
          </li>
          <!-- Account Management -->
          <li class="menu-item active open">
            <a href="#" class="menu-link">
              <i class="menu-icon tf-icons bx bx-user"></i>
              <div class="text-truncate" data-i18n="Users">Users</div>
            </a>
          </li>
          <!-- Request Docouments -->
          <li class="menu-item">
            <a href="request-document.php" class="menu-link">
              <i class="menu-icon tf-icons bx bx-file-find"></i>
              <div class="text-truncate" data-i18n="Requests">Requests</div>
            </a>
          </li>
          <!-- Documents -->
          <li class="menu-item">
            <a href="documents.php" class="menu-link">
              <i class="menu-icon tf-icons bx bx-file"></i>
              <div class="text-truncate" data-i18n="Documents">Documents</div>
            </a>
          </li>
          <!-- Archived Documents -->
          <li class="menu-item">
            <a href="archive.php" class="menu-link">
              <i class='menu-icon tf-icons bx bx-archive'></i>
              <div class="text-truncate" data-i18n="Archived Documents">Archived Documents</div>
            </a>
          </li>
        <li class="menu-item">
            <a href="forms.php" class="menu-link">
              <i class='menu-icon tf-icons bx bx-archive'></i>
              <div class="text-truncate" data-i18n="Forms">Forms</div>
            </a>
          </li>
        </ul>
      </aside>
      <!-- / Menu -->
      <!-- Layout container -->
      <div class="layout-page">
        <!-- Navbar -->
        <nav
        class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
        id="layout-navbar">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0   d-xl-none ">
          <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
          </a>
        </div>
        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
          <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Notification -->
            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1" onclick="notificationUpdate()">
              <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown"
              data-bs-auto-close="outside" aria-expanded="false">
              <i class="bx bx-bell bx-sm"></i>
              <span class="badge bg-danger rounded-pill badge-notifications" id="notification-count"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end py-0">
              <li class="dropdown-menu-header border-bottom">
                <div class="dropdown-header d-flex align-items-center py-3">
                  <h5 class="text-body mb-0 me-auto">Notification</h5>
                </div>
              </li>
              <li class="dropdown-notifications-list scrollable-container">
                <ul class="list-group list-group-flush" id="notification">

                </ul>
              </li>
            </ul>
          </li>
          <!--/ Notification -->
          <!-- User -->
          <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
              <div class="avatar avatar-online">
                <img src="../assets/img/profiles/<?php echo $_SESSION['picture']; ?>" alt class="w-px-40 h-auto rounded-circle">
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item">
                  <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                      <div class="avatar avatar-online">
                        <img src="../assets/img/profiles/<?php echo $_SESSION['picture']; ?>" alt class="w-px-40 h-auto rounded-circle">
                      </div>
                    </div>
                    <div class="flex-grow-1">
                      <span class="fw-medium d-block"><?php echo $_SESSION['name']; ?></span>
                      <small class="text-muted">Admin</small>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <div class="dropdown-divider"></div>
              </li>
              <li>
                <a class="dropdown-item text-muted" onclick="editUser(<?php echo $_SESSION['id'] ?>)" style="cursor: pointer;">
                  <i class="bx bx-user me-2"></i>
                  <span class="align-middle">My Profile</span>
                </a>
              </li>
              <div class="dropdown-divider"></div>
            </li>
            <li>
              <a class="dropdown-item" href="logout.php?logout=true">
                <i class="bx bx-power-off me-2"></i>
                <span class="align-middle">Log Out</span>
              </a>
            </li>
          </ul>
        </li>
        <!--/ User -->
      </ul>
    </div>
  </nav>
  <!-- / Navbar -->
  <!-- Content wrapper -->
  <div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
      <!-- DataTable with Buttons -->
      <div class="card px-4 py-4 table-responsive">
        <div class="mb-4 d-flex justify-content-end">
          <button class="btn w-10 btn-danger" tabindex="0" type="button" data-bs-toggle="modal"
          data-bs-target="#college-components">College Components
        </button>
      </div>
      <table id="users" class="table table-striped table-hover table-bordered">
        <thead>
          <tr>
            <th class="fw-bolder">ID</th>
            <th class="fw-bolder">Name</th>
            <th class="fw-bolder">Program/Designation</th>
            <th class="fw-bolder">Department</th>
            <th class="fw-bolder">Contact Number</th>
            <th class="fw-bolder">Email</th>
            <th class="fw-bolder">User Level</th>
            <th class="fw-bolder">Signature</th>

          </tr>
        </thead>
        <tbody>
          <!-- Your table data goes here -->
        </tbody>
      </table>
    </div>

    <!-- COLLEGE COMPONENTS MODAL START-->
    <div class="modal fade" id="college-components" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="staticBackdropLabel">College Components</h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body d-flex justify-content-evenly">
          <button class="btn" data-bs-target="#program" data-bs-toggle="modal" data-bs-dismiss="modal">Program</button>
          <button class="btn" data-bs-target="#designation" data-bs-toggle="modal" data-bs-dismiss="modal">Designation</button>
          <button class="btn" data-bs-target="#department" data-bs-toggle="modal" data-bs-dismiss="modal">Department</button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- COLLEGE COMPONENTS MODAL END -->

  <!-- PROGRAM MODAL START -->
  <div class="modal fade" id="program" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="staticBackdropLabel">Program</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="programForm" class="input-group mb-3">
          <input class="form-control" type="text" name="program" placeholder="Program">
          <button class="btn w-25" type="submit">Add</button>
        </form>
        <table id="programTable" class="table table-striped table-hover table-bordered">
          <thead>
            <tr>
              <th>Program Name</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <!-- Your table data goes here -->
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- PROGRAM MODAL END -->

<!-- DESIGNATION MODAL START -->
<div class="modal fade" id="designation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title" id="staticBackdropLabel">Designation</h3>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <form id="designationForm" class="input-group mb-3">
        <input class="form-control" type="text" name="designation" placeholder="Designation">
        <button class="btn w-25" type="submit">Add</button>
      </form>
      <table id="designationTable" class="table table-striped table-hover table-bordered">
        <thead>
          <tr>
            <th>Designation Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <!-- Your table data goes here -->
        </tbody>
      </table>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
  </div>
</div>
</div>
<!-- DESIGNATION MODAL END -->

<!-- DEPARTMENT MODAL START -->
<div class="modal fade" id="department" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title" id="staticBackdropLabel">Department</h3>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <form id="departmentForm" class="input-group mb-3">
        <input class="form-control" type="text" name="department" placeholder="Department">
        <button class="btn w-25" type="submit">Add</button>
      </form>
      <table id="departmentTable" class="table table-striped table-hover table-bordered">
        <thead>
          <tr>
            <th>Department Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <!-- Your table data goes here -->
        </tbody>
      </table>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
  </div>
</div>
</div>
<!-- DEPARTMENT MODAL END -->
<!--/ DataTable with Buttons -->

<!-- MY PROFILE MODAL START -->
<div class="modal fade" id="my-profile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title" id="staticBackdropLabel">My Profile</h3>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <form action="" method="POST" class="signin" enctype="multipart/form-data">
        <div class="first_form">
          <h4>Personal Information</h4>
          <div class="mb-4 row">

            <div class="col-lg-12 col-md-12 col-xs-12 mb-1">
              <input class="form-control capitalize" type="text" id="user_name" placeholder="Name"
              required>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4 col-md-4 col-xs-4 mb-1">
              <input class="form-control" type="number" id="user_enumber" placeholder="Employee Number"
              required>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-4 mb-1">
              <input class="form-control capitalize" type="text" id="user_designation" placeholder="Designation"
              required>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-4 mb-1">
              <input class="form-control capitalize" type="text" id="user_department" placeholder="Department"
              required>
            </div>
          </div>
        </div>
        <div class="row">
          <h4>Contact Information</h4>
          <div class="col-lg-6 col-md-6 col-xs-6 mb-1">
            <input class="form-control" type="email" id="user_email" placeholder="Email Address"
            required>
            <div style="color: red; font-size: 12px;" id="email_validation"></div>
          </div>
          <div class="col-lg-6 col-md-6 col-xs-6 mb-1">
            <div class="input-group flex-nowrap">
              <span class="input-group-text bg-secondary text-white">+63</span>
              <input type="tel" class="form-control" id="user_cnumber" placeholder="123 456 7890" maxlength="12">
            </div>
          </div>
        </div>
        <div class="second_form">
          <h4>Password</h4>
          <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 mb-1">
              <input class="form-control" type="password" id="user_passwordInput" placeholder="Password" required>
            </div>
          </div>
        </div>
        <div class="third_form">
          <h4>Profile Picture</h4>
          <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">
              <input class="form-control" type="file" id="user_profilepicture" accept="image/*" id="imageFile" required>
              <div id="img_validation" class="text-danger"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="editUserDetail()">Update</button>
        <input type="hidden" name="" id="hidden_userid">
      </div>
    </form>
  </div>
</div>
</div>
<!-- MY PROFILE MODAL END -->


<!-- Modal for viewing signature-->
<div class="modal fade" id="signatureModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View Signature</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img src="" id="signatureImage" alt="Signature" class="img-fluid">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal for viewing signature end-->





<!-- / Content -->
<div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
</div>
<!-- / Layout page -->
</div>
<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>
<!-- Drag Target Area To SlideIn Menu On Small Screens -->
<div class="drag-target"></div>
</div>
<!-- / Layout wrapper -->
<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="../assets/vendor/libs/popper/popper.js"></script>
<script src="../assets/vendor/js/bootstrap.js"></script>
<script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="../assets/vendor/libs/hammer/hammer.js"></script>
<script src="../assets/vendor/libs/i18n/i18n.js"></script>
<script src="../assets/vendor/libs/typeahead-js/typeahead.js"></script>
<script src="../assets/vendor/js/menu.js"></script>
<!-- endbuild -->
<!-- Main JS -->
<script src="../assets/js/main.js"></script>
<!-- Page JS -->
<script>
  // FORMAT CP NUMBER
  // Function to format the phone number as 3 digits space 3 digits space 4 digits
  function formatPhoneNumber() {
    // Get the input element
    const phoneNumberInput = document.getElementById('user_cnumber');

    // Remove non-numeric characters from the input value
    let phoneNumber = phoneNumberInput.value.replace(/\D/g, '');

    // Apply the desired format
    phoneNumber = phoneNumber.replace(/(\d{3})(\d{3})(\d{4})/, '$1 $2 $3');

    // Truncate to the maximum length
    phoneNumber = phoneNumber.substring(0, 12);

    // Update the input value with the formatted phone number
    phoneNumberInput.value = phoneNumber;
  }

  // Add an event listener to the input for real-time formatting
  document.getElementById('user_cnumber').addEventListener('input', formatPhoneNumber);

      // DISPLAY RECORDS
$(document).ready(function () {
    var modal = $('#signatureModal');
    var modalImage = $('#signatureImage');

    $('#users').DataTable({
        ajax: {
            url: 'get_data.php',
            dataSrc: 'data'
        },
        columns: [
            { data: 'user_id' },
            { data: 'name' },
            { data: 'designation' },
            { data: 'department' },
            { data: 'contactNumber' },
            { data: 'email' },
            { data: 'user_level' },
            {
                data: null,
                render: function (data, type, row) {
                    if (data.user_level !== 'Student') {
                        return '<button class="btn btn-primary btn-view-signature" data-signature="' + data.signature + '">View</button>';
                    } else {
                        return '';
                    }
                }
            }
        ],
        order: [[0, 'desc']],
        paging: true,
        searching: true,
        ordering: true,
        responsive: {
            details: true
        }
    });

    // Handle click event for View Signature button
    $('#users').on('click', '.btn-view-signature', function () {
        var signatureUrl = $(this).data('signature');
        modalImage.attr('src', signatureUrl);
        modal.modal('show');
    });
});




      // EDIT PROFILE START
  function editUser(id){
    $('#hidden_userid').val(id);

    $.post("my-profile.php",
      {id:id},
      function(data,status){
        var user = JSON.parse(data);
        $('#user_enumber').val(user.user_id);
        $('#user_name').val(user.name);
        $('#user_designation').val(user.designation);
        $('#user_department').val(user.department);
        $('#user_cnumber').val(user.contactNumber);
        $('#user_email').val(user.email);
        $('#user_passwordInput').val(user.password);
        $('#user_profilepicture').val(user.password);
      });
    $('#my-profile').modal("show");
  }

function editUserDetail() {
  var enumber = $('#user_enumber').val();
  var name = $('#user_name').val();
  var designation = $('#user_designation').val();
  var department = $('#user_department').val();
  var cnumber = $('#user_cnumber').val();
  var email = $('#user_email').val();
  var password = $('#user_passwordInput').val();
  var picture = $('#user_profilepicture')[0].files[0]; // Get the file object

  var hidden_userid = $('#hidden_userid').val();

  var formData = new FormData();
  formData.append('hidden_userid', hidden_userid);
  formData.append('enumber', enumber);
  formData.append('name', name);
  formData.append('designation', designation);
  formData.append('department', department);
  formData.append('cnumber', cnumber);
  formData.append('email', email);
  formData.append('password', password);
  formData.append('picture', picture);

  $.ajax({
    url: 'my-profile.php',
    type: 'POST',
    data: formData,
    processData: false, // Important: prevent jQuery from processing the data
    contentType: false, // Important: set contentType to false
    success: function(data) {
      $('#my-profile').modal("hide");
      console.log(data);
      toastr.success("User Updated!");
      setTimeout(function() {
        location.reload();
      }, 1000); 
    },
    error: function(xhr, status, error) {
      console.error('Error updating user:', error);
      toastr.error("Error updating user. Please try again.");
    }
  });
}

  // EDIT PROFILE END

      // NOTIFICATION START
  function notificationUpdate() {
    // Your AJAX code here
    var notification = 'notification';

    $.ajax({
      url: "notification.php",
      type: "POST",
      data: {
        notification: notification,
      },
      success: function(data, status) {
        console.log(data);
      }
    });
  }

  $(document).ready(function(){
   $.ajax({
            url: 'notification-count.php', // URL to your server-side script that generates the notification
            type: 'GET',
            success: function(response){
                // Display the notification to the user
              $("#notification-count").html(response);
              if (response === '0' || response.trim() === '') {
                $('#notification-count').css('display', 'none');
              } else {
                $('#notification-count').css('display', 'inline-block');
              }

            },
            error: function(xhr, status, error){
              console.error('Error:', error);
            }
          });

   $.ajax({
            url: 'notification.php', // URL to your server-side script that generates the notification
            type: 'GET',
            success: function(response){
                // Display the notification to the user
                $("#notification").html(response); // You can use any notification library or custom HTML/CSS here
              },
              error: function(xhr, status, error){
                console.error('Error:', error);
              }
            });
 });
// NOTIFICATION END

  // COLLEGE COMPONENTS TABLE START
  $(document).ready(function() {
    // Initialize DataTable for each table
    var program = $('#programTable').DataTable({
      columns: [
        { data: 'program' },
        {
          data: null,
          render: function(data, type, row) {
            return '<div class="d-flex justify-content-evenly"><button class="btn btn-danger btn-delete" data-id="' + data.id + '">Delete</button></div>';
          }
        }
        ],
      bAutoWidth: false, 
      aoColumns : [
        { sWidth: '70%' },
        { sWidth: '30%' }
        ]
    });

    var designation = $('#designationTable').DataTable({
      columns: [
        { data: 'designation' },
        {
          data: null,
          render: function(data, type, row) {
            return '<div class="d-flex justify-content-evenly"><button class="btn btn-danger btn-delete" data-id="' + data.id + '">Delete</button></div>';
          }
        }
        ],
      bAutoWidth: false, 
      aoColumns : [
        { sWidth: '70%' },
        { sWidth: '30%' }
        ]
    });

    var department = $('#departmentTable').DataTable({
      columns: [
        { data: 'department' },
        {
          data: null,
          render: function(data, type, row) {
            return '<div class="d-flex justify-content-evenly"><button class="btn btn-danger btn-delete" data-id="' + data.id + '">Delete</button></div>';
          }
        }
        ],
      bAutoWidth: false, 
      aoColumns : [
        { sWidth: '70%' },
        { sWidth: '30%' }
        ]
    });

    // Fetch data from PHP script using AJAX
    $.ajax({
      url: 'college-components.php',
      method: 'GET',
      dataType: 'json',
      success: function(data) {
            // Populate each table with the fetched data
        program.rows.add(data.program).draw();
        designation.rows.add(data.designation).draw();
        department.rows.add(data.department).draw();
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
      }
    });

    // Event listeners for update and delete buttons
    $('#programTable').on('click', '.btn-update', function() {
      var data = program.row($(this).closest('tr')).data();
        // Handle update action for table 1
    });

    $('#programTable').on('click', '.btn-delete', function() {
      var data = program.row($(this).closest('tr')).data();
        // Handle delete action for table 1
    });

    $('#designationTable').on('click', '.btn-update', function() {
      var data = designation.row($(this).closest('tr')).data();
        // Handle update action for table 2
    });

    $('#designationTable').on('click', '.btn-delete', function() {
      var data = designation.row($(this).closest('tr')).data();
        // Handle delete action for table 2
    });

    $('#departmentTable').on('click', '.btn-update', function() {
      var data = department.row($(this).closest('tr')).data();
        // Handle update action for table 3
    });

    $('#departmentTable').on('click', '.btn-delete', function() {
      var data = department.row($(this).closest('tr')).data();
        // Handle delete action for table 3
    });
  });
  // COLLEGE COMPONENTS TABLE END
  
  // INSERTING COLLEGE COMPONENT START
  $(document).ready(function() {
    $('form').submit(function(e) {
      e.preventDefault();
      var formData = $(this).serialize();
      submitFormData(formData);
    });

    function submitFormData(formData) {
      $.ajax({
        type: "POST",
        url: "insert-collegeComponents.php",
        data: formData,
        success: function(response) {
          if (response == 'error') {
            toastr.error("Program is already exist!");
          } else {
            toastr.success(response);
            $('#program').modal("hide");
            $('#department').modal("hide");
            $('#designation').modal("hide");
            setTimeout(function() {
              location.reload();
            }, 1000);
          }
        }
      });
    }
  });
  // INSERTING COLLEGE COMPONENT END

  // DELETING COLLEGE COMPONENT START
  $(document).ready(function() {
    // Event listener for delete buttons
    $('#programTable, #designationTable, #departmentTable').on('click', '.btn-delete', function() {
        var id = $(this).data('id'); // Get the ID from the data attribute
        
        // Confirm the deletion
        if (confirm("Are you sure you want to delete this record?")) {
            // AJAX call to delete the row
          $.ajax({
            type: "POST",
            url: "delete-collegeComponents.php",
                data: { id: id }, // Pass the ID to the PHP script
                success: function(response) {
                  if (response === 'success') {
                    toastr.success("Component deleted successfully!");
                    $('#program').modal("hide");
                    $('#department').modal("hide");
                    $('#designation').modal("hide");
                    setTimeout(function() {
                      location.reload();
                    }, 1000);
                  } else {
                    toastr.error("Failed to delete component!");
                  }
                },
                error: function(xhr, status, error) {
                  console.error(xhr.responseText);
                  toastr.error("An error occurred while deleting record!");
                }
              });
        }
      });
  });

  // DELETING COLLEGE COMPONENT END
</script>
</body>

</html>
<!-- beautify ignore:end -->