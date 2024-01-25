

<nav class="navbar navbar-expand-sm navbar-light bg-light">
    <div class="container">

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="/Tech_Rockers_final/desklist.php" aria-current="page">Desks</a>
                </li>
                <?php
                // Check if the user is of type "customer"
                if (isset($_SESSION['usertype']) && $_SESSION['usertype'] === 'Customer') {
                } else {    
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/Tech_Rockers_final/add_desk.php">Add Desk</a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" href="/Tech_Rockers_final/cart.php">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Tech_Rockers_final/login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Tech_Rockers_final/register.php">Register</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
