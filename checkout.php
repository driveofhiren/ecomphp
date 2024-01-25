<?php
session_start();
include_once 'navbar.php';
require('fpdf184/fpdf.php');
if (isset($_POST['checkout'])) {
    if (isset($_POST['totalPrice'])) {
        $totalPrice = $_POST['totalPrice'];
        $totalPriceWithTax = $_POST['totalPriceWithTax'];
        $tax = $_POST['tax'];
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Checkout Form</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        </head>
        <body>
        <div class="container mt-4">
            <h3 class="mb-4">Checkout Form</h3>
            <form action='payment.php' method='post'>
                <div class="form-group">
                    <label for='customerName'>Customer Name:</label>
                    <input type='text' name='customerName' class="form-control" required placeholder="Hiren Gohil">
                </div>
                <div class="form-group">
                    <label for='customerEmail'>Customer Email:</label>
                    <input type='email' name='customerEmail' class="form-control" required placeholder="hirengohil@example.com">
                </div>
                <div class="form-group">
                    <label for='customerAddress'>Customer Address:</label>
                    <input type='text' name='customerAddress' class="form-control" required placeholder="87 Main St, Waterloo">
                </div>
                <div class="form-group">
                    <label for='promoCode'>Promo Code:</label>
                    <input type='text' name='promoCode' class="form-control" placeholder="Optional">
                </div>
                <div class="form-group">
                    <label for='creditCardNumber'>Credit Card Number:</label>
                    <input type='text' name='creditCardNumber' class="form-control" required placeholder="XXXX-XXXX-XXXX-XXXX">
                </div>
                <div class="form-group">
                    <label for='location'>Location:</label>
                    <input type='text' name='location' class="form-control" required placeholder="Shipping address">
                </div>
                <div class="form-group">
                    <label for='paymentMethod'>Payment Method:</label>
                    <select name='paymentMethod' class="form-control" required>
                        <option value='credit_card'>Credit Card</option>
                        <option value='paypal'>PayPal</option>
                        <option value='Debit'>Debit</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Total: $<?php echo htmlspecialchars($totalPriceWithTax, ENT_QUOTES, 'UTF-8'); ?></label>
                    <input type='hidden' name='totalPrice' value='<?php echo htmlspecialchars($totalPrice, ENT_QUOTES, 'UTF-8'); ?>'>
                    <input type='hidden' name='totalPriceWithTax' value='<?php echo htmlspecialchars($totalPriceWithTax, ENT_QUOTES, 'UTF-8'); ?>'>
                    <input type='hidden' name='tax' value='<?php echo htmlspecialchars($tax, ENT_QUOTES, 'UTF-8'); ?>'>
                </div>
                <button type='submit' name='submit' class="btn btn-primary">Submit</button>
            </form>
        </div>
        </body>
        </html>
        <?php
    } else {
        echo "<p>Total price not provided</p>";
    }
} else {
    echo "<p>Invalid access to checkout</p>";
}
?>
