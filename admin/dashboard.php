<?php
require ("../config/db_connection.php");
require("../config/archive-script.php");

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
  <title>Admin Dashboard</title>
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
  <script src="assets/js/register.js"></script>
  <script src="../assets/js/toastr.min.js"></script>
  <link rel="stylesheet" href="../assets/css/toastr.css"/>
  <script type="text/javascript" src="../config/toastr_config.js"></script>
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar  ">
    <div class="layout-container">
      <!-- Menu -->
      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo ">
          <a href="dashboard.html" class="app-brand-link">
            <span class="app-brand-logo demo">
              <img src="../assets/img/logo.png" alt="" width="50">
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
          <li class="menu-item active open">
            <a href="#" class="menu-link">
              <i class="menu-icon tf-icons bx bx-home-circle"></i>
              <div class="text-truncate" data-i18n="Dashboards">Dashboard</div>
            </a>
          </li>
          <!-- Account Management -->
          <li class="menu-item">
            <a href="users.php" class="menu-link">
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
          <!-- Forms -->
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
              <a class="dropdown-item" href="../logout.php?logout=true">
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
      <div class="row">
        <div class="col-lg-12 mb-4 order-0">
          <div class="card">
            <div class="d-flex align-items-end row">
              <div class="col-sm-3">
                <div class="card-body text-center" style="padding: 15px;">
                  <div>
                    <img src="../assets/img/profiles/<?php echo $_SESSION['picture']; ?>" width="200" style="border-radius: 10px;">
                  </div>
                </div>
              </div>
              <div class="col-sm-5">
                <div class="card-body" style="padding: 15px;">
                  <h2 class="card-title text-dark" style="width: 100%;"><?php echo $_SESSION['name']; ?></h2>
                  <h5 class="mb-2"><i class='bx bx-id-card'></i> <?php echo $_SESSION['id']; ?></h5>
                  <h5 class="mb-2"><i class='bx bx-buildings' ></i> <?php echo $_SESSION['department']; ?></h5>
                  <h5 class="mb-4"><i class='bx bx-male'></i> <?php echo $_SESSION["designation"]; ?></h5>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="card-body" style="padding: 0 15px 0 15px;height: 115px;">
                  <h5 class="mb-2"><i class='bx bx-envelope' ></i> <?php echo $_SESSION['email']; ?></h5>
                  <h5 class="mb-2"><i class='bx bxs-phone' ></i> <?php echo '+63 '.$_SESSION['contactNumber']; ?></h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


      <!-- DataTable with Buttons -->
      <div class="card px-4 py-4 table-responsive">
        <div class="mb-4 d-flex justify-content-between">
          <h5 class="text-dark">Recently Added Users</h5>
          <button class="btn w-10 btn-danger" tabindex="0" type="button" data-bs-toggle="modal"
          data-bs-target="#add-user">
          <span><i class="bx bx-plus me-sm-1"></i>
            <span class="d-none d-sm-inline-block">Add New User</span>
          </span>
        </button>
      </div>
      <table id="example" class="table table-striped table-hover table-bordered">
        <thead>
          <tr>
            <th class="fw-bolder">ID</th>
            <th class="fw-bolder">Name</th>
            <th class="fw-bolder">Program/Designation</th>
            <th class="fw-bolder">Department</th>
            <th class="fw-bolder">Contact Number</th>
            <th class="fw-bolder">Email</th>
            <th class="fw-bolder">User Level</th>
          </tr>
        </thead>
        <tbody>
          <!-- Your table data goes here -->
        </tbody>
      </table>
    </div>

    <!-- Modal to add new record -->
    <!-- Vertically centered modal -->
    <div class="modal fade" id="add-user" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="staticBackdropLabel">Add User</h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="POST" class="signin">
            <div class="first_form">
              <h4>Personal Information</h4>
              <div class="mb-4 row">
                <div class="col-lg-4 col-md-4 col-xs-4 mb-1">
                  <input class="form-control capitalize" type="text" id="fname" placeholder="First Name"
                  required>
                </div>
                <div class="col-lg-4 col-md-4 col-xs-4 mb-1">
                  <input class="form-control .add-period" type="text" id="mname" maxlength="1"
                  oninput="this.value = this.value.toUpperCase();" placeholder="Middle Initial" required>
                </div>
                <div class="col-lg-4 col-md-4 col-xs-4 mb-1">
                  <input class="form-control capitalize" type="text" id="lname" placeholder="Last Name"
                  required>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-4 col-md-4 col-xs-4 mb-1">
                  <input class="form-control" type="number" id="enumber" placeholder="Employee Number"
                  required>
                </div>
                <div class="col-lg-4 col-md-4 col-xs-4 mb-1">
                  <select class="form-control text-secondary" id="designation" required>
                    <option selected>Designation</option>
                  </select>
                </div>
                <div class="col-lg-4 col-md-4 col-xs-4 mb-1">
                  <select class="form-control text-secondary" id="department" required>
                    <option selected>Department</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <h4>Contact Information</h4>
              <div class="col-lg-6 col-md-6 col-xs-6 mb-1">
                <input class="form-control" type="email" id="email" placeholder="Email Address"
                required>
                <div style="color: red; font-size: 12px;" id="email_validation"></div>
              </div>
              <div class="col-lg-6 col-md-6 col-xs-6 mb-1">
                <div class="input-group flex-nowrap">
                  <span class="input-group-text" style="color: #212529; background-color: #e9ecef; border: 1px solid #ced4da;">+63</span>
                  <input type="tel" class="form-control" id="cnumber" placeholder="123 456 7890" maxlength="12">
                </div>
              </div>
            </div>
            <div class="second_form">
              <h4>Password</h4>
              <small class="form-text text-danger" id="passwordHelp">Password must be at least 8 characters long.</small>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-xs-6 mb-1">
                  <input class="form-control" type="password" id="passwordInput" placeholder="Password" required>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-6 mb-1">
                  <input class="form-control" type="password" id="confirmPasswordInput" placeholder="Confirm Password" required>
                  <div id="passwordMatchError" class="text-danger"></div>
                </div>
              </div>
            </div>
            <div class="third_form">
              <h4>Profile Picture</h4>
              <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12">
                  <input class="form-control" type="file" id="profilepicture" accept="image/*" id="imageFile" required>
                  <div id="img_validation" class="text-danger"></div>
                </div>
              </div>
              <h4>Signature</h4>
              <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12">
                  <input class="form-control" type="file" id="signature" accept="image/png" id="imageFile" required>
                  <div id="img_validation" class="text-danger"></div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary"onclick="addUser()">Add</button>
        </div>
      </div>
    </div>
  </div>
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
        <form action="" method="POST" class="signin" enctyp="multipart/form-data">
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
                <select class="form-control text-secondary" id="user_designation" required>
                  <option selected>Designation</option>
                </select>
              </div>
              <div class="col-lg-4 col-md-4 col-xs-4 mb-1">
                <select class="form-control text-secondary" id="user_department" required>
                  <option selected>Department</option>
                </select>
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
<script src="../assets/bootstrap/js/popper.min.js"></script>
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
  // POPULATE COLLEGE COMPONENTS DROPDOWN START
    $(document).ready(function() {
    // Function to populate select element with options
        function populateSelect(selectElement, data) {
        selectElement.empty(); // Clear existing options

        // Add default option for Program dropdown
        if (selectElement.attr('id') === 'designation') {
            selectElement.append($("<option></option>").text('Select Program'));
        }

        // Add default option for Department dropdown
        if (selectElement.attr('id') === 'department') {
            selectElement.append($("<option></option>").text('Select Department'));
        }

        $.each(data, function(key, value) {
            selectElement.append($("<option></option>").text(value).attr("value", value));
        });
    }

    // AJAX request to fetch programs
    $.ajax({
        url: '../config/fetch-collegeComponents.php',
        type: 'GET',
        dataType: 'json',
        data: { action: 'fetch_programs' },
        success: function(response) {
            populateSelect($('#designation'), response);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching programs:', error);
        }
    });

    // AJAX request to fetch departments
    $.ajax({
        url: '../config/fetch-collegeComponents.php',
        type: 'GET',
        dataType: 'json',
        data: { action: 'fetch_departments' },
        success: function(response) {
            populateSelect($('#department'), response);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching departments:', error);
        }
    });
});
// FORMAT CP NUMBER
  // Function to format the phone number as 3 digits space 3 digits space 4 digits
  function formatPhoneNumber() {
    // Get the input element
    const phoneNumberInput = document.getElementById('cnumber');

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
  document.getElementById('cnumber').addEventListener('input', formatPhoneNumber);

  // Function to format the phone number as 3 digits space 3 digits space 4 digits
  function newformatPhoneNumber() {
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
  document.getElementById('user_cnumber').addEventListener('input', newformatPhoneNumber);

      // DISPLAY RECORDS
  $(document).ready(function () {
    $('#example').DataTable({
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
        { data: 'user_level' }
        ],
      order: [[0, 'desc']],
      paging: true,
      searching: true,
      ordering: true,
      responsive: {
        details: true
      }
    });
  });

      // POPULATE COLLEGE COMPONENTS DROPDOWN START
  $(document).ready(function() {
    // Function to populate select element with options
    function populateSelect(selectElement, data) {
        selectElement.empty(); // Clear existing options

        // Add default option for Program dropdown
        if (selectElement.attr('id') === 'designation') {
          selectElement.append($("<option></option>").text('Select Designation'));
        }

        // Add default option for Department dropdown
        if (selectElement.attr('id') === 'department') {
          selectElement.append($("<option></option>").text('Select Department'));
        }

        $.each(data, function(key, value) {
          selectElement.append($("<option></option>").text(value).attr("value", value));
        });
      }

    // AJAX request to fetch programs
      $.ajax({
        url: '../config/fetch-collegeComponents.php',
        type: 'GET',
        dataType: 'json',
        data: { action: 'fetch_designations' },
        success: function(response) {
          populateSelect($('#designation'), response);
        },
        error: function(xhr, status, error) {
          console.error('Error fetching programs:', error);
        }
      });

    // AJAX request to fetch departments
      $.ajax({
        url: '../config/fetch-collegeComponents.php',
        type: 'GET',
        dataType: 'json',
        data: { action: 'fetch_departments' },
        success: function(response) {
          populateSelect($('#department'), response);
        },
        error: function(xhr, status, error) {
          console.error('Error fetching departments:', error);
        }
      });

      $.ajax({
        url: '../config/fetch-collegeComponents.php',
        type: 'GET',
        dataType: 'json',
        data: { action: 'fetch_designations' },
        success: function(response) {
          populateSelect($('#user_designation'), response);
        },
        error: function(xhr, status, error) {
          console.error('Error fetching programs:', error);
        }
      });

    // AJAX request to fetch departments
      $.ajax({
        url: '../config/fetch-collegeComponents.php',
        type: 'GET',
        dataType: 'json',
        data: { action: 'fetch_departments' },
        success: function(response) {
          populateSelect($('#user_department'), response);
        },
        error: function(xhr, status, error) {
          console.error('Error fetching departments:', error);
        }
      });
    });
// POPULATE COLLEGE COMPONENTS DROPDOWN END

      // ADD USER START
  function addUser() {
    var formData = new FormData();
    formData.append('fname', $('#fname').val());
    formData.append('mname', $('#mname').val());
    formData.append('lname', $('#lname').val());
    formData.append('enumber', $('#enumber').val());
    formData.append('designation', $('#designation').val());
    formData.append('department', $('#department').val());
    formData.append('email', $('#email').val());
    formData.append('cnumber', $('#cnumber').val());
    formData.append('password', $('#passwordInput').val());
    formData.append('cpassword', $('#confirmPasswordInput').val());
    formData.append('profilepicture', $('#profilepicture')[0].files[0]);
  formData.append('signature', $('#signature')[0].files[0]); // Ensure the correct id 'signature' is used here

  if (formData.get('fname') !== "" && formData.get('mname') !== "" && formData.get('lname') !== "" && formData.get('enumber') !== "" && formData.get('designation') !== "" && formData.get('department') !== "" && formData.get('email') !== "" && formData.get('cnumber') !== "" && formData.get('password') !== "" && formData.get('cpassword') !== "" && formData.get('profilepicture') && formData.get('signature')) {
    $.ajax({
      url: "addUser.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (data, status) {
        if (data == 1) {
          toastr.success("User Added!");
          $("#add-user").modal('hide');
          $('#add-user input').val("");
          var table = $('#userRecords').DataTable();
          table.clear().draw();
          table.ajax.reload();
        } else {
          // Handle other cases
          toastr.error("Failed to add user!");
        }
      },
      error: function(xhr, status, error) {
        toastr.error("Error occurred while adding user!");
      }
    });
  } else {
    toastr.error("Please fill all the fields!");
  }
}


      // ADD USER END
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
</script>
</body>

</html>
<!-- beautify ignore:end -->