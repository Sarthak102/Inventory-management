<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $available_quantity = $_POST['available_quantity'];
    $vendor_id = $_POST['vendor_id'];

    $sql = "INSERT INTO products (name, available_quantity, vendor_id) VALUES ('$name', $available_quantity, $vendor_id)";
    if ($conn->query($sql) === TRUE) {
        echo "Product added successfully";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch vendors for the dropdown
$vendor_result = $conn->query("SELECT id, name FROM vendors");
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Add Product</title>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h1>Add Product</h1>
        <form method="POST">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required><br>
            <label for="available_quantity">Available Quantity:</label>
            <input type="number" name="available_quantity" id="available_quantity" required><br>
            <label for="vendor_id">Vendor:</label>
            <select name="vendor_id" id="vendor_id" required>
                <?php while ($vendor = $vendor_result->fetch_assoc()): ?>
                    <option value="<?php echo $vendor['id']; ?>"><?php echo $vendor['name']; ?></option>
                <?php endwhile; ?>
            </select><br>
            <input type="submit" value="Add Product">
        </form>
    </div>
</body>
</html>
