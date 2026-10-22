<?php
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];

    $target_dir = "uploads/";
    $image = "";
    
    if (!empty($_FILES["image"]["name"])) {
        $image = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image);
    }

    $sql = "INSERT INTO blogs (title, content, image) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $title, $content, $image);
    $stmt->execute();
}

?>

<form action="admin_blog.php" method="post" enctype="multipart/form-data">
    <label>Title:</label>
    <input type="text" name="title" required><br>
    
    <label>Content:</label>
    <textarea name="content" required></textarea><br>
    
    <label>Image:</label>
    <input type="file" name="image"><br>

    <button type="submit">Publish Blog</button>
</form>
