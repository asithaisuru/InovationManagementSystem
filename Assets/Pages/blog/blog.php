<?php
require '../db.php';

$result = $conn->query("SELECT id, title, content FROM posts ORDER BY created_at DESC");
if ($result) {
    $posts = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $posts = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Blog</h1>
        <a href="add_post.php" class="btn btn-success mb-3">Add New Post</a>
        <div class="row">
            <?php foreach ($posts as $post): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars(substr($post['content'], 0, 100)); ?>...</p>
                        <a href="view_post.php?id=<?php echo $post['id']; ?>" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
