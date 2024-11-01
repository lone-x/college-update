<?php
require_once 'database.php';
require_once 'restricted.php';

$id = $_GET['id'];
$sql = "SELECT * FROM circulars WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$circular = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $pdf_path = $circular['pdf_path'];

    if (isset($_FILES["pdf"]) && $_FILES["pdf"]["error"] == 0) {
        $target_dir = "circularuploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($_FILES["pdf"]["name"]);
        if (move_uploaded_file($_FILES["pdf"]["tmp_name"], $target_file)) {
            if (file_exists($pdf_path)) {
                unlink($pdf_path);
            }
            $pdf_path = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit;
        }
    }

    $stmt = $conn->prepare("UPDATE circulars SET title = ?,  pdf_path = ? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $pdf_path, $id);

    if ($stmt->execute()) {
        header("Location: managecircular.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Circular</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="text-center mt-5">Edit Circular</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo $circular['title']; ?>" required>
        </div>

        <div class="form-group">
            <label for="pdf">Current PDF:</label><br>
            <a href="<?php echo $circular['pdf_path']; ?>" download>Download Current PDF</a><br>
            <label for="pdf">Upload New PDF:</label>
            <input type="file" class="form-control-file" id="pdf" name="pdf" accept=".pdf">
        </div>

        <button type="submit" class="btn btn-primary btn-block">Update Circular</button>
        <a href="deletecircular.php?id=<?php echo $id; ?>" class="btn btn-danger btn-block">Delete Circular</a>
    </form>
</div>
</body>
</html>
