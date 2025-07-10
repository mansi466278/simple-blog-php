<?php
// index.php
require_once 'db_connect.php';

// Fetch all posts from the database (we'll filter them with JS later)
$sql = "SELECT id, title, SUBSTRING(content, 1, 150) AS short_content, author, created_at FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);

$posts = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .post-card {
            height: 100%; /* Ensure all cards in a row have equal height */
            display: flex;
            flex-direction: column;
        }
        .post-card .card-body {
            flex-grow: 1; /* Make card body take available space */
            display: flex;
            flex-direction: column;
        }
        .post-card .card-text {
            flex-grow: 1; /* Push buttons to the bottom */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">My Simple Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_post.php">Add New Post</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search posts..." aria-label="Search" id="postSearchInput">
                    <button class="btn btn-outline-light" type="submit" onclick="event.preventDefault();">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4">Latest Posts</h1>

        <div id="postsContainer" class="row">
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="col-md-4 col-sm-6 mb-4 post-item"> <div class="card post-card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><a href="view_post.php?id=<?php echo $post['id']; ?>" class="text-decoration-none text-primary"><?php echo htmlspecialchars($post['title']); ?></a></h5>
                            <h6 class="card-subtitle mb-2 text-muted">By <?php echo htmlspecialchars($post['author']); ?> on <?php echo date("F j, Y", strtotime($post['created_at'])); ?></h6>
                            <p class="card-text text-secondary"><?php echo htmlspecialchars($post['short_content']); ?>...</p>
                            <div class="mt-auto"> <a href="view_post.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-info text-white">Read More</a>
                                <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                                <a href="delete_post.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    No posts found. Why not add one?
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eJBz1/vQ/y" crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</html>