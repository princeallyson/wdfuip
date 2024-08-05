<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/img/icon.png" />
    <!-- LOCAL STYLES -->
    <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/toastr.css">
    <link rel="stylesheet" href="assets/css/register.css">
    <!-- LOCAL SCRIPTS -->
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/toastr.min.js"></script>
    <script type="text/javascript" src="config/toastr_config.js"></script>
    <title>Sign Up</title>
</head>

<body>
    <main>
        <div class="container d-flex justify-content-center align-items-center">
            <div class="formBox  d-flex justify-content-center align-items-center flex-column">
                <img class="mt-4" src="assets/img/logo.png" alt="">
                <form class="mt-4 signin" id="registrationForm">
                    <div class="first_form">
                        <h3>Personal Information</h3>
                        <div class="mb-2 row">
                            <div class="col-lg-4 col-md-4 col-xs-4 mb-1">
                                <input class="form-control capitalize" type="text" id="fname" placeholder="First Name" required>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-4 mb-1">
                                <input class="form-control add-period" type="text" id="mname" maxlength="1" oninput="this.value = this.value.toUpperCase();" placeholder="Middle Initial" required>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-4 mb-1">
                                <input class="form-control capitalize" type="text" id="lname" placeholder="Last Name" required>
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <div class="col-lg-4 col-md-4 col-xs-4 mb-1">
                                <input class="form-control" type="number" id="snumber" placeholder="Student Number" required>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-4 mb-1">
                                <input class="form-control" id="email" type="email" placeholder="Email Address" required>
                                <div style="color: red; font-size: 12px;" id="email_validation"></div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-4 mb-1">
                                <div class="input-group flex-nowrap">
                                  <span class="input-group-text">+63</span>
                                  <input type="tel" class="form-control" id="cnumber" placeholder="123 456 7890" maxlength="10">
                              </div>
                          </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6 col-md-6 col-xs-6 mb-1">
                            <select class="form-control text-secondary" id="program" required>
                                <option selected>Program</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 col-xs-6 mb-1">
                            <select class="form-control text-secondary" id="department" required>
                                <option selected>Department</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="second_form">
                    <h3>Password</h3>
                    <small class="form-text text-danger" id="passwordHelp">Password must be at least 8 characters
                    long.</small>
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
                    <h3>Profile Picture</h3>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12">
                            <input class="form-control" type="file" accept="image/*" id="imageFile" required>
                            <div id="img_validation" class="text-danger"></div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 mt-4">
                    <p>Already have an account? <a href="index.php"> Sign in.</a></p>
                    <button type="submit" class="btn mb-4 next-step">Sign up</button>
                </div>
            </form>
        </div>

        <!-- OTP VERIFICATION MODAL START -->
        <div class="modal fade" id="verification" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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


</main>

<script>
// POPULATE COLLEGE COMPONENTS DROPDOWN START
    $(document).ready(function() {
    // Function to populate select element with options
        function populateSelect(selectElement, data) {
        selectElement.empty(); // Clear existing options

        // Add default option for Program dropdown
        if (selectElement.attr('id') === 'program') {
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
        url: 'config/fetch-collegeComponents.php',
        type: 'GET',
        dataType: 'json',
        data: { action: 'fetch_programs' },
        success: function(response) {
            populateSelect($('#program'), response);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching programs:', error);
        }
    });

    // AJAX request to fetch departments
    $.ajax({
        url: 'config/fetch-collegeComponents.php',
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
// POPULATE COLLEGE COMPONENTS DROPDOWN END
$(document).ready(function(){
    var otp = ''; // Variable to store OTP

    $(".next-step").click(function(event){

        event.preventDefault();

        // Get all form field values
        var fname = $('#fname').val();
        var mname = $('#mname').val();
        var lname = $('#lname').val();
        var snumber = $('#snumber').val();
        var email = $('#email').val();
        var cnumber = $('#cnumber').val();
        var program = $('#program').val();
        var department = $('#department').val();
        var passwordInput = $('#passwordInput').val();
        var confirmPasswordInput = $('#confirmPasswordInput').val();
        var imageFile = $('#imageFile')[0].files[0]; // Get the file object

        // Check if the user already exists
        $.ajax({
            url: 'checkUser.php', // PHP file to check if the user exists
            type: 'POST',
            data: {
                snumber: snumber
            },
            success: function(response) {
                if (response === 'exists') {
                    // User already exists, show an error message or take appropriate action
                    toastr.error("Student number already exists!");
                } else {
                    $.ajax({
                        url: "config/sendOTP.php",
                        type: "POST",
                        data: {
                            phoneNumber: cnumber
                        },
                        success: function (data) {
                            otp = data;
                            showVerificationModal();
                        },
                        error: function(xhr, status, error) {
                            console.error('Error sending OTP:', error);
                            toastr.error("Error sending OTP. Please try again.");
                        }
                    });
                    console.log(response);
                    // User does not exist, show the verification modal
                }
            },
            error: function(xhr, status, error) {
                console.error('Error checking user:', error);
            }
        }); // <-- Closing parenthesis for $.ajax() in $(".next-step").click()

        // Function to show the verification modal
        function showVerificationModal() {
            disableResendOTP();
            // Show the verification modal with backdrop static and keyboard disabled
            $('#verification').modal({
                backdrop: 'static',
                keyboard: false // Prevent closing the modal with the keyboard Esc key
            }).modal('show');

            // Bind the click event for #sendOTP button
            $('#sendOTP').off('click').on('click', function() {
                var enteredOTP = $('#otpInput').val();
                if (otp == enteredOTP) {
                    // Proceed with form submission if OTP is verified
                    var formData = new FormData();
                    formData.append('fname', fname);
                    formData.append('mname', mname);
                    formData.append('lname', lname);
                    formData.append('snumber', snumber);
                    formData.append('email', email);
                    formData.append('cnumber', cnumber);
                    formData.append('program', program);
                    formData.append('department', department);
                    formData.append('passwordInput', passwordInput);
                    formData.append('confirmPasswordInput', confirmPasswordInput);
                    formData.append('profilepicture', imageFile);

                    $.ajax({
                        url: 'signup.php',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            // Handle success response
                            $('#verification').modal('hide'); // Hide the verification modal
                            toastr.success("Registration successful!");

                            // Add a 1-second timeout before redirecting
                            setTimeout(function() {
                                window.location.href = 'index.php';
                            }, 1000); // 1000 milliseconds = 1 second
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                } else {
                    // Display error message or handle invalid OTP
                    console.log('Invalid OTP');
                }
            });

            // Bind the click event for #resendOTP button
            $('#resendOTP').off('click').on('click', function() {
                resendOTP();
                disableResendOTP();
            });
        }

        // Function to resend OTP
        function resendOTP() {
            $.ajax({
                url: 'config/sendOTP.php',
                type: 'POST',
                data: {
                    phoneNumber: cnumber
                },
                success: function(response) {
                    otp = response;
                    toastr.success("OTP resent successfully!");
                },
                error: function(xhr, status, error) {
                    console.error('Error sending OTP:', error);
                }
            });
        }

        // Function to disable Resend OTP button and handle timer
        function disableResendOTP() {
            $('#resendOTP').prop('disabled', true); // Disable the button
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
        }
    });
});

</script>

<!-- LOCAL SCRIPTS -->
<script type="text/javascript" src="assets/bootstrap/js/popper.min.js"></script>
<script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/register.js"></script>
</body>
</html>