<?php
include 'connect.php';
$sql= "SELECT * FROM books";
$result=$connection-> query($sql);


if ($result->num_rows>0){
    while ($row =$result->fetch_assoc()){

    echo "ID" . $row["id"] . "Title: ". $row["title"] . "Author name:" . $row["author"] . "Price:" . $row["price"]."";
    echo '<a href="edit.php?id=' . $row['id'] . '">Edit</a> | <a href="delete.php?id=' . $row['id'] . '">Delete</a><br>';

       
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $price = $_POST['price'];

    // Insert the new book into the database
    $sql = "INSERT INTO books (title, author, price) 
            VALUES ('$title', '$author', '$price')";

    if ($connection->query($sql) === TRUE) {
        echo 'Book created successfully.';
    } else {
        echo 'Error: ' . $sql . '<br>' . $connection->error;
    }
}

?>

<form method="POST" action="">
    <label>Title:</label>
    <input type="text" name="title"  required><br>
    <label>Author:</label>
    <input type="text" name="author"  required><br>
    <label>Price:</label>
    <input type="text" name="price" required><br>
    
    <button type="submit" value="Create book">Create</button>
</form>

