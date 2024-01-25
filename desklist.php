<?php
session_start();
include 'desks.php';
include_once 'db_conn.php';
include_once 'navbar.php';

$desk = new Desk($dbc);
$desks = $desk->getDesks();
$minPrice = isset($_GET['minPrice']) ? $_GET['minPrice'] : null;
$maxPrice = isset($_GET['maxPrice']) ? $_GET['maxPrice'] : null;
$deskName = isset($_GET['deskName']) ? $_GET['deskName'] : null;
//Filtering Products through these three parameters.
$desks = $desk->getDesksWithFilters($minPrice, $maxPrice, $deskName);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Desk List</title>
</head>
<body class="container-fluid">
    <div class="center">
    <?php
        if (isset($_SESSION['username'])) {
            echo "<h3>Hello, " . $_SESSION['username'] . " Explore your favorites!</h3>";
        } else {
            echo "<p>Please <a href='login.php'>Login</a> if still haven't!</p>";
        }
        ?>        <form method="get" class="mb-4">
            <div class="range-slider">
                <label for="priceRange">Price Range:</label>
                <input type="range" name="minPrice" id="minPrice" min="0" max="2000" step="100" value="<?php echo isset($_GET['minPrice']) ? $_GET['minPrice'] : 0; ?>">
                <span id="minPriceValue"><?php echo isset($_GET['minPrice']) ? $_GET['minPrice'] : 0; ?></span>
                <span> - </span>
                <span id="maxPriceValue"><?php echo isset($_GET['maxPrice']) ? $_GET['maxPrice'] : 2000; ?></span>
                <input type="range" name="maxPrice" id="maxPrice" min="0" max="2000" step="100" value="<?php echo isset($_GET['maxPrice']) ? $_GET['maxPrice'] : 2000; ?>">
            </div>
            <label for="deskName">Company Name:</label>
            <input type="text" name="deskName" id="deskName" class="form-control">
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
        <div class="row">
            <!-- Desk Card -->
            <?php
            if ($desks) {
                foreach ($desks as $desk) {
            ?>
                    <div class="col-md-4">
                        <div class="card desk-card">
                            <img src="<?php echo $desk['ImageURL']; ?>" alt="Desktop" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href='deskmoreinfo.php?DeskID=<?php echo $desk['DeskID']; ?>'>
                                        <?php echo $desk['Name']; ?>
                                    </a>
                                </h5>
                                <p class="text-muted"><?php echo $desk['Description']; ?></p>
                                <p class="card-text"><?php echo $desk['Price']; ?> CAD</p>
                                <?php
                // Checking type of user so we can hide/show some CRUD Operations(Update)
                if (isset($_SESSION['usertype']) && $_SESSION['usertype'] === 'Customer') {
                } else {    
                ?><a href='update_desk.php?DeskID=<?php echo $desk['DeskID']; ?>'>Update</a>
                <?php } ?>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p class='alert alert-danger'>Give us Some Time to Add more Products! or your desired product is not available!</p>";
                echo "<p class='alert'>Are you eligible to Sell a Product? Speak with our Sales Team to know more.</p>";
            }     
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        var minPriceInput = document.getElementById('minPrice');
        var maxPriceInput = document.getElementById('maxPrice');
        var minPriceValue = document.getElementById('minPriceValue');
        var maxPriceValue = document.getElementById('maxPriceValue');
        minPriceInput.addEventListener('input', function () {
            minPriceValue.textContent = minPriceInput.value;
        });
        maxPriceInput.addEventListener('input', function () {
            maxPriceValue.textContent = maxPriceInput.value;
        });
    </script>

