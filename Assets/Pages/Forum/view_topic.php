<?php
// Mock data for demonstration purposes. Replace with database fetching logic.
$topic_id = $_GET['id'] ?? 1;  // Assuming topic ID is passed via GET parameter
$topics = [
    1 => ['title' => 'First Topic', 'content' => 'This is the content of the first topic.'],
    2 => ['title' => 'Second Topic', 'content' => 'This is the content of the second topic.']
];
$topic = $topics[$topic_id] ?? ['title' => 'Topic Not Found', 'content' => 'The topic you are looking for does not exist.'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($topic['title']); ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <h1><?php echo htmlspecialchars($topic['title']); ?></h1>
        <p><?php echo htmlspecialchars($topic['content']); ?></p>
        <a href="forum.php" class="btn btn-secondary">Back to Forum</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
