<?php
require_once 'database.php';

$sql = "SELECT * FROM grades";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Circulars</title>
    <link rel="stylesheet" href="header.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
          body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
         .container {
            max-width: 1100px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<div class="custom-main">
<div class="container mt-5">
    <h1 class="text-center">Gradesheets</h1>
    
    <div id="accordion">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card mb-3">
                    <div class="card-header" id="heading<?php echo $row['id']; ?>">
                        <h5 class="mb-0 d-flex justify-content-between align-items-center">
                            <button class="btn btn-link text-dark collapsed" data-toggle="collapse" data-target="#collapse<?php echo $row['id']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $row['id']; ?>">
                                <strong><?php echo htmlspecialchars($row['title']); ?></strong>
                            </button>
                        </h5>
                    </div>
                    <div id="collapse<?php echo $row['id']; ?>" class="collapse" aria-labelledby="heading<?php echo $row['id']; ?>" data-parent="#accordion">
                        <div class="card-body">
                            <a href="<?php echo htmlspecialchars($row['pdf_path']); ?>" class="text-primary" target="_blank" download>DOWNLOAD PDF</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No grades available.</p>
        <?php endif; ?>
    </div>
</div>
</div>
</div>
<script src="header.js"></script>
<?php include "footer.php" ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
