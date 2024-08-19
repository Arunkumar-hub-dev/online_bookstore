<?php 
  session_start();
    

//   if not category id set
if(!isset($_GET['id'])){
    header("Location:index.php");
    exit;
}
// get category id from get request
$id = $_GET['id'];


   #connection db file
   include "conn_db.php";

   
   #book helper function
   include "php/func-books.php";
   $books = get_books_by_author($pdo,$id);


   #author helper function
    include "php/func-author.php";
    $author = get_all_author($pdo);
    $current_author =get_author($pdo,$id);


    #category helper function
     include "php/func-category.php";
     $categories =get_all_category($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $current_author['name']?></title>
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
   <h1 class="display-4 p-3 fs-3">
    <a href="index.php" class="nd">
        <img src="img/back.png" width="35">
    </a>
    <?= $current_author['name']?>

   </h1>

    <div class="d-flex pt-3">
      <?php if($books == 0){?>
        <div class="alert alert-warning text-center p-5" role="alert">
              <img src="img/empty.jpg" width="100"><br>
          There is no book in the database.
        
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
        <div class="category">
          <!-- list of category -->
           <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action active">Category</a>
            <?php 
                foreach($categories as $category){ ?>
                <a href="category.php?id=<?=$category['id']?>" class="list-group-item list-group-item-action"><?=$category['name']?></a>
            <?php } ?>
           </div>
            <!-- list of Author -->
            <div class="list-group mt-5">
            <a href="#" class="list-group-item list-group-item-action active">Authors</a>
            <?php 
                foreach($author as $auth){ ?>
                <a href="auth.php?id=<?=$auth['id']?>" class="list-group-item list-group-item-action"><?=$auth['name']?></a>
            <?php } ?>
           </div>
        </div>
    </div>
    </div>
</body>
</html>

