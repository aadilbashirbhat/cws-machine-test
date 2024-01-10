// public/js/app.js

let giftCardDetails = null; // Define a global variable to store gift card details

function showPopup() {
    // Hide the button
    document.getElementById('validateGiftCardButton').style.display = 'none';

    // Show the gift card popup
    document.getElementById('giftCardPopup').style.display = 'block';
}

function validateGiftCard() {
    var giftCardNumber = document.getElementById('giftCardNumber').value;

    // Call backend API to validate and update gift card
    fetch('/validate-gift-card', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                giftCardNumber: giftCardNumber
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Card not found"); // Throw an error for non-successful responses
            }
            return response.json();
        })
        .then(data => {
            // Set giftCardDetails global variable
            giftCardDetails = data.giftCardDetails;

            // Display details in a card
            showGiftCardDetails(giftCardDetails);
            // Update the balance of the gift card
            updateGiftCardBalance(data.giftCardDetails[0].pimwick_gift_card_id, data.giftCardDetails[0].balance);

            document.getElementById('giftCardPopup').style.display = 'none';
        })
        .catch(error => {
            // Display Bootstrap 5 alert error message
            showErrorMessage('Error validating gift card: Card not found.');
            console.error(error);
        });
}

        function showErrorMessage(message) {
            var alertDiv = document.createElement('div');
            alertDiv.classList.add('alert', 'alert-danger', 'mt-3');
            alertDiv.innerHTML = `
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                ${message}
            `;
            document.getElementById('giftCardDetailsContainer').appendChild(alertDiv);

            // Automatically close the alert after 5 seconds
            setTimeout(function () {
                alertDiv.remove();
            }, 5000);
        }

function updateGiftCardBalance(pimwickGiftCardId, updatedBalance) {
    // Call backend API to update gift card balance
    fetch('/update-gift-card-balance', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                pimwick_gift_card_id: pimwickGiftCardId,
                balance: updatedBalance
            })
        })
        .then(response => response.json())
        .then(data => {
            // Display success message for gift card balance update
            showAlert(data.message);
        })
        .catch(error => {
            // Display error message for gift card balance update
            // showErrorMessage('Error updating gift card balance. Please try again.');
            // console.error(error);
        });
}

function showGiftCardDetails(giftCardDetails) {
    var detailsContainer = document.getElementById('giftCardDetailsContainer');

    // Create a new div for the card
    var cardDiv = document.createElement('div');
    cardDiv.classList.add('credit-card');

    const balance = parseFloat(giftCardDetails[0].balance);

    // Populate the card 
    cardDiv.innerHTML = `
        <div class="circle1"></div>
        <div class="circle2"></div>
        <div class="head">
            <div>
                <i class="fa-solid fa-credit-card fa-2xl"></i>
            </div>
            <div>Gift Card</div>
        </div>
        <div class="number">
            <div>${giftCardDetails[0].number}</div>
        </div>
        <div class="tail">
            <div>Balance: <b>$</b> ${balance.toFixed(2)}</div>
            <div></div>
            <div class="">Status:
                <span class="">Card is Valid</span>
            </div>
        </div>
    `;

    // Append the card details 
    detailsContainer.innerHTML = ''; // Clear previous content
    detailsContainer.appendChild(cardDiv);

    // Create a new div for the payment input and button
    var paymentDiv = document.createElement('div');
    paymentDiv.innerHTML = `
        <div class="form-floating mb-3 mt-3">
            <input type="text" class="form-control" name="customerNumber" id="customerNumber" value="" placeholder="Enter Customer Number" required>
            <label for="customerNumber" class="form-label">Customer Number</label>
        </div>
        <div class="d-grid my-3">
            <button class="btn btn-primary btn-lg" type="button" onclick="applyPayment()">Apply Payment</button>
        </div>
    `;

    // Append the payment input and button
    detailsContainer.appendChild(paymentDiv);
    showAlert('Gift card details retrieved successfully');

}

function applyPayment() {
    // Ensure giftCardDetails is defined
    if (giftCardDetails) {
        // Get customer number from input
        var customerNumber = document.getElementById('customerNumber').value;

        // Store data in the database (you need to implement this part)
        storePaymentInDatabase(customerNumber, giftCardDetails[0].number, giftCardDetails[0].balance);
    } else {
        console.error('Gift card details not available.');
    }
}

function storePaymentInDatabase(customerNumber, giftCardNumber, balance) {
    // Call backend API to store payment details in the database
    fetch('/store-payment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                customerNumber: customerNumber,
                giftCardNumber: giftCardNumber,
                balance: balance
            })
        })
        .then(response => response.json())
        .then(data => {
            showAlert('Details Stored in Database. Redirecting to home...');

            // Redirect back to home page after 5 seconds
            setTimeout(function () {
                window.location.href = '/'; // Adjust the URL as needed
            }, 5000);
            // alert(data.message); // Display success/error message

            // Clear the gift card details after payment is applied
            giftCardDetails = null;
        })
        .catch(error => console.error(error));
}

function showAlert(message) {
    var alertDiv = document.createElement('div');
    alertDiv.classList.add('alert', 'alert-success', 'mt-3');
    alertDiv.innerHTML = `
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        ${message}
    `;
    document.getElementById('giftCardDetailsContainer').appendChild(alertDiv);

    // Automatically close the alert after 5 seconds
    setTimeout(function () {
        alertDiv.remove();
    }, 5000);
}
