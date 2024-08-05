$(document).ready(function () {
    const form = $('.signin');
    const anchorLink = form.find('a.next-step');
    const emailInput = $('#email');
    const imageFileInput = $('#imageFile');
    const passwordInput = $('#passwordInput');
    const confirmPasswordInput = $('#confirmPasswordInput');
    const email_validation = $('#email_validation');
    const passwordHelp = $('#passwordHelp');
    const passwordMatchError = $('#passwordMatchError');
    const img_validation = $('#img_validation, #profilepicture, #signature');
    passwordHelp.text('');
    anchorLink.on('click', function (event) {
        event.preventDefault(); // Prevent the default click action
    });
    
    // Function to check if all required fields are filled and meet validation criteria
    function checkFormFields() {
        const requiredInputs = form.find('input[required]');
        let allFieldsFilled = true;

        // Check each required input field
        requiredInputs.each(function () {
            if (!$(this).val()) {
                allFieldsFilled = false;
                return false; // Exit the loop if any field is not filled
            }
        });


        // Image file size validation
        const fileSizeLimit = 2 * 1024 * 1024; // 2MB
        const file = imageFileInput[0].files[0];
        if (file) {
            if (!file.type.startsWith('image/')) {
                img_validation.text('Please select a valid image file.');
                allFieldsFilled = false;
            } else if (file.size > fileSizeLimit) {
                img_validation.text('File size exceeds the limit (2MB).');
                allFieldsFilled = false;
            } else {
                img_validation.text('');
            }
        }

        // Password validation
        const password = passwordInput.val();
        const confirmPassword = confirmPasswordInput.val();
        if (password !== confirmPassword) {
            passwordMatchError.text('Passwords do not match');
            allFieldsFilled = false;
        } else {
            passwordMatchError.text('');
        }

        if (password.length < 8 && password !== '') {
            passwordHelp.text('Password must be at least 8 characters long.');
            allFieldsFilled = false;
        } else {
            passwordHelp.text('');
        }

        // Set or remove the href attribute based on the result
        if (allFieldsFilled) {
            anchorLink.attr('href', 'verification.php');
            anchorLink.off('click'); // Remove click event listener
        } else {
            anchorLink.removeAttr('href');
            anchorLink.on('click', function (event) {
                event.preventDefault(); // Prevent the default click action
            });
        }
    }

    // Attach input event listeners to trigger the check when inputs change
    form.find('input').on('input', checkFormFields);
});


$(document).ready(function() {
    $('.capitalize').on('input', function() {
        let words = $(this).val().split(' ');
        for (let i = 0; i < words.length; i++) {
            words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1);
        }
        $(this).val(words.join(' '));
    });
});