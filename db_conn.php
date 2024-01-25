<?php
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_HOST", "localhost");
define("DB_NAME", "Desks");
define("CHARSET", "utf8mb4");

if (defined("INITIALIZING_DATABASE")) {
    $dbc = new mysqli(DB_HOST, DB_USER, DB_PASSWORD)
        or die("Connection failed" . mysqli_connect_error());
    $dbc->set_charset(CHARSET);
} else {
    $dbc = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Connection Failed" . mysqli_connect_error());
    $dbc->set_charset(CHARSET);
}
?>
