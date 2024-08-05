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
  <title>Documents</title>
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
          <li class="menu-item">
            <a href="dashboard.php" class="menu-link">
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
          <li class="menu-item  active open">
            <a href="#" class="menu-link">
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
                <a class="dropdown-item" href="pages-account-settings-account.html">
                  <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                      <div class="avatar avatar-online">
                        <img src="../assets/img/profiles/<?php echo $_SESSION['picture']; ?>" alt class="w-px-40 h-auto rounded-circle">
                      </div>
                    </div>
                    <div class="flex-grow-1">
                      <span class="fw-medium d-block">
                        <?php echo $_SESSION['name']; ?>
                      </span>
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
        <table id="documents" class="table table-hover table-bordered">
          <thead>
            <tr>
              <th class="fw-bolder">ID</th>
              <th class="fw-bolder">Owner</th>
              <th class="fw-bolder">Document Name</th>
              <th class="fw-bolder">Document Type</th>
              <th class="fw-bolder">Date Expiration</th>
              <th class="fw-bolder">Status</th>
              <th class="fw-bolder">Action</th>
            </tr>
          </thead>
          <tbody>
            <!-- Your table data goes here -->
          </tbody>
        </table>
      </div>

      <!-- Modal to add new record -->
      <div class="modal fade" id="add-user" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Add User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="" method="POST" class="signin">
              <div class="first_form">
                <h3>Personal Information</h3>
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
                    <input class="form-control capitalize" type="text" id="designation"
                    placeholder="Designation" required>
                  </div>
                  <div class="col-lg-4 col-md-4 col-xs-4 mb-1">
                    <input class="form-control capitalize" type="text" id="department" placeholder="Department"
                    required>
                  </div>
                </div>
              </div>
              <div class="row">
                <h3>Contact Information</h3>
                <div class="col-lg-6 col-md-6 col-xs-6 mb-1">
                  <input class="form-control" id="email" type="email" id="email" placeholder="Email Address"
                  required>
                  <div style="color: red; font-size: 12px;" id="email_validation"></div>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-6 mb-1">
                  <input class="form-control" type="number" id="cnumber" placeholder="Contact Number" required>
                </div>
              </div>
              <div class="second_form">
                <h3>Password</h3>
                <small class="form-text text-danger" id="passwordHelp">Password must be at least 8 characters
                long.</small>
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-xs-6 mb-1">
                    <input class="form-control" type="password" id="passwordInput" placeholder="Password"
                    required>
                  </div>
                  <div class="col-lg-6 col-md-6 col-xs-6 mb-1">
                    <input class="form-control" type="password" id="confirmPasswordInput"
                    placeholder="Confirm Password" required>
                    <div id="passwordMatchError" class="text-danger"></div>
                  </div>
                </div>
              </div>
              <div class="third_form">
                <h3>Profile Picture</h3>
                <div class="row">
                  <div class="col-lg-12 col-md-12 col-xs-12">
                    <input class="form-control" type="file" id="profilepicture" accept="image/*" id="imageFile"
                    required>
                    <div id="img_validation" class="text-danger"></div>
                  </div>
                </div>
                <h3>Signature</h3>
                <div class="row">
                  <div class="col-lg-12 col-md-12 col-xs-12">
                    <input class="form-control" type="file" id="signature" accept="image/*" id="imageFile"
                    required>
                    <div id="img_validation" class="text-danger"></div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="addUser()">Add</button>
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
          <form action="" method="POST" class="signin" enctype="multipart/form-data" >
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
                  <input class="form-control" type="file" id="user_profilepicture" name="picture" accept="image/jpeg" required>
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

  <!-- UPDATE EXPIRATION MODAL START -->
  <div class="modal fade" id="updateDateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Expiration Date</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input class="form-control" type="date" value="" id="expirationDateInput" name="">
          <input type="hidden" value="id" id="id" name="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="updateExpiration()">Update Date</button>
        </div>
      </div>
    </div>
  </div>
  <!-- UPDATE EXPIRATION MODAL END -->

  <!-- MODAL VIEW SIGNATORIES START -->
  <div class="modal fade" id="view" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content" id="view-signatories">

      </div>
    </div>
  </div>
  <!-- MODAL VIEW SIGNATORIES END -->

  <!-- SHOW CONVERSATION MODAL START -->
  <div class="modal fade" id="showConversation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" id="display-conversation">

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- SHOW CONVERSATION MODAL END -->

  <!-- OTP VERIFICATION MODAL START -->
  <div class="modal fade" id="verification" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Verification</h5>
        </div>
        <div class="modal-body">
          <input type="text" class="form-control" id="otpInput" placeholder="Enter OTP">
        </div>
        <div class="modal-footer">
          <button type="button" id="resendOTP" class="btn btn-primary">Resend OTP (60)</button>
          <button type="button" id="sendOTP" class="btn btn-primary">Verify</button>
        </div>
      </div>
    </div>
  </div>
  <!-- OTP VERIFICATION MODAL END -->

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
let selectedExpirationDate = ''; // Initialize selectedExpirationDate variable
let selectedDocumentId = ''; // Initialize selectedDocumentId variable

$('#documents').DataTable({
  ajax: {
    url: 'get_documents.php',
    dataSrc: 'data'
  },
  columns: [
    { data: 'document_id' },
    { data: 'owner_id' },
    { data: 'document' },
    { data: 'document_type' },
    {
      data: 'expiration',
      render: function(data, type, row) {
// Extract the date from the data
        var dateParts = data.split(' ')[0].split('-');
var expirationDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]); // Month is 0-indexed in JavaScript

// Format the date
var formattedDate = expirationDate.toLocaleDateString('en-US'); // Adjust the format as needed
// Construct the HTML for the button with the appropriate background color
return '<button class="w-100 expiration-button" style="background-color: transparent; outline: none; border: none; color: #fff;" data-bs-toggle="modal" data-bs-target="#updateDateModal" data-date="' + data + '" data-document_id="' + row.document_id + '">' + formattedDate + '</button>';
}
},
{ data: 'approval_status' },
{
  data: 'document_id',
  render: function (data, type, row) {
    return '<button class="w-100 btn btn-primary view-button mb-2" data-bs-toggle="modal" data-bs-target="#view" onclick="viewSignatories(' + data + ')">View</button>';
  }
}
],
order: [[0, 'desc']], // Sort the first column (document_id) in descending order by default
paging: true,
searching: true,
ordering: true,
responsive: {
  details: true
},
createdRow: function (row, data, dataIndex) {
  var approvalStatus = data.approval_status.toLowerCase();
  var expirationDate = new Date(data.expiration.split(' ')[0]);
  var today = new Date();
  var expirationBackgroundColor;
  var textColor = 'white';
  var backgroundColor;

  var options = { year: 'numeric', month: 'numeric', day: 'numeric' };
  var expirationDateString = expirationDate.toLocaleDateString('en-US', options);
  var todayDateString = today.toLocaleDateString('en-US', options);

// EXPIRATION DATE
  if (expirationDateString < todayDateString) {
    expirationBackgroundColor = '#FF5733'; // Pastel Red for expired
  } else if (expirationDateString > todayDateString) {
    expirationBackgroundColor = '#FFC107'; // Pastel Yellow for future dates
  } else {
    expirationBackgroundColor = '#4CAF50'; // Pastel Green for today's date
  }


// APPROVAL STATUS
  switch (approvalStatus) {
  case 'approved':
backgroundColor = '#4CAF50'; // Pastel Green
break;
case 'pending':
backgroundColor = '#FFC107'; // Pastel Yellow
break;
case 'rejected':
backgroundColor = '#FF5733'; // Pastel Red
break;
default:
backgroundColor = ''; // Set a default color or leave it empty
}

$(row).find('td:eq(4)').css({
  'background-color': expirationBackgroundColor
});

$(row).find('td:eq(5)').css({
  'color': textColor,
  'background-color': backgroundColor
});
}
});
// Handle click event on expiration button
$('#documents').on('click', '.expiration-button', function () {
selectedExpirationDate = $(this).data('date'); // Store the selected expiration date
selectedDocumentId = $(this).data('document_id'); // Get the document ID from the data attribute
$('#expirationDateInput').val(selectedExpirationDate); // Set the expiration date input value
$('#id').val(selectedDocumentId); // Set the document ID value
});

// Update expiration date in the modal when it is shown
$('#updateDateModal').on('shown.bs.modal', function () {
$('#expirationDateInput').val(selectedExpirationDate); // Set the expiration date input value
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
        $('#user_profilepicture').val(user.picture);
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

// DISABLE PREVIOUS DATES START
  $(function(){
    var dtToday = new Date();

    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();
    if(month < 10)
      month = '0' + month.toString();
    if(day < 10)
      day = '0' + day.toString();
    var maxDate = year + '-' + month + '-' + day;
    $('#expirationDateInput').attr('min', maxDate);
  });
// DISABLE PREVIOUS DATES END

// UPDATE EXPIRATION DATE START
  function updateExpiration() {
    var date = $('#expirationDateInput').val();
    var id = $('#id').val();
    var updateExpiration = 'updateExpiration';

    $.ajax({
      url: 'updateExpiration.php',
      type: 'POST',
      data: {updateExpiration:updateExpiration, date:date, id:id},
      success: function(data, status){
        if(data == '1'){
          toastr.success("Expiration date extended!");
          $('#updateDateModal').modal("hide");

// Split the date string into parts
          var dateParts = date.split('-');
var formattedDate = dateParts[1] + '/' + dateParts[2] + '/' + dateParts[0]; // Format as MM/DD/YYYY

// Update the text content of the expiration button
$('.expiration-button[data-document_id="' + id + '"]').text(formattedDate);
}
}
});
  }

// UPDATE EXPIRATION DATE END

  // VIEW SIGNATORIES MODAL
  function viewSignatories(document_id){
    console.log(document_id);
    $.ajax({
      url: "get_signatories.php",
      type: "POST",
      data: {
        document_id: document_id,
      },
      success: function (data, status) {
        $('#view-signatories').html(data);
      }
    });
  }

// HANDLE FILE UPLOAD FOR CONVERSATION
  var otp = '';

  function handleFileInput(documentId, userId, signatoryId, status) {
    event.preventDefault();
    var fileInput = document.getElementById('fileInput');
    var resendOTP = document.getElementById('resendOTP');

    fileInput.click();
    console.log(status);

    // Function to send OTP via AJAX
    function sendOTP() {
        var phoneNumber = '<?php echo $_SESSION['contactNumber'];?>';
        $.ajax({
            url: "../config/sendOTP.php",
            type: "POST",
            data: {
                phoneNumber: phoneNumber
            },
            success: function (data) {
                otp = data;
                // Disable the button
                $('#resendOTP').prop('disabled', true);

                // Start the timer for 60 seconds
                var secondsLeft = 60;
                var timerInterval = setInterval(function() {
                    $('#resendOTP').text("Resend OTP ("+ secondsLeft +")");
                    secondsLeft--;

                    if (secondsLeft < 0) {
                        // Enable the button after 60 seconds
                        $('#resendOTP').prop('disabled', false);
                        $('#resendOTP').text('Resend OTP');

                        // Clear the timer interval
                        clearInterval(timerInterval);
                    }
                }, 1000);
                $('#verification').modal({
                    backdrop: 'static',
                    keyboard: false // Prevent closing the modal with the keyboard Esc key
                });
                $('#verification').modal('show');

                $('#sendOTP').click(function() {
                    var enteredOTP = $('#otpInput').val();
                    if (otp == enteredOTP) {
                        // OTP verification successful, proceed with file upload
                        var file = document.getElementById('fileInput').files[0];
                        handleFileUpload(file, documentId, userId, signatoryId, status);
                    } else {
                        // Display error message or handle invalid OTP
                        toastr.error('Invalid OTP');
                    }
                });
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error('Verification failed:', error);
                toastr.error("OTP verification error");
            }
        });
    }

    // Add event listener for file input change
    fileInput.addEventListener('change', function(event) {
        // Trigger OTP sending when file input changes
        sendOTP();
    });

    // Add event listener for resend OTP button click
    resendOTP.addEventListener('click', function(event){
        // Resend OTP by calling the sendOTP function
        sendOTP();
    });
}

  function handleFileUpload(file, documentId, userId, signatoryId, status) {
    var formData = new FormData();
    formData.append('file', file);
    formData.append('documentId', documentId);
    formData.append('userId', userId);
    formData.append('signatoryId', signatoryId);
    formData.append('status', status);

    console.log(status);

    $.ajax({
      url: 'uploadConversation.php',
      type: 'POST',
      data: formData,
        processData: false, // Prevent jQuery from processing data
        contentType: false, // Prevent jQuery from setting contentType
        success: function(data, status) {
          if(data == '1'){
                // Handle successful response
            toastr.success("Form approved!");
            $('#view').modal('hide');
            $('#verification').modal('hide');
            setTimeout(function() {
              window.location.reload();
            }, 1500);
          } else {
            toastr.error("Form rejected!");
            $('#view').modal('hide');
            setTimeout(function() {
              window.location.reload();
            }, 1500);
          }
        },
        error: function(xhr, status, error) {
            // Handle error
          console.error('File upload failed:', error);
          toastr.error("File upload error");
        }
      });
  }


// Function to log FormData
  function logFormData(formData) {
    console.log('FormData:');
    for (const [key, value] of formData.entries()) {
      console.log(key + ':', value);
    }
  }

// SHOW CONVERSATION MODAL START
  function showConversation(document_id, signatory_id){
    console.log(document_id);
    $.ajax({
      url: "get_conversation.php",
      type: "POST",
      data: {
        document_id: document_id,
        signatory_id: signatory_id
      },
      success: function (data, status) {
        $('#display-conversation').html(data);
      }
    });
  }
// SHOW CONVERSATION MODAL END

</script>
</body>

</html>
<!-- beautify ignore:end -->