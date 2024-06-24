<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $month = $_POST['month'];
    $year = $_POST['year'];

    $filename = "inventory_report_$year-$month.csv";
    $file = fopen($filename, "w");

    // Adding "Product Name" to the header
    $header = array("ID", "Product ID", "Product Name", "Date", "Issued Quantity", "Issued By", "Balance Quantity", "Vendor Name");
    fputcsv($file, $header);

    // Adjusting SQL query to include the product name
    $sql = "SELECT il.*, p.name AS product_name, v.name AS vendor_name 
            FROM inventory_log il
            JOIN products p ON il.product_id = p.id
            JOIN vendors v ON p.vendor_id = v.id
            WHERE MONTH(il.date) = $month AND YEAR(il.date) = $year";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Adding "product_name" to the row data
            $row_data = array($row['id'], $row['product_id'], $row['product_name'], $row['date'], $row['issued_quantity'], $row['issued_by'], $row['balance_quantity'], $row['vendor_name']);
            fputcsv($file, $row_data);
        }
    }

    fclose($file);
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

    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close-btn">&times;</span>
            <p>Report generated successfully!</p>
            <a class='download-link' href='<?php echo $filename; ?>' download>Download Report</a>
        </div>
    </div>

    <script>
        const reportMessage = document.querySelector('.report-message');
        if (reportMessage) {
            const popup = document.getElementById('popup');
            popup.style.display = 'block';

            const closeBtn = document.querySelector('.close-btn');
            closeBtn.onclick = function() {
                popup.style.display = 'none';
            }

            window.onclick = function(event) {
                if (event.target == popup) {
                    popup.style.display = 'none';
                }
            }
        }
    </script>
</body>
</html>
