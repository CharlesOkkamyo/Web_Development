<?php

//include '      ';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $description = $_POST['description'];

    // Update the book in the database
    $sql = "UPDATE books SET title='$title', author='$author', description='$description', updated_at=NOW() WHERE id=$id";

    if ($conn->query($sql) === true) {
        echo 'Book updated successfully.';
    } else {
        echo 'Error: ' . $sql . '<br>' . $conn->error;
    }
}

$id = $_GET['id'];

// Fetch the book from the database
$sql = "SELECT * FROM books WHERE id=$id";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
?>

<form method="post" action="">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <label>Title:</label>
    <input type="text" name="title" value="<?php echo $row['title']; ?>" required><br>
    <label>Author:</label>
    <input type="text" name="author" value="<?php echo $row['author']; ?>" required><br>
    <label>Description:</label>
    <textarea name="description" required><?php echo $row['description']; ?></textarea><br>
    <button type="submit">Update</button>
</form>

<?php
} else {
    echo 'Book not found.';
}

$conn->close();
?>

