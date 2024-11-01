<?php
require_once 'database.php';
require_once 'restricted.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $pdf_path = "";

    if (isset($_FILES["pdf"]) && $_FILES["pdf"]["error"] == 0) {
        $target_dir = "circularuploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($_FILES["pdf"]["name"]);
        if (move_uploaded_file($_FILES["pdf"]["tmp_name"], $target_file)) {
            $pdf_path = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit;
        }
    }

    $stmt = $conn->prepare("INSERT INTO circulars (title, pdf_path) VALUES (?, ?)");
    $stmt->bind_param("ss", $title,  $pdf_path);

    if ($stmt->execute()) {
        echo "New circular added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Circular</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="text-center mt-5">Add Circular</h1>
    <form action="addcircular.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

       

        <div class="form-group">
            <label for="pdf">Upload PDF:</label>
            <input type="file" class="form-control-file" id="pdf" name="pdf" accept=".pdf" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Add Circular</button>
    </form>
    <a href="managecircular.php" class="btn btn-danger btn-block mt-3">Back</a>
</div>
</body>
</html>
