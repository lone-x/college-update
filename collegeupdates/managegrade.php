<?php
// Include database connection
require_once 'database.php';
require_once 'restricted.php';

$sql = "SELECT * FROM grades ";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Gradesheet</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'sidebar4.php'; ?>
<div class="container">
    <h1 class="text-center mt-5">Manage Gradesheet</h1>
    <table class="table table-bordered table-striped mt-3">
        <thead class="thead-dark">
        <tr>
            <th>Title</th>
            <th>PDF</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["title"]) . "</td>";
                echo "<td><a href='" . htmlspecialchars($row["pdf_path"]) . "' target='_blank'>View PDF</a></td>";
                echo "<td>
                        <a href='editgrade.php?id=" . $row["id"] . "' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='deletegrade.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm'>Delete</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4' class='text-center'>No circulars found</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
