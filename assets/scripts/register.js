// Document ready starts
$(document).ready(function(){

    // Handle terms click buttons
    const termsButtons = document.querySelectorAll('.termsClick');
    const popupOuter = document.querySelector('.popupOuter');

    // Show popup when terms are clicked
    termsButtons.forEach((termsButton) => {
        termsButton.addEventListener('click', () => {
            if (popupOuter) {
                popupOuter.classList.add('show');
            }
        });
    });

    // Handle message close and hash manipulation
    const msgClose = document.querySelector('.msgclose');
    if (msgClose) {
        msgClose.addEventListener('click', () => {
            const fullUrl = window.location.href;
            const hash = window.location.hash;
            const remainingUrl = fullUrl.replace(hash, '');
            const outerOverlay = document.querySelector('.participation');
            if (outerOverlay) {
                outerOverlay.classList.remove('active');
            }
            if (hash === '#getCoupon') {
                window.location.replace(remainingUrl);
            }
        });
    }

    // Root URL based on origin
    const rootUrl = window.location.origin;
    const invoiceUrl = `${rootUrl}/inc/ajax-invoice-check.php`;

    // Add event listener for real-time password validation
    const passwordInput = document.getElementById('password');
    const cpasswordInput = document.getElementById('cpassword');
    const passwordRequirements = document.getElementById('password-requirements');
    const lengthCondition = document.getElementById('length-condition');
    const uppercaseCondition = document.getElementById('uppercase-condition');
    const lowercaseCondition = document.getElementById('lowercase-condition');
    const numberCondition = document.getElementById('number-condition');
    const specialCondition = document.getElementById('special-condition');
    const pswrderrr = document.getElementById('pswrderrr');

    // Variable to track whether password validation passes
    let passwordIsValid = false;

    // Validate passwords on every input
    // Password validation function
    function validatePassword() {
        const password = passwordInput.value;

        let isLengthValid = false,
            isUppercaseValid = false,
            isLowercaseValid = false,
            isNumberValid = false,
            isSpecialCharValid = false;

        // Show password requirements once the user starts typing
        if (password.length > 0) {
            passwordRequirements.style.display = 'block';
        } else {
            passwordRequirements.style.display = 'none';
        }

        // Check password length
        if (password.length >= 6) {
            setValid(lengthCondition);
            isLengthValid = true;
        } else {
            setInvalid(lengthCondition);
        }

        // Check for uppercase letter
        if (/[A-Z]/.test(password)) {
            setValid(uppercaseCondition);
            isUppercaseValid = true;
        } else {
            setInvalid(uppercaseCondition);
        }

        // Check for lowercase letter
        if (/[a-z]/.test(password)) {
            setValid(lowercaseCondition);
            isLowercaseValid = true;
        } else {
            setInvalid(lowercaseCondition);
        }

        // Check for number
        if (/\d/.test(password)) {
            setValid(numberCondition);
            isNumberValid = true;
        } else {
            setInvalid(numberCondition);
        }

        // Check for special character
        if (/[@#%&*!$]/.test(password)) {
            setValid(specialCondition);
            isSpecialCharValid = true;
        } else {
            setInvalid(specialCondition);
        }

        // Set password validation flag
        passwordIsValid = isLengthValid && isUppercaseValid && isLowercaseValid && isNumberValid && isSpecialCharValid;
    }


  // Helper functions for password validation
  function setValid(element) {
    element.classList.remove('invalid');
    element.classList.add('valid');
    element.querySelector('span').textContent = '✔'; // Tick mark
}

function setInvalid(element) {
    element.classList.remove('valid');
    element.classList.add('invalid');
    element.querySelector('span').textContent = '✖'; // Cross mark
}

// Real-time password validation
passwordInput.addEventListener('input', validatePassword);

// Real-time confirm password validation
const confirmPswrdInp = $('#cpassword');
const confirmPasswordMsg = $('#confirm-password-msg');

// Function to check if passwords match in real-time
function checkPasswords() {
    const password = passwordInput.value;
    const confirmPassword = confirmPswrdInp.val();

    if (password === confirmPassword && password.length > 0) {
        confirmPasswordMsg.html('<p class="successmsg"></p>');
    } else {
        confirmPasswordMsg.html('<p class="errormsg">Passwords do not match </p>');
    }
}

 // Check passwords whenever user types in either password field
 confirmPswrdInp.on('input', checkPasswords);


    // Form validation on submit button click
    $('#submit-button').on('click', function() {
        const fName = $('#first-name').val();
        const address = $('#address').val();
        const city = $('#city').val();
        const mobile = $('#inputNumber').val();
        const email = $('#inputEmail4').val();

        // Validate first name
        if (fName.length < 3) {
            $('#fname-err').html('<p class="errormsg">Please enter a valid first name</p>');
            $('#first-name').addClass('highlighted');
            return false;
        } else {
            $('#fname-err .errormsg').remove();
            $('#first-name').removeClass('highlighted');
        }

        // Validate address
        if (address.length < 7) {
            $('#address-err').html('<p class="errormsg">Please enter a valid address</p>');
            $('#address').addClass('highlighted');
            return false;
        } else {
            $('#address-err .errormsg').remove();
            $('#address').removeClass('highlighted');
        }

        // Validate city
        if (city.length < 1) {
            $('#city-err').html('<p class="errormsg">Please enter region</p>');
            $('#city').addClass('highlighted');
            return false;
        } else {
            $('#city-err .errormsg').remove();
            $('#city').removeClass('highlighted');
        }

        // Validate mobile number
        if (!(mobile.length === 9 || mobile.length === 10)) {
            $('#mobile-err').html('<p class="errormsg">Please enter a valid phone number. Format: 5xxxxxxxx</p>');
            $('#inputNumber').addClass('highlighted');
            return false;
        } else {
            $('#mobile-err .errormsg').remove();
            $('#inputNumber').removeClass('highlighted');
        }

        // Validate email
        const emailRegex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!emailRegex.test(email)) {
            $('#email-err').html('<p class="errormsg">Please enter a valid email</p>');
            $('#inputEmail4').addClass('highlighted');
            return false;
        } else {
            $('#email-err .errormsg').remove();
            $('#inputEmail4').removeClass('highlighted');
        }

        // Password validation
        // Trigger password validation
        validatePassword();

        // Validate confirm password
        if (passwordInput.value !== cpasswordInput.value) {
            $('#confirm-password-msg').html('<p class="errormsg">Passwords do not match</p>');
            cpasswordInput.classList.add('highlighted');
            return false; // Prevent form submission
        } else {
            $('#confirm-password-msg .errormsg').remove();
            cpasswordInput.classList.remove('highlighted');
        }

        // Ensure password validation passes
        if (!passwordIsValid) {
            $('#pswrderrr').html('<p class="errormsg">Password does not meet all the requirements</p>');
            return false; // Prevent form submission
        } else {
            $('#pswrderrr .errormsg').remove();
        }

        // Form is valid, proceed with submission
    });


});
