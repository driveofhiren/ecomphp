<?php
session_start();
include 'desks.php';
include_once 'db_conn.php';
include_once 'navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title><?php $DeskID = filter_var($_GET['DeskID'], FILTER_SANITIZE_NUMBER_INT);
        $desk = new Desk($dbc);
        $deskInfo = $desk->getDeskByID($DeskID);
        echo htmlspecialchars($deskInfo['Name'], ENT_QUOTES, 'UTF-8'); ?>
    </title>
</head>
<body>
<div class="container">
    <?php
    if (isset($_GET['DeskID'])) {
        if ($deskInfo) {
            ?>
            <div class="product-info">
                <h3><?php echo htmlspecialchars($deskInfo['Name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                <p><?php echo htmlspecialchars($deskInfo['Description'], ENT_QUOTES, 'UTF-8'); ?></p>
                <img src="<?php echo htmlspecialchars($deskInfo['ImageURL'], ENT_QUOTES, 'UTF-8'); ?>" alt="Desk" width="500px" class="img-fluid product-image">
                <p>Price: <?php echo htmlspecialchars($deskInfo['Price'], ENT_QUOTES, 'UTF-8'); ?> CAD</p>
                <p>Dimensions: <?php echo htmlspecialchars($deskInfo['Dimensions'], ENT_QUOTES, 'UTF-8'); ?></p>
                <p>Other Information: <?php echo htmlspecialchars($deskInfo['OtherInfo'], ENT_QUOTES, 'UTF-8'); ?></p>
                <form action="cart.php" method="post" class="mt-4">
                    <input type="hidden" name="deskName" value="<?php echo htmlspecialchars($deskInfo['Name'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="deskPrice" value="<?php echo htmlspecialchars($deskInfo['Price'], ENT_QUOTES, 'UTF-8'); ?>">
                    <button type="submit" name="addToCart" class="btn btn-primary">Add to Cart</button>
                </form>
            </div>
            <?php
        } else {
            echo "<p class='alert alert-danger'>Store is Currently on Maintainance. Give us Some Time to Add more Products</p>";
            echo "Are you eligible to Sell a Product? If yes Then please log in to add Your Desks here!";
        }
    } else {
        echo '<p class="alert alert-warning">You can\'t access this page without selecting products on <a class="nav-link" href="/Tech_Rockers_final/desklist.php">Desks</a></p>';  }  ?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
