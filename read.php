<?php
include 'connect.php';
$sql= "SELECT * FROM books";
$result=$conn-> query($sql);

if ($result->num_rows>0){
    while ($row =$result->fetch_assoc()){

        echo "ID" . $row["ID"] . "Name: ". $row["name"] . "Author name:" . $row["author_name"] . "Price:" . $row["price"]."<br>";

    }
}
?>