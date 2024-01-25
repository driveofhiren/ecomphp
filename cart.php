<?php
session_start();
include_once 'navbar.php';

if (isset($_POST['addToCart'])) {
    $deskName = htmlspecialchars($_POST['deskName'], ENT_QUOTES, 'UTF-8');
    $deskPrice = floatval($_POST['deskPrice']);

    if (!isset($_SESSION['shopping_cart'])) {
        $_SESSION['shopping_cart'] = array();
    }

    $_SESSION['shopping_cart'][] = array(
        'Name' => $deskName,
        'Price' => $deskPrice
    );

    echo "<p class='alert alert-success' role='alert'>Product added to cart!</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Shopping Cart</title>
</head>
<body>

<div class="container cart-container">
    <?php
    if (isset($_SESSION['shopping_cart']) && !empty($_SESSION['shopping_cart'])) {
        echo "<h3>Cart Contents:</h3>";
        echo "<table class='table'>";
        echo "<thead><tr><th>Product Name</th><th>Price</th></tr></thead>";
        echo "<tbody>";

        $totalPrice = 0;
        foreach ($_SESSION['shopping_cart'] as $product) {
            echo "<tr><td>" . htmlspecialchars($product['Name'], ENT_QUOTES, 'UTF-8') . "</td><td>{$product['Price']} CAD</td></tr>";
            $totalPrice += $product['Price'];
        }

        echo "</tbody></table>";
        $taxRate = 0.10;
        $tax = $totalPrice * $taxRate;
        $totalPriceWithTax = $totalPrice + $tax;

        echo "<p>Total Price: {$totalPrice} CAD</p>";
        echo "<p>Tax (10%): {$tax} CAD</p>";
        echo "<p>Total Price (including tax): {$totalPriceWithTax} CAD</p>";

        echo "<form action='checkout.php' method='post'>";
        echo "<input type='hidden' name='totalPrice' value='{$totalPrice}'>";
        echo "<input type='hidden' name='tax' value='{$tax}'> ";
        echo "<input type='hidden' name='totalPriceWithTax' value='{$totalPriceWithTax}'>";
        echo "<button type='submit' name='checkout' class='btn btn-primary checkout-btn'>Checkout</button>";
        echo "</form>";
    } else {
        echo "<p class='alert alert-info' role='alert'>Your cart is empty</p>";
    }
    ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
