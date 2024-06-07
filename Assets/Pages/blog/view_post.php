<?php
require '../db.php';

$post_id = $_GET['id'] ?? 0;

if ($conn) {
    $stmt = $conn->prepare("SELECT title, content FROM posts WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $post = $result->fetch_assoc();
        $stmt->close();
    } else {
        $post = ['title' => 'Database Error', 'content' => 'Failed to prepare the statement.'];
    }
} else {
    $post = ['title' => 'Database Error', 'content' => 'Failed to connect to the database.'];
}

if (!$post) {
    $post = ['title' => 'Post Not Found', 'content' => 'The post you are looking for does not exist.'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <h1><?php echo htmlspecialchars($post['title']); ?></h1>
        <p><?php echo htmlspecialchars($post['content']); ?></p>
        <a href="blog.php" class="btn btn-secondary">Back to Blog</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
