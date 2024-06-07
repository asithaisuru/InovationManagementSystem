<?php
require '../db.php';

$topic_id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT title, content FROM topics WHERE id = ?");
$stmt->bind_param("i", $topic_id);
$stmt->execute();
$result = $stmt->get_result();
$topic = $result->fetch_assoc();
$stmt->close();

if (!$topic) {
    $topic = ['title' => 'Topic Not Found', 'content' => 'The topic you are looking for does not exist.'];
}
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
