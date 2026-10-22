<?php
$servername = "localhost";
$username = "root";  // Change if needed
$password = "";      // Change if needed
$dbname = "blog_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getBlogs($limit = 10) {
    global $conn;
    $sql = "SELECT * FROM blogs ORDER BY created_at DESC LIMIT $limit";
    return $conn->query($sql);
}

function getBlog($id) {
    global $conn;
    $sql = "SELECT * FROM blogs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getComments($blog_id) {
    global $conn;
    $sql = "SELECT * FROM comments WHERE blog_id = ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $blog_id);
    $stmt->execute();
    return $stmt->get_result();
}

function addComment($blog_id, $name, $comment) {
    global $conn;
    $sql = "INSERT INTO comments (blog_id, name, comment) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $blog_id, $name, $comment);
    return $stmt->execute();
}
?>
