<?php
include 'connect.php';

$id = $_GET['id'];

// Delete the book from the database
$sql = "DELETE FROM books WHERE id=$id";

if ($connection->query($sql) === true) {
    echo 'Book deleted successfully.';
} else {
    echo 'Error deleting book: ' . $connection->error;
}

$connection->close();
?>
