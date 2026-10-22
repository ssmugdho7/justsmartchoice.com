<?php
include 'functions.php';

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    die("Invalid post.");
}

$post_id = intval($_GET["id"]);
$blog = getBlog($post_id);

if (!$blog) {
    die("Post not found.");
}

// Handle comment submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"], $_POST["comment"])) {
    $name = htmlspecialchars(trim($_POST["name"])); // Sanitize input
    $comment = htmlspecialchars(trim($_POST["comment"]));

    if (!empty($name) && !empty($comment)) {
        addComment($post_id, $name, $comment);
        header("Location: post.php?id=" . $post_id); // Prevent form resubmission
        exit();
    } else {
        echo "<p style='color:red;'>Both fields are required.</p>";
    }
}

$comments = getComments($post_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($blog["title"]); ?> | Blog</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Link your styles -->
</head>
<body>

    <h2><?php echo htmlspecialchars($blog["title"]); ?></h2>

    <?php if (!empty($blog["image"])) : ?>
        <img src="<?php echo htmlspecialchars($blog["image"]); ?>" alt="Blog Image" width="600">
    <?php endif; ?>

    <p><?php echo nl2br(htmlspecialchars($blog["content"])); ?></p>

    <hr>

    <h3>Leave a Comment</h3>
    <form action="post.php?id=<?php echo $post_id; ?>" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="comment">Comment:</label>
        <textarea id="comment" name="comment" required></textarea><br>

        <button type="submit">Submit</button>
    </form>

    <hr>

    <h3>Comments</h3>
    <ul>
        <?php while ($comment = $comments->fetch_assoc()) : ?>
            <li><strong><?php echo htmlspecialchars($comment["name"]); ?>:</strong> <?php echo nl2br(htmlspecialchars($comment["comment"])); ?></li>
        <?php endwhile; ?>
    </ul>

</body>
</html>
