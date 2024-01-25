<?php
session_start();
include_once 'navbar.php';
require('fpdf184/fpdf.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <?php
    if (isset($_POST['submit'])) {
        $customerName = $_POST['customerName'];
        $customerEmail = $_POST['customerEmail'];
        $customerAddress = $_POST['customerAddress'];
        $totalPrice = $_POST['totalPrice'];
        $totalPriceWithTax = $_POST['totalPriceWithTax'];
        $tax = $_POST['tax'];
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->Image('imgs/logo.jpg', 0, 0, 60, 60);

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(190, 10, 'Waterloo Desks', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(190, 10, '84 Weber Street,Waterloo', 0, 1, 'C');

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(190, 10, 'Invoice', 0, 1, 'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(190, 10, "Customer Name: $customerName", 0, 1);
        $pdf->Cell(190, 10, "Customer Email: $customerEmail", 0, 1);
        $pdf->Cell(190, 10, "Customer Address: $customerAddress", 0, 1);

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(40, 10, 'Product', 1);
        $pdf->Cell(40, 10, 'Price', 1);
        if (isset($_SESSION['shopping_cart']) && is_array($_SESSION['shopping_cart'])) {
            foreach ($_SESSION['shopping_cart'] as $product) {
                $pdf->Ln();
                $pdf->Cell(40, 10, $product['Name'], 1);
                $pdf->Cell(40, 10, $product['Price'] . ' CAD', 1);
            }
        } else {
            $pdf->Ln();
            $pdf->Cell(80, 10, 'No items in Cart', 1);
        }
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(40, 10, 'Total Price:', 0);
        $pdf->Cell(40, 10, $totalPrice . ' CAD', 0);
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Tax (10%):', 0);
        $pdf->Cell(40, 10, $tax . ' CAD', 0);
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Total (including tax):', 0);
        $pdf->Cell(40, 10, $totalPriceWithTax . ' CAD', 0);
        $pdfFileName = "TechRockers_invoice_$customerName.pdf";
        $pdf->Output($pdfFileName, 'F');
        ?>
        <div class="invoice-container">
            <div class="invoice-header">
                <h2 class="thank-you-message">Thank You, <?php echo $customerName; ?>!</h2>
                <p class="confirmation-message">Your payment of <?php echo $totalPriceWithTax; ?> CAD has been processed successfully.</p>
            </div>
            <div class="download-link">
                <a href="<?php echo $pdfFileName; ?>" download class="btn btn-success">Download Invoice</a>
            </div>
        </div>
        <?php
        // Emptying Cart after checkout
        unset($_SESSION['shopping_cart']);

    }
    ?>
</div>
</body>
</html>
