<?php
session_start();
include_once 'db_conn.php';
include_once 'navbar.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $usertype = ($_POST['usertype'] === 'Admin') ? 'Admin' : 'Customer';
    if (empty($username) || empty($email) || empty($_POST['password']) || empty($usertype)) {
        $errors[] = "All fields are required.";
    }
    if (!$email) {
        $errors[] = "Enter Valid email address.";
    }
    if (!preg_match("/^[a-zA-Z0-9]+$/", $username)) {
        $errors[] = "Enter Valid username. Only letters and numbers are allowed.";
    }
    if (empty($errors)) {
        $stmt = $dbc->prepare("INSERT INTO users (username, email, password, usertype) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $password, $usertype);
        $stmt->execute();
        $stmt->close();
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self';">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Register</title>
</head>

<body class="container-fluid">
    <div class="center1">
        <h3>Register</h3>

        <form method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="usertype">User Type:</label>
                <select name="usertype" class="form-control" required>
                    <option value="Customer">Customer</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
