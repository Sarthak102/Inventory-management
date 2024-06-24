<?php
include 'db.php';

// Fetch all products for the dropdown
$product_result = $conn->query("SELECT id, name FROM products");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $issued_quantity = $_POST['issued_quantity'];
    $issued_by = $_POST['issued_by'];

    // Fetch available quantity for the selected product
    $product_result = $conn->query("SELECT available_quantity FROM products WHERE id = $product_id");
    $product = $product_result->fetch_assoc();
    $new_balance = $product['available_quantity'] - $issued_quantity;

    // Update product quantity and log the issue
    $update_product = "UPDATE products SET available_quantity = $new_balance WHERE id = $product_id";
    $log_inventory = "INSERT INTO inventory_log (product_id, date, issued_quantity, issued_by, balance_quantity) VALUES ($product_id, CURDATE(), $issued_quantity, '$issued_by', $new_balance)";

    if ($conn->query($update_product) === TRUE && $conn->query($log_inventory) === TRUE) {
        echo "Product issued successfully";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Issue Product</title>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h1>Issue Product</h1>
        <form method="POST">
            <label for="product_id">Product Name:</label>
            <select name="product_id" id="product_id" required>
                <?php while ($product = $product_result->fetch_assoc()): ?>
                    <option value="<?php echo $product['id']; ?>"><?php echo $product['name']; ?></option>
                <?php endwhile; ?>
            </select><br>
            <label for="issued_quantity">Issued Quantity:</label>
            <input type="number" name="issued_quantity" id="issued_quantity" required><br>
            <label for="issued_by">Issued By:</label>
            <input type="text" name="issued_by" id="issued_by" required><br>
            <input type="submit" value="Issue Product">
        </form>
    </div>
</body>
</html>
