<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $increment_quantity = $_POST['increment_quantity'];

    $sql = "UPDATE products SET available_quantity = available_quantity + $increment_quantity WHERE id = $product_id";
    if ($conn->query($sql) === TRUE) {
        echo "Product quantity updated successfully";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch all products
$product_result = $conn->query("SELECT p.id, p.name, p.available_quantity, v.name AS vendor_name FROM products p JOIN vendors v ON p.vendor_id = v.id");
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>View Products</title>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h1>Available Products</h1>
        <div class="table-responsive">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Available Quantity</th>
                        <th>Vendor</th>
                        <th>Add Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($product = $product_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $product['id']; ?></td>
                            <td><?php echo $product['name']; ?></td>
                            <td><?php echo $product['available_quantity']; ?></td>
                            <td><?php echo $product['vendor_name']; ?></td>
                            <td>
                                <form method="POST" class="increment-form">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <input type="number" name="increment_quantity" min="1" required>
                                    <input type="submit" value="Add">
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
