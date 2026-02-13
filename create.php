<?php
require_once 'db.php';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $proj_id = isset($_POST['proj_id']) ? trim($_POST['proj_id']) : '';
    $category = isset($_POST['category']) ? trim($_POST['category']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    if ($title === '') {
        $errors[] = 'Title is required.';
    }
    if ($category === '') {
        $errors[] = 'Category is required.';
    }
    if ($description === '') {
        $errors[] = 'Description is required.';
    }

    if (empty($errors)) {
        // Auto-generate proj_id if empty
        if ($proj_id === '') {
            $result = mysqli_query($con, "SELECT MAX(CAST(proj_id AS UNSIGNED)) as max_id FROM projects");
            if ($result) {
                $row = mysqli_fetch_assoc($result);
                $proj_id_param = ($row['max_id'] ?? 0) + 1;
            } else {
                $proj_id_param = 1;
            }
        } else {
            $proj_id_param = is_numeric($proj_id) ? (int)$proj_id : $proj_id;
        }

        $stmt = mysqli_prepare($con, "INSERT INTO projects (proj_id, title, category, description) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'isss', $proj_id_param, $title, $category, $description);
            if (mysqli_stmt_execute($stmt)) {
                $success = true;
            } else {
                $errors[] = 'Database insert failed: ' . mysqli_error($con);
            }
            mysqli_stmt_close($stmt);
        } else {
            $errors[] = 'Failed to prepare statement: ' . mysqli_error($con);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevTracker - Add Project</title>
    <link rel="stylesheet" href="/Coding-Project-Website/style.css">
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

    <div class="form-container">
        <h2>Add New Project</h2>

        <?php if ($success): ?>
            <div class="notice success">Project added successfully. <a href="index.php">View Projects</a></div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="notice error">
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?php echo htmlspecialchars($err); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="create.php" method="POST">
            <div class="form-group">
                <label for="title">Project Title</label>
                <input type="text" id="title" name="title" required value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>" placeholder="Enter project title">
            </div>

            <div class="form-group">
                <label for="proj_id">Project ID <span style="color: #999; font-size: 12px;">(leave empty for auto-generate)</span></label>
                <input type="text" id="proj_id" name="proj_id" value="<?php echo isset($_POST['proj_id']) ? htmlspecialchars($_POST['proj_id']) : ''; ?>" placeholder="Leave empty to auto-generate">
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" id="category" name="category" required value="<?php echo isset($_POST['category']) ? htmlspecialchars($_POST['category']) : ''; ?>" placeholder="e.g., Web Development">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" required placeholder="Describe your project..."><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
            </div>

            <input type="submit" value="Add Project">
        </form>
    </div>
</body>
</html>
