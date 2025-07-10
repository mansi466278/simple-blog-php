<?php
// edit_post.php
require_once 'db_connect.php';

$post = null;
$message = '';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    // Fetch existing post data
    $stmt = $conn->prepare("SELECT id, title, content, author FROM posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
    }
    $stmt->close();
}

if (!$post) {
    header("Location: index.php"); // Redirect if post not found
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id']; // Hidden input from form
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $author = trim($_POST['author']);

    if (empty($title) || empty($content) || empty($author)) {
        $message = '<div class="alert alert-danger" role="alert">All fields are required!</div>';
    } else {
        $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ?, author = ? WHERE id = ?");
        $stmt->bind_param("sssi", $title, $content, $author, $id); // "sssi" for three strings and one integer

        if ($stmt->execute()) {
            $message = '<div class="alert alert-success" role="alert">Post updated successfully!</div>';
            // Update the $post array to reflect changes immediately
            $post['title'] = $title;
            $post['content'] = $content;
            $post['author'] = $author;
        } else {
            $message = '<div class="alert alert-danger" role="alert">Error: ' . $stmt->error . '</div>';
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post - Simple Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">My Simple Blog</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="add_post.php">Add New Post</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4">Edit Post</h1>
        <?php echo $message; ?>
        <form action="edit_post.php?id=<?php echo $post['id']; ?>" method="POST">
            <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($title ?? ''); ?>" required>
                <div class="invalid-feedback">
                    Please provide a title.
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="10" required><?php echo htmlspecialchars($content ?? ''); ?></textarea>
                <div class="invalid-feedback">
                    Content cannot be empty.
                </div>
                <div class="valid-feedback">
                    Content looks good!
                </div>
            </div>
            <div class="mb-3">
                <label for="author" class="form-label">Author</label>
                <input type="text" class="form-control" id="author" name="author" value="<?php echo htmlspecialchars($author ?? ''); ?>" required>
                <div class="invalid-feedback">
                    Please provide an author.
                </div>
                <div class="valid-feedback">
                    Author looks good!
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Post</button>
            <a href="view_post.php?id=<?php echo $post['id']; ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eJBz1/vQ/y" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>