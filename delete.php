<?php
include 'config.php';
include 'edit.php';

$id = $_GET['id'];

// Delete the book from the database
$sql = "DELETE FROM books WHERE id=$id";

if ($conn->query($sql) === true) {
    echo 'Book deleted successfully.';
} else {
    echo 'Error deleting book: ' . $conn->error;
}

$conn->close();
?>
?>