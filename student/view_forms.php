<?php
require("../config/db_connection.php");
session_start();

// Check if the session variable is set before using it
if(isset($_SESSION['name'])) {
    // Fetch the logged-in user's name from the session
    $uploader_name = $_SESSION['name'];
    
    // Fetch forms from the database for the logged-in user
    $sql = "SELECT * from forms";
    $result = mysqli_query($conn, $sql);

    // Start HTML content
    ?>
    <!DOCTYPE html>
    <html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact " dir="ltr"
      data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <title>View Uploaded Forms</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/icon.png"/>
    <!-- Add your CSS links and other necessary includes here -->
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css"/>
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome.css"/>
    <link rel="stylesheet" href="../assets/vendor/fonts/flag-icons.css"/>
    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/rtl/core.css" class="template-customizer-core-css"/>
    <link rel="stylesheet" href="../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css"/>
    <link rel="stylesheet" href="../assets/css/demo.css"/>
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css"/>
    <link rel="stylesheet" href="../assets/vendor/libs/typeahead-js/typeahead.css"/>
    <!-- Include DataTables CSS and JS -->
    <link rel="stylesheet" type="text/css" href="../assets/css/datatable.min.css">
    <script src="../assets/js/datatable.min.js"></script>
    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>
    <!-- Config -->
    <script src="../assets/js/config.js"></script>
    <script src="../assets/js/toastr.min.js"></script>
    <link rel="stylesheet" href="../assets/css/toastr.css"/>
    </head>
    <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar  ">
        <!-- Layout container -->
        <div class="layout-container">
             <!-- Menu -->
             <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo ">
                    <a href="dashboard.php" class="app-brand-link">
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
                <!-- Download Forms-->
                <li class="menu-item">
                  <a href="view_forms.php" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-download"></i>
                    <div class="text-truncate" data-i18n="Download Forms">Download Forms</div>
                  </a>
                </li>

                </ul>
            </aside>
            <!-- Layout page -->
            <div class="layout-page">
                <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h1>View Uploaded Forms</h1>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="fw-bolder">ID</th>
                                <th class="fw-bolder">Form Name</th>
                                <th class="fw-bolder">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Loop through each row of the result set
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['form_name'] . "</td>";
                                echo "<td><button class='btn btn-primary'><a href='/wdfuip/admin/forms/" . $row['form_name'] . "' target='_blank'>View and Download</a></button></td>";

                            }

                            // Check if no forms are found
                            if(mysqli_num_rows($result) == 0) {
                                echo "<tr><td colspan='2'>No forms found for the current user.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- / Content -->
                <div class="content-backdrop fade"></div>
            </div>
            <!-- / Layout page -->
        </div>
        <!-- / Layout container -->
    </div>
    <!-- / Layout wrapper -->
    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>


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
    <!-- Core JS code remains unchanged -->
    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>
    </body>
    </html>

    <?php
} else {
    // If the user ID is not found in the session
    echo "User ID not found in session.";
}

// Close database connection
mysqli_close($conn);
?>
