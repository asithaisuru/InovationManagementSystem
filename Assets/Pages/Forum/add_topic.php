<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the form submission and save the topic to the database
    $title = $_POST['title'];
    $content = $_POST['content'];
    // Insert into database code here
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Topic</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Add New Topic</h1>
        <form method="POST" action="">
            <div class="mb-3">
