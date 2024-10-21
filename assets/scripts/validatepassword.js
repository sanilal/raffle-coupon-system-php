 // DOM Elements
 const passwordInput = document.getElementById('password');
 const passwordRequirements = document.getElementById('password-requirements');
 const lengthCondition = document.getElementById('length-condition');
 const uppercaseCondition = document.getElementById('uppercase-condition');
 const lowercaseCondition = document.getElementById('lowercase-condition');
 const numberCondition = document.getElementById('number-condition');
 const specialCondition = document.getElementById('special-condition');
 const pswrderrr = document.getElementById('pswrderrr');
 
 let passwordIsValid = false;

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

 // Form submission validation
 document.getElementById('submit-button').addEventListener('click', function(event) {
     // Run password validation before submitting the form
     validatePassword();

     // Ensure password validation passes
     if (!passwordIsValid) {
         pswrderrr.innerHTML = '<p class="errormsg">Password does not meet all the requirements</p>';
         event.preventDefault(); // Prevent form submission
     } else {
         pswrderrr.innerHTML = ''; // Clear error message if valid
         // You can proceed with form submission logic here
     }
 });