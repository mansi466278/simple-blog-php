<?php
// view_post.php
require_once 'db_connect.php';

$post = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT id, title, content, author, created_at FROM posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
    }
    $stmt->close();
}
$conn->close();

if (!$post) {
    // Redirect or show error if post not found
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> - Simple Blog</title>
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
        <h1 class="mb-4"><?php echo htmlspecialchars($post['title']); ?></h1>
        <p class="text-muted">By <?php echo htmlspecialchars($post['author']); ?> on <?php echo date("F j, Y", strtotime($post['created_at'])); ?></p>
        <div class="card card-body mb-4">
            <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
        </div>
        <a href="index.php" class="btn btn-secondary">Back to Posts</a>
        <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn btn-outline-secondary">Edit Post</a>
        <a href="delete_post.php?id=<?php echo $post['id']; ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this post?');">Delete Post</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eJBz1/vQ/y" crossorigin="anonymous"></script>
</body>
</html>