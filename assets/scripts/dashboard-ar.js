// Initialize DOM elements
const increaseChanceBtn = document.getElementById('increase-chance');
const transactionHistory = document.getElementById('transaction-history');
const invoiceForm = document.getElementById('invoice-form');
const transactions = document.getElementById('transactions');
const leaderBoadButton = document.getElementById('leaderBoadButton');
const winners = document.getElementById('winners');
const rootUrl = window.location.origin;

const invoiceUrl = `${rootUrl}/inc/ajax-invoice-check.php`;


const inputInvoice = document.getElementById('inputInvoice');
    const fileChosen = document.getElementById('file-chosen');

    inputInvoice.addEventListener('change', function(){
        if (inputInvoice.files.length > 0) {
            fileChosen.textContent = inputInvoice.files[0].name;
        } else {
            fileChosen.textContent = "لم يتم اختيار ملف"; // Arabic for "No file chosen"
        }
    });


// Function to toggle active class between elements
function toggleActive(elementToActivate, elementsToDeactivate, triggerButton) {
    elementToActivate.classList.add('active');
    elementsToDeactivate.forEach(el => el.classList.remove('active'));
    triggerButton.classList.add('active');
}

// Event listeners for buttons to switch between forms
increaseChanceBtn.addEventListener('click', () => {
    toggleActive(invoiceForm, [transactionHistory, transactions], increaseChanceBtn);
});

transactionHistory.addEventListener('click', () => {
    toggleActive(transactions, [increaseChanceBtn, invoiceForm], transactionHistory);
});

// Leaderboard toggle with button text change
leaderBoadButton.addEventListener('click', () => {
    winners.classList.toggle('active');

    // Toggle the + and - symbol
    if (leaderBoadButton.textContent.includes('+')) {
        leaderBoadButton.textContent = 'قائمة المتصدرين -';
    } else {
        leaderBoadButton.textContent = 'قائمة المتصدرين +';
    }
});

// Invoice number change event with AJAX to check invoice existence
$('#inv-number').on('change', function () {
    const invoiceNo = $('#inv-number').val();
    console.log(invoiceNo);

    $.ajax({
        type: 'POST',
        url: invoiceUrl,
        data: {
            invoice: invoiceNo
        },
        success: function (html) {
            $("#invoice_exists").html(html);
            const inverror = $('#invoice_exists p').html();
            console.log(inverror);

            if (inverror) {
                const lastSeven = inverror.substr(inverror.length - 7);
                if (lastSeven === 'mitted.') {
                    const invoiceExists = true;

                    if (invoiceExists) {
                        document.getElementById('inv-number').value = '';
                    }
                }
            }
        }
    });
});

// Image validation for inputInvoice
$('#inputInvoice').on('change', function () {
    const inputInvoice = $('#inputInvoice').val();
    const allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

    if (!allowedExtensions.exec(inputInvoice)) {
        $('#invoice-err').html('<p class="errormsg">نوع الملف غير صالح! يرجى اختيار صورة بصيغة JPG أو JPEG أو PNG أو GIF  </p>');
        $(this).val(''); // Clear the input field
        return false;
    } else {
        $('#invoice-err .errormsg').remove(); // Remove error message if the file is valid
    }
});

// Function to validate the invoice input field
function validateInvoice() {
    const invoice = $('#inputInvoice').val(); // Get the value of the invoice input field

    if (invoice.length < 1) {
        $('#invoice-err').html('<p class="errormsg">يرجى تحميل صورة بتنسيق jpg أو png أو gif  </p>');
        $('#inputInvoice').val(''); // Clear the input field
        return false; // Prevent form submission
    } else {
        $('#invoice-err .errormsg').remove(); // Remove error message if validation passes
    }

    return true; // Return true to indicate validation passed
}

// Invoice number validation before submission
function validateInvoiceNumber() {
    const invNumber = $('#inv-number').val();

    if (invNumber.length < 2) {
        $('#inv-number-err').html('<p class="errormsg">يرجى إدخال رقم فاتورة صالح  </p>');
        document.getElementById('inv-number').focus();
        return false;
    } else {
        $('#inv-number-err .errormsg').remove();
    }

    return true;
}

// Form submission event to validate invoice and invoice number
$('#submit-button').on('click', function (event) {
    if (!validateInvoice() || !validateInvoiceNumber()) {
        event.preventDefault(); // Prevent form submission if validation fails
    }
});
