<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>PHP CRUD Application</title>
  </head>

  <body>
    <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: #ADD8E6;">
      Index
    </nav>
    
  </body>
  <div class="container">
    <table class="table table-hover text-center">
              <thead class="table-dark">
                  <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Name</th>
                  <th scope="col">Author Name</th>
                  <th scope="col">Price</th>
                  </tr>
              </thead>
      <tbody>
          <?php
          include 'connect.php';
          $sql= "SELECT * FROM books";
          $result=$conn-> query($sql);

          if ($result->num_rows>0){
              while ($row =$result->fetch_assoc()){

                  echo "<tr>";
                  echo "<td>" . $row['id'] . "</td>";
                  echo "<td>" . $row['title'] . "</td>";
                  echo "<td>" . $row['name'] . "</td>";
                  echo "<td>" . $row['price'] . "</td>";
                  echo "</tr>";
                  echo'a href="edit.php?id=' . $row["ID"] . '"Edit</a> |';
                  echo 'a href="delete.php?id=' . $row["ID"] . '"Delete</a> |';
              }

          }else{
              echo"<tr><td colspan='3'>No Book Found.</td></tr>";
          } ?>
      </tbody>
    </table>
  </div>
</html> 
