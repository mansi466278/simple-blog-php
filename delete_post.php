<?php
// delete_post.php
require_once 'db_connect.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute delete statement
    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->bind_param("i", $id); // "i" for integer parameter

    if ($stmt->execute()) {
        // Redirect to homepage after successful deletion
        header("Location: index.php?status=deleted");
        exit();
    } else {
        // Handle error (e.g., redirect with an error message)
        header("Location: index.php?status=delete_failed");
        exit();
    }
    $stmt->close();
} else {
    // Redirect if no valid ID provided
    header("Location: index.php");
    exit();
}
$conn->close();
?>