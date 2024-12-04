<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Conditions</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <style>
        body {
            background-color: #343a40; /* Dark background */
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .modal-dialog {
            max-width: 600px; /* Limit width */
        }
        .modal-content {
            border-radius: 8px;
        }
        .modal-header {
            background-color: #007bff;
            color: white;
            border-bottom: none;
            display: flex;
            justify-content: center;
        }
        .modal-header h5 {
            margin: 0;
        }
        .modal-body {
            color: #343a40;
        }
        .modal-footer {
            display: flex;
            justify-content: center;
            border-top: none;
        }
        .btn-accept {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none; /* Make sure it looks like a button */
        }
         /* Sticky modal header */
.modal-header-sticky {
    position: sticky;
    top: 0;
    background-color: white; /* Match modal background */
    z-index: 10; /* Ensure it stays above scrollable content */
    padding: 10px 0;
    border-bottom: 1px solid #ddd; /* Optional: subtle border for separation */
}

/* Blue text for the title */
.modal-title-blue {
    color: #007bff; /* Bootstrap primary blue */
    margin: 0;
}

/* Scrollable modal body */
.modal-scrollable {
    max-height: 80vh; /* Limit height for scrolling */
    overflow-y: auto; /* Enable vertical scrolling */
    padding: 15px; /* Optional: spacing for better readability */
}

/* Ensure modal close button stays styled */
.modal-close {
    background-color: #7272eb;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 10px 20px;
    cursor: pointer;
    font-weight: bold;
}

    </style>
</head>
<body>

<!-- Terms and Conditions Modal -->
<div class="modal" id="termsModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header-sticky">
                    <h1 class="modal-title-blue">Terms and Conditions</h1>
                </div>
                <div class="modal-scrollable">
                 

                <p>Welcome to the M&M Cake Ordering System! By using our website and services, you agree to the following terms and conditions. Please read them carefully.</p>

                <h5>1. Acceptance of Terms</h5>
                <p>By placing an order through our M&M Cake Ordering System, you agree to be bound by these terms and conditions. Please read them carefully before proceeding with your order.</p>

                <h5>2. Ordering Process</h5>
                <p>Customers are responsible for providing accurate and complete information, including contact details, delivery address, and cake specifications.</p>
              <p>  Orders will be confirmed via email after payment is received (if payment method is G- Cash).</p>

                <h5>3. User Accounts</h5>
                <p>To place an order, you may need to create an account. You are responsible for maintaining the confidentiality of your account information and for all activities that occur under your account. Please notify us immediately of any unauthorized use of your account.</p>

                <h5>4. Payment Terms</h5>
                <p>All orders must be paid in full at the time of placing the order unless otherwise agreed.</p>
<p>Accepted payment methods include [Cash , Gcash].</p>
<p>Prices are subject to change without notice but will not affect orders already confirmed.</p>
                <p>Payment must be made at the time of order placement. We accept various payment methods, including credit/debit cards and other specified options.</p>

                <h5>5. Delivery and Pickup</h5>
                <p>Delivery options and fees will be provided during the checkout process. We will make every effort to deliver your order on time; however, we are not responsible for delays caused by circumstances beyond our control.</p>
                               <p> Customers opting for pickup must arrive at the scheduled time to avoid delays.</p>
 <p>Delivery is available within Local areas for an additional fee depending on the distance of area.</p>
 <p>We are not responsible for damages to cakes once they have been picked up or delivered successfully.</p>
                <h5>6. No Cancellations</h5>
                <p>Orders can only be canceled if the delivery status has not been confirmed. Once the delivery status is confirmed, cancellations and refunds will no longer be accepted.</p>

                <h5>7. Refunds</h5>
                <p>Refunds will be issued at our discretion and only in cases where an error has occurred on our part. Please contact us for further assistance if you believe you are eligible for a refund.</p>

                <h5>8.Customization</h5>
                <p>Customization requests (e.g., specific designs, colors, or additional toppings) must be submitted at the time of ordering.
                While we will make every effort to match designs and colors, slight variations may occur due to the handmade nature of our cakes.</p>
                

                <h5>9.Allergies and Dietary Restrictions</h5>
                <p>Our cakes may contain or come into contact with allergens such as nuts, dairy, eggs, gluten, and soy.</p>
                <p>It is the customer’s responsibility to inform us of any allergies or dietary restrictions at the time of ordering.</p>
                <p>While we take precautions to minimize cross-contamination, we cannot guarantee a completely allergen-free product.</p>
                <h5>10. Liability</h5>
                <p>We are not liable for delays caused by circumstances beyond our control (e.g., adverse weather, transportation issues).</p>
                <p> In the rare event of an issue with your order, please contact us within  1-2 hours before of pickup/delivery for resolution.</p>
                <h5>11. Changes to Terms</h5>
                <p>We reserve the right to update or modify these terms and conditions at any time. Any changes will be communicated via our website or directly to customers with active orders.
                </p>

                <h5>12. Contact Us</h5>
                <p>If you have any questions about these Terms and Conditions, please contact us at:</p>
                <p><strong>M&M Cake Ordering System</strong><br>
                Phone: 09158259643<br>
                Email: mandmcakeorderingsystem@gmail.com<br>
                Address: Poblacion, Madridejos, Cebu</p>

                    <button class="modal-close btn btn-secondary mt-3" id="closeModal">Close</button>
                </div>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function() {
        $('#termsModal').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });

        // Redirect to signup.php on Accept button click
        $('#acceptBtn').click(function() {
            window.location.href = 'index.php';
        });
    });
</script>
</body>
</html>
