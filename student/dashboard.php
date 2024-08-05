<?php
require("../config/db_connection.php");

session_start();
require ("../config/session_timeout.php");

if(!isset($_SESSION['id'])){
  header("location: ../config/not_login-error.html");
}
else{
  if($_SESSION['user_level'] == "Faculty"){
    header("location: ../config/user_level-error.html");
  }
  if($_SESSION['user_level'] == "Admin"){
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
  <title>Student Dashboard</title>
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
          <!-- Documents -->
          <li class="menu-item">
            <a href="documents.php" class="menu-link">
              <i class="menu-icon tf-icons bx bx-file-blank"></i>
              <div class="text-truncate" data-i18n="Documents">Documents</div>
            </a>
          </li>
          <!-- View Uploaded Thesis -->
          <li class="menu-item">
            <a href="view_thesis.php" class="menu-link">
              <i class="menu-icon tf-icons bx bx-book"></i>
              <div class="text-truncate" data-i18n="View Uploaded Thesis">View Uploaded Thesis</div>
            </a>
          </li>
          <!-- Download Forms-->
          <li class="menu-item">
            <a href="view_forms.php" class="menu-link">
              <i class="menu-icon tf-icons bx bx-download"></i>
              <div class="text-truncate" data-i18n="Download Forms">Download Forms</div>
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
                      <span class="fw-medium d-block"><?php echo $_SESSION['name']; ?></span>
                      <small class="text-muted">Student</small>
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
                  <h5 class="mb-4"><i class='bx bx-male'></i> <?php echo $_SESSION['program']; ?></h5>
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
          <h5 class="text-dark">Recently Uploaded Documents</h5>
          <div>
            <button class="btn w-10 btn-danger me-2" tabindex="0" type="button" data-bs-toggle="modal" data-bs-target="#add-document">
              <span><i class="bx bx-plus me-sm-1"></i><span class="d-none d-sm-inline-block">Upload Document</span></span>
            </button>
            <button class="btn w-10 btn-primary" tabindex="0" type="button" data-bs-toggle="modal" data-bs-target="#add-thesis">
              <span><i class="bx bx-plus me-sm-1"></i><span class="d-none d-sm-inline-block">Upload Thesis</span></span>
            </button>
          </div>
        </div>
        <table id="example" class="table table-hover table-bordered">
          <thead>
            <tr>
              <th class="fw-bolder">ID</th>
              <th class="fw-bolder">Document Name</th>
              <th class="fw-bolder">Document Type</th>
              <th class="fw-bolder">Uploaded At</th>
              <th class="fw-bolder">Action</th>
            </tr>
          </thead>
          <tbody>
            <!-- Your table data goes here -->
          </tbody>
        </table>
      </div>
      
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

<!-- MODAL UPLOAD DOCUMENT START -->
<form id="upload" method='POST' action='upload.php' enctype="multipart/form-data">
  <div class="modal fade" id="add-document" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Upload Document</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <input type="file" class="form-control" name="attachment"  accept="image/*, application/pdf" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="submit">Upload</button>
        
      </div>
    </div>

  </div>
</div>
</form>
<!-- MODAL UPLOAD DOCUMENT END -->

<!-- MODAL UPLOAD THESIS START -->
<form id="upload-thesis-form" method='POST' action='upload_thesis.php' enctype="multipart/form-data">
  <div class="modal fade" id="add-thesis" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Upload Thesis</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="thesis-file" class="form-label">Choose PDF File</label>
            <input type="file" class="form-control" id="thesis-file" name="thesis-file" accept="application/pdf" required>
          </div>
          <div class="mb-3">
            <label for="thesis-comments" class="form-label">Comments</label>
            <textarea class="form-control" id="thesis-comments" name="thesis-comments" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="submit">Upload</button>
        </div>
      </div>
    </div>
  </div>
</form>
<!-- MODAL UPLOAD THESIS END -->


<!-- MODAL VIEW DOCUMENT START -->
<div class="modal fade" id="view" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="display-document">
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- MODAL VIEW DOCUMENT END -->

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
              <input class="form-control capitalize" type="text" id="user_program" placeholder="Designation"
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
  $(document).ready(function () {
    $('#example').DataTable({
      ajax: {
        url: 'get_data.php',
        dataSrc: 'data'
      },
      columns: [
        { data: 'id' },
        { data: 'document' },
        { data: 'document_type' },
        {
          data: 'uploaded_at',
          render: function (data, type, row) {
            var date = new Date(data);
            return date.toLocaleDateString('en-US');
          }
        },
        {
        data: 'document_id', // Use 'document_id' as data property
        render: function (data, type, row) {
          return '<button class="w-100 btn btn-primary view-button" data-bs-toggle="modal" data-bs-target="#view" onclick="viewDocument(' + data + ')">View</button>';
        }
      }
      ],
      order: [[0, 'desc']],
      paging: true,
      searching: true,
      ordering: true,
      responsive: {
        details: true
      },
    });
  });

  function viewDocument(document_id) {
    console.log(document_id);
    $.ajax({
      url: "get_document.php",
      type: "POST",
      data: {
        document_id: document_id,
      },
      success: function (data, status) {
        $('#display-document').html(data);
      }
    });
  }

    // EDIT PROFILE START
  function editUser(id){
    $('#hidden_userid').val(id);

    $.post("my-profile.php",
      {id:id},
      function(data,status){
        var user = JSON.parse(data);
        $('#user_enumber').val(user.user_id);
        $('#user_name').val(user.name);
        $('#user_program').val(user.program);
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
</script>
</body>

</html>
<!-- beautify ignore:end -->