<?php
session_start();
include_once 'db_conn.php';
include_once 'desks.php';
include_once 'navbar.php';

$successMessage = $errorMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    if (isset($_POST['deleteDesk'])) {
        $deskIDToDel = $_POST['DeskID'];
        $desk = new Desk($dbc);
        if ($desk->deleteDesk($deskIDToDel)) {
            $successMessage = "Desk Removed";
            header("Location: desklist.php");
            exit();
        } else {
            $errorMessage = "Please try again. Can't Perform the Delete Task";  }
    }
    if (isset($_POST['DeskID'], $_POST['name'], $_POST['price'], $_POST['description'], $_FILES['photo'], $_POST['dimensions'], $_POST['otherInfo'])) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $dimensions = $_POST['dimensions'];
        $otherInfo = $_POST['otherInfo'];
        if (empty($name) || empty($price) || empty($description) || empty($dimensions) || empty($otherInfo)) {
            $errorMessage = "Every fields are required!";
        } else {
            $deskID = $_POST['DeskID'];
            $targetDirectory = "imgs/";
            $targetFile = $targetDirectory . basename($_FILES["photo"]["name"]);
            if (!empty($_FILES["photo"]["tmp_name"])) {
                if (getimagesize($_FILES["photo"]["tmp_name"]) === false) {
                    $errorMessage = "Please upload a valid image file.";
                } elseif (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
                    $imageURL = $targetFile;
                    $desk = new Desk($dbc);

                    if ($desk->updateDesk($deskID, $name, $description, $price, $imageURL, $dimensions, $otherInfo)) {
                        $successMessage = "Desk updated successfully!";
                    } else {
                        $errorMessage = "Error updating desk. Please try again.";
                    }
                } else {
                    $errorMessage = "Uploading file failed. Please try again.";
                }
            } else {
                $errorMessage = "Fill all the required fields.";
            }
        }
    }
}

if (isset($_GET['DeskID'])) {
    $deskID = $_GET['DeskID'];
    $desk = new Desk($dbc);
    $deskDetails = $desk->getDeskByID($deskID);
    if (!$deskDetails) {
        $errorMessage = "Desk not found.";
    }
} else {
    $errorMessage = "Desk ID is missing.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Update Desk</title>
</head>

<body class="container-fluid">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2>Update Desk</h2>
            <?php
            if (!empty($successMessage)) {
                echo "<div class='alert alert-success feedback-message'>$successMessage</div>";
            }
            if (!empty($errorMessage)) {
                echo "<div class='alert alert-danger feedback-message'>$errorMessage</div>";
            }
            ?>
            <form method="post" enctype="multipart/form-data">
                <!-- Include a hidden field to store the desk ID -->
                <input type="hidden" name="DeskID" value="<?php echo $deskDetails['DeskID']; ?>">
<div class="form-group">
    <label for="name">Desk Name:</label>
    <input type="text" name="name" class="form-control" value="<?php echo isset($deskDetails['Name']) ? $deskDetails['Name'] : ''; ?>" required>
</div>

<div class="form-group">
    <label for="price">Price:</label>
    <input type="number" name="price" class="form-control" value="<?php echo isset($deskDetails['Price']) ? $deskDetails['Price'] : ''; ?>" required>
</div>
<div class="form-group">
    <label for="description">Description:</label>
    <textarea name="description" class="form-control" required><?php echo isset($deskDetails['Description']) ? $deskDetails['Description'] : ''; ?></textarea>
</div>
<div class="form-group">
    <label for="photo">Photo:</label>
    <input type="file" name="photo" class="form-control">
    <p>Current Photo: <?php echo isset($deskDetails['ImageURL']) ? $deskDetails['ImageURL'] : 'No photo available'; ?></p>
</div>
<div class="form-group">
    <label for="dimensions">Dimensions:</label>
    <input type="text" name="dimensions" class="form-control" value="<?php echo isset($deskDetails['Dimensions']) ? $deskDetails['Dimensions'] : ''; ?>" required>
</div>
<div class="form-group">
    <label for="otherInfo">Other Info:</label>
    <input type="text" name="otherInfo" class="form-control" value="<?php echo isset($deskDetails['OtherInfo']) ? $deskDetails['OtherInfo'] : ''; ?>" required>
</div>
                
    <button type="submit" class="btn btn-primary">Update Desk</button>
  </form>
            <form method="post">
                <input type="hidden" name="DeskID" value="<?php echo $deskDetails['DeskID']; ?>">
                <button type="submit" name="deleteDesk" class="btn btn-danger">Delete Desk</button>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
