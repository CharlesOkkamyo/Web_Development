<?php

include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $price = $_POST['price'];

    // Update the book in the database
    $sql = "UPDATE books SET title='$title', author='$author', price='$price' WHERE id=$id";

    if ($connection->query($sql) === true) {
        echo 'Book updated successfully.';
    } else {
        echo 'Error: ' . $sql . '<br>' . $connection->error;
    }
}

$id = $_GET['id'];

// Fetch the book from the database
$sql = "SELECT * FROM books WHERE id=$id";
$result = $connection->query($sql);

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
?>

<form method="post" action="">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <label>Title:</label>
    <input type="text" name="title" value="<?php echo $row['title']; ?>" required><br>
    <label>Author:</label>
    <input type="text" name="author" value="<?php echo $row['author']; ?>" required><br>
    <label>Price:</label>
    <textarea name="price" required><?php echo $row['price']; ?></textarea><br>
    <button type="submit">Update</button>
</form>

<?php
} else {
    echo 'Book not found.';
}

$connection->close();
?>

