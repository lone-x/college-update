<?php
require_once 'database.php';


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];

$sql = "DELETE FROM grades WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: managegrade.php");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();
?>
