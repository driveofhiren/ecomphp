<!DOCTYPE html>
<html lang="en">
<?php
include_once 'db_conn.php';
include_once 'navbar.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Initialize Database</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        define("INITIALIZING_DATABASE", 1);
        require_once("db_conn.php");
        mysqli_query($dbc, "DROP DATABASE IF EXISTS Desks");
        mysqli_query($dbc, "CREATE DATABASE Desks");
        mysqli_select_db($dbc, "Desks");
        mysqli_query($dbc,
            "CREATE TABLE Desks (
            DeskID INT AUTO_INCREMENT PRIMARY KEY,
            Name VARCHAR(255) NOT NULL,
            Description TEXT NOT NULL,
            Price DECIMAL(10, 2) NOT NULL,
            ImageURL VARCHAR(255),
            Dimensions VARCHAR(255),
            OtherInfo VARCHAR(255),
            ProductAddedBy VARCHAR(255) DEFAULT 'Hiren Gohil' NOT NULL
        ) Engine=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4"
        );
        mysqli_query($dbc,
            "CREATE TABLE Users (
            UserID INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            usertype ENUM('Customer', 'Admin') NOT NULL
        ) Engine=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4"
        );
        echo "<h5>Database Initialized</h5>";
        header("Location: desklist.php");
        exit();
    }
    ?>
    <form method="POST">
        <button type="submit">Initialize Database Desk and Users in Your System</button>
    </form>
</body>

</html>
