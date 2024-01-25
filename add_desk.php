<?php
include_once 'db_conn.php';
include_once 'desks.php';
include_once 'navbar.php';

// Initialize variables for feedback messages
$successMessage = $errorMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $Name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $Price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    $Description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $Dimensions = filter_input(INPUT_POST, 'dimensions', FILTER_SANITIZE_STRING);
    $OtherInfo = filter_input(INPUT_POST, 'otherInfo', FILTER_SANITIZE_STRING);

    // Check if all required fields are filled
    if ($Name && $Price !== false && $Description && $Dimensions && $OtherInfo) {
        $targetDirectory = "imgs/";
        $targetFile = $targetDirectory . basename($_FILES["photo"]["name"]);

        // Check if the uploaded file is an image
        if (getimagesize($_FILES["photo"]["tmp_name"]) !== false) {
      
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
                $ImageURL = $targetFile;

                // Use prepared statement to prevent SQL injection
                $desk = new Desk($dbc);
                if ($desk->createDesk($Name, $Description, $Price, $ImageURL, $Dimensions, $OtherInfo)) {
                    $successMessage = "Desk added successfully!";
                } else {
                    $errorMessage = "Error adding desk. Please try again.";
                }
            } else {
                $errorMessage = "Uploading file failed. Please try again.";
            }
        } else {
            $errorMessage = "File is not an image. Please upload a valid image file.";
        }
    } else {
        $errorMessage = "Fill in all the required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Add Desk</title>
</head>

<body class="container-fluid">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2>Add Desk</h2>
            <?php
            if (!empty($successMessage)) {
                echo "<div class='alert alert-success feedback-message' role='alert'>$successMessage</div>";
            }
            if (!empty($errorMessage)) {
                echo "<div class='alert alert-danger feedback-message' role='alert'>$errorMessage</div>";
            }
            ?>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Desk Name:</label>
                    <input type="text" name="name" class="form-control" required aria-describedby="nameHelp">
                    <small id="nameHelp" class="form-text text-muted">Enter the name of the desk.</small>
                </div>
                <div class="form-group">
                    <label for="price">Price (CAD):</label>
                    <input type="number" name="price" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="photo">Upload Desk Photo:</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="photo" name="photo" required>
                        <label class="custom-file-label" for="photo">Choose file</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="dimensions">Dimensions:</label>
                    <input type="text" name="dimensions" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="otherInfo">Other Info:</label>
                    <input type="text" name="otherInfo" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-lg">Add Desk</button>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
