const increaseChanceBtn = document.getElementById('increase-chance');
const transactionHistory = document.getElementById('transaction-history');
const invoiceForm = document.getElementById('invoice-form');
const transactions = document.getElementById('transactions');
const leaderBoadButton = document.getElementById('leaderBoadButton');
const winners = document.getElementById('winners');
const rootUrl = window.location.origin

 const invoiceUrl = `${rootUrl}/inc/ajax-invoice-check.php`

function toggleActive(elementToActivate, elementsToDeactivate, triggerButton) {
    elementToActivate.classList.add('active');
    elementsToDeactivate.forEach(el => el.classList.remove('active'));
    triggerButton.classList.add('active');
}

increaseChanceBtn.addEventListener('click', () => {
    toggleActive(invoiceForm, [transactionHistory, transactions], increaseChanceBtn);
});

transactionHistory.addEventListener('click', () => {
    toggleActive(transactions, [increaseChanceBtn, invoiceForm], transactionHistory);
});

leaderBoadButton.addEventListener('click', () => {
    winners.classList.toggle('active');

    // Toggle the + and - symbol
    if (leaderBoadButton.textContent.includes('+')) {
        leaderBoadButton.textContent = '- Leader Board';
    } else {
        leaderBoadButton.textContent = '+ Leader Board';
    }
});


$('#inv-number').on('change', function(){
    var invZone = $('#zone').val()
       var invoiceNo = $('#inv-number').val();
       console.log(invoiceNo);
       $.ajax({
           type: 'POST',
           url: invoiceUrl,
           data: {
            invoice: invoiceNo,
          //   zone: invZone // Add invZone to the data object
        },
           success:function(html){
        //    console.log(html);
               $("#invoice_exists").html(html)
               var inverror = $('#invoice_exists p').html();
               console.log(inverror);
               if(inverror){
                  var lastSeven = inverror.substr(inverror.length - 7);
               }
               
               if(lastSeven === 'mitted.') {
                  const invoiceExists = true;
  
               if(invoiceExists) {
                  // console.log(invoiceExists)
                   document.getElementById('inv-number').value='';
               }
               // document.getElementById('getCoupon').reset();
                // setTimeout(function() {
                //     location.href=`${rootUrl}/projects/persil`
                //   }, 900);
               }
            //   document.getElementById('getCoupon').reset();
              
               
  
           }
       });
  
   })
  
   /*Invoice check ends*/

           //  Image check starts
           $('#inputInvoice').on('change', function(){
            var inputInvoice = $('#inputInvoice').val();
            var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        
            if (!allowedExtensions.exec(inputInvoice)) {
            //    alert('Invalid file type! Please select a JPG, JPEG, PNG, or GIF image.');
                $('#invoice-err').html('<p class="errormsg">Invalid file type! Please select a JPG, JPEG, PNG, or GIF image.</p>')
                // Clear the input field if an invalid file is selected
                $(this).val('');
                return false;
            } else {
                $('#invoice-err .errormsg').remove();
            }
        
        });
        


        //  invoice submit form need to complete 

        const invoice = $('#inputInvoice').val();
    if(invoice.length < 1 ) {
       //  console.log(invoice);
        $('#invoice-err').html('<p class="errormsg">Please upload a picture in jpg/png/gif format </p>');
        $('#inputInvoice').val("");
        return false;
    } else {
     //   console.log(invoice.length);
        $('#invoice-err .errormsg').remove();
    }

    const invNumber = $('#inv-number').val();
    if(invNumber.length < 2) {
        $('#inv-number-err').html('<p class="errormsg">Please enter a valid invoice number</p>');
        document.getElementById('inv-number').focus();
        return false;
    } else {
        $('#inv-number-err .errormsg').remove();
    }

        // invoice submit form need to complete 