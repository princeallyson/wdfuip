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
    $('#documents').DataTable({
      ajax: {
        url: 'get_request_documents.php',
        dataSrc: 'data'
      },
      columns: [
        { data: 'document_id' },
        { data: 'owner_id' },
        { data: 'document' },
        { data: 'document_type' },
        {
          data: 'uploaded_at',
          render: function (data, type, row) {
            // Format the date without using moment.js
            var date = new Date(data);
            return date.toLocaleDateString('en-US'); // Adjust the format as needed
          }
        },
        {
          data: 'document_id',
          render: function (data, type, row) {
            return '<button class="w-100 btn btn-primary view-button mb-2" data-bs-toggle="modal" data-bs-target="#view" onclick="viewDocument(' + data + ')">View</button><button class="w-100 btn btn-primary" data-bs-toggle="modal" data-bs-target="#assign-signatories" onclick="assignSignatory(' + data + ')">Assign Signatories</button>';
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


  // VIEW DOCUMENT MODAL START
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


// ASSIGN SIGNATORY MODAL START
$(document).ready(function() {
    $(document).on('change', '.designation_signatory, .department_signatory', function() {
        var designation = $(this).closest('.row').find('.designation_signatory').val();
        var department = $(this).closest('.row').find('.department_signatory').val();
        var signatory = $(this).closest('.row').find('.signatory');

        $.ajax({
            url: "autopopulate.php",
            type: "POST",
            data: {
                designation: designation,
                department: department
            },
            success: function(data) {
                signatory.html(data);
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
            }
        });
    });
});


  function assignSignatory(document_id) {

    console.log(document_id);

  // Make AJAX call to autopopulate.php to get the signatory
    $.ajax({
      url: "autopopulate.php",
      type: "POST",
      data: {
        document_id: document_id,
      },
      success: function(data, status) {

        $('#assign_signatory').html(data);
        populate();
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
        $('#user_designation').val(user.designation);
        $('#user_department').val(user.department);
        $('#user_cnumber').val(user.contactNumber);
        $('#user_email').val(user.email);
        $('#user_passwordInput').val(user.password);
        $('#user_profilepicture').val(user.password);
      });
    $('#my-profile').modal("show");
  }

  function editUserDetail(){
    var enumber = $('#user_enumber').val();
    var name = $('#user_name').val();
    var designation = $('#user_designation').val();
    var department = $('#user_department').val();
    var cnumber = $('#user_cnumber').val();
    var email = $('#user_email').val();
    var password = $('#user_passwordInput').val();
    var picture = $('#user_profilepicture').val();

    var hidden_userid = $('#hidden_userid').val();

    $.post("my-profile.php",
      {hidden_userid:hidden_userid,
      enumber:enumber,
      name:name,
      designation:designation,
      department:department,
      cnumber:cnumber,
      email:email,
      password:password,
      picture:picture
    },
    function(data,status){
      $('#my-profile').modal("hide");
      console.log(data);
      toastr.success("User Updated!");
    });
  }
  // EDIT PROFILE END

  // ASSIGN SIGNATORY START
$(document).ready(function() {
  // Handle form submission
  $('#assign_signatory').submit(function(event) {
    // Prevent default form submission
    event.preventDefault();
    
    // Retrieve all selected options' data-signatory-id attributes
    var document_id = $("#id").val();
    var signatoryIds = [];
    $(".signatory option:selected").each(function() {
      var id = $(this).attr('data-signatory-id');
      if (id) {
        signatoryIds.push(id);
      }
    });
    
    // Serialize form data
    var formData = $(this).serialize();
    
    // Include the signatoryIds array in the data object
    var requestData = {
      formData: formData,
      signatoryIds: signatoryIds,
      document_id: document_id
    };

    // AJAX request to submit form data
    $.ajax({
      url: 'assign-signatories.php',
      type: 'POST',
      data: requestData,
      success: function(data) {
        $("#assign-signatories").modal("hide");
        toastr.success("Signatories Assigned!");
      },
      error: function(xhr, status, error) {
        console.error("Error: " + error);
      }
    });
  });
});

  // ASSIGN SIGNATORY END

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
    function populate(){
    // Function to populate select element with options
    function populateSelect(selectElement, data) {
        console.log('Populating select:', selectElement);
        console.log('Data:', data);

        selectElement.empty(); // Clear existing options

        // Add default option for Program dropdown
        if (selectElement.hasClass('designation_signatory')) {
            selectElement.append($("<option></option>").text('Select Designation'));
        }

        // Add default option for Department dropdown
        if (selectElement.hasClass('department_signatory')) {
            selectElement.append($("<option></option>").text('Select Department'));
        }

        $.each(data, function(key, value) {
            selectElement.append($("<option></option>").text(value).attr("value", value));
        });

        console.log('Options added:', selectElement);
    }

    // AJAX request to fetch programs
    $.ajax({
        url: '../config/fetch-collegeComponents.php',
        type: 'GET',
        dataType: 'json',
        data: { action: 'fetch_designations' },
        success: function(response) {
            console.log('Designation response:', response);
            populateSelect($('.designation_signatory'), response);
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
            console.log('Departments response:', response);
            populateSelect($('.department_signatory'), response);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching departments:', error);
        }
    });
}