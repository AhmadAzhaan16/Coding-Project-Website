<?php
require_once('db.php');
$query = "SELECT * FROM projects";
$result = mysqli_query($con, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevTracker</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
        <a href="#" class="brand">DevTracker</a>
        <a href="home.html">Home</a>
        <a href="index.php">Projects</a>
        <a href="about.html">About</a>
        <a href="contact.html">Contact</a>
        <a href="create.php" class="active">Add Project</a>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Project</th>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['title']}</td>";
                    echo "<td>{$row['proj_id']}</td>";
                    echo "<td>{$row['category']}</td>";
                    echo "<td>{$row['description']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
