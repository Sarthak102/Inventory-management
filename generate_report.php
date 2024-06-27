<?php
include 'db.php';

// Ensure that the FPDF library is correctly included
require('fpdf.php');

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Calculate start and end dates
        $month = isset($_POST['month']) ? $_POST['month'] : 1;
        $year = isset($_POST['year']) ? $_POST['year'] : date('Y');

        $startDate = "$year-$month-01";
        $endDate = date("Y-m-t", strtotime($startDate));

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Summary Of Consumables Consumption In Database Group', 0, 1, 'C');
        $this->Ln(5);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'Period: From ' . $startDate . ' To ' . $endDate, 0, 1, 'C');
        $this->Ln(5);
    }

    // Page footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    // Table with inventory log data
    function InventoryTable($header, $data)
    {
        $this->SetFont('Arial', 'B', 10);
        $widths = array(10, 30, 30, 30, 30, 30, 30);
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($widths[$i], 7, $header[$i], 1);
        }
        $this->Ln();
        $this->SetFont('Arial', '', 10);
        foreach ($data as $row) {
            for ($i = 0; $i < count($row); $i++) {
                $this->Cell($widths[$i], 6, $row[$i], 1);
            }
            $this->Ln();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $month = $_POST['month'];
    $year = $_POST['year'];

    $startDate = "$year-$month-01";
    $endDate = date("Y-m-t", strtotime($startDate));

    $sql = "SELECT il.*, p.name AS product_name
            FROM inventory_log il
            JOIN products p ON il.product_id = p.id
            WHERE DATE(il.date) BETWEEN '$startDate' AND '$endDate'";
    $result = $conn->query($sql);

    $header = array('SN', 'Product ID', 'Product Name', 'Date', 'Issued Quantity', 'Issued By', 'Balance Quantity');
    $data = array();
    $sn = 1;

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = array($sn++, $row['product_id'], $row['product_name'], $row['date'], $row['issued_quantity'], $row['issued_by'], $row['balance_quantity']);
        }
    }

    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Date: ' . date('Y-m-d'), 0, 1, 'R');
    $pdf->Ln(5);
    $pdf->InventoryTable($header, $data);
    $filename = "inventory_report_$year-$month.pdf";
    $pdf->Output('F', $filename);

    echo "<div class='report-message'>Report generated: <a class='download-link' href='$filename' download>Download Report</a></div>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Generate Report</title>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h1>Generate Inventory Report</h1>
        <form method="POST">
            <label for="month">Month (1-12):</label>
            <input type="number" name="month" id="month" min="1" max="12" required><br>
            <label for="year">Year:</label>
            <input type="number" name="year" id="year" min="2000" max="2100" required><br>
            <input type="submit" value="Generate Report">
        </form>
    </div>

    
</body>
</html>
