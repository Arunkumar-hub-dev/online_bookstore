<?php 
  session_start();

//   if search key set or not
if(!isset($_GET['key']) || (empty($_GET['key']))){
    header("Location:index.php");
    exit;
}
  $key = $_GET['key'];

   #connection db file
   include "conn_db.php";

   #book helper function
   include "php/func-books.php";
   $books = search_books($pdo,$key);

   #author helper function
    include "php/func-author.php";
    $author = get_all_author($pdo);

    #category helper function
     include "php/func-category.php";
     $categories =get_all_category($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Store</title>
  <!-- Bootstrap css link -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <!-- Bootstrap js link-->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Online Book Store</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Store</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
            <?php
                $_SESSION['user_id'] = 1;
                if(isset($_SESSION['user_id'])){
                    ?>
                    <a class="nav-link" href="admin.php">Admin</a>
             <?php   }else{?>
        
          <a class="nav-link" href="login.php">Login</a>
          <?php } ?>
        </li>
      </ul>
    
    </div>
  </div>
</nav>
    Search for result <b><?=$key?></b>

    <div class="d-flex pt-3">
      <?php if($books == 0){?>
        <div class="alert alert-warning text-center p-5 pdf-list" role="alert">
              <img src="img/emty.png" width="100"><br>
          The key <b>"<?=$key ?>"</b> no book in the database.
        
    </div>
        <?php }else{ ?>
        <div class="pdf-list d-flex flex-wrap">
          <?php  foreach($books as $book){ ?>
            
          <div class="card m-1">
            <img src="uploads/cover/<?=$book['cover']?>" class="card-img-top" >
            <div class="carf-body">
              <h5 class="card-title">
              <?=$book['title']?>
             </h5>
             <p class="card-text">
              <i><b>By:
                <?php foreach($author as $auth){
                  if($auth['id'] == $book['author_id']){
                       echo $auth['name'];
                  }
                  ?>
                
                <?php } ?>

              <br></b></i>
             <?=$book['description']?><br>
             <i><b>Category:
                <?php foreach($categories as $category){
                  if($category['id'] == $book['category_id']){
                       echo $category['name'];
                  }
                  ?>
                
                <?php } ?>

              <br></b></i>

             </p>
             <a href="uploads/files/<?=$book['file']?>" class="btn btn-success">Open</a>
             <a href="uploads/files/<?=$book['file']?>" class="btn btn-primary" download="<?=$book['file']?>">Download</a>
            </div>

          </div>
          <?php } ?>

        </div>
        <?php } ?>
    </div>
    </div>
</body>
</html>

