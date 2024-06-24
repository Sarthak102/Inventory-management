<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $contact_info = $_POST['contact_info'];

    $sql = "INSERT INTO vendors (name, contact_info) VALUES ('$name', '$contact_info')";
    if ($conn->query($sql) === TRUE) {
        echo "Vendor added successfully";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Add Vendor</title>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h1>Add Vendor</h1>
        <form method="POST">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required><br>
            <label for="contact_info">Contact Info:</label>
            <input type="text" name="contact_info" id="contact_info" required><br>
            <input type="submit" value="Add Vendor">
        </form>
    </div>
</body>
</html>
