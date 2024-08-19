<?php
   session_start();

   
   #connection db file
   include "conn_db.php";

   #book helper function
   include "php/func-books.php";
   $books = get_all_books($pdo);

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
  <title>Admin</title>
  <!-- Bootstrap css link -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <!-- Bootstrap js link-->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="admin.php">Admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php">Store</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="add-book.php">Add Book</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="add-category.php">Add Category</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="add-author.php">Add Author</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
      </ul>
    
    </div>
  </div>
</nav>
  
<form action="search.php" method="get" style="width: 100%;max-width:30rem;">
  <div class="input-group my-5">
    <input type="text" class="form-control" name="key" placeholder="Search books..." aria-label="Recipient's username" aria-describedby="basic-addon2">
    <button class="input-group-text btn btn-primary" id="basic-addon2">Search</button>
  </div>
</form>
    
<?php 
      if(isset($_GET['error'])){ ?>
       <div class="alert alert-danger" role="alert">
        <?=htmlspecialchars($_GET['error']);?>
        
    </div>
    <?php }?>

    <?php 
      if(isset($_GET['success'])){ ?>
       <div class="alert alert-success" role="alert">
        <?=htmlspecialchars($_GET['success']);?>
        
    </div>
    <?php }?>


     <?php
        if($books == 0){ ?>
            <div class="alert alert-warning text-center p-5" role="alert">
              <img src="img/empty.jpg" width="100"><br>
          There is no book in the database.
        
    </div>

       <?php }else{ ?>
      <!-- list of all books -->
     <h4 class="mt-5">All Books</h4>
     <table class="table table-borded shadow">
      <thead>
        <tr>
          <th>#</th>
          <th>Title</th>
          <th>Author</th>
          <th>Description</th>
          <th>Category</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $i =0;
        foreach($books as $book){
          $i++; ?>
         <tr>
          <td><?=$i ?> </td>
          <td>
            <img src="uploads/cover/<?=$book['cover']?>" style="width: 100%;height:200px;">
            <a class="link-dark d-block text-center" href="uploads/files/<?=$book['file']?>">
            <?=$book['title']?>
            </a>
        
          </td>
          <td>
            <?php 
            if($author == 0){
              echo "Undefined";
            }else{
              foreach($author as $auth){
                if($auth['id']==$book['author_id']){
                  echo $auth['name'];
                }
              }
            } 
            ?>
        
          </td>
          <td><?=$book['description']?></td>
          <td>
          <?php 
            if($categories == 0){
              echo "Undefined";
            }else{
              foreach($categories as $category){
                if($category['id']==$book['category_id']){
                  echo $category['name'];
                }
              }
            } 
            ?>
        </td>
          <td>
            <a href="edit-book.php?id=<?=$book['id']?>" class="btn btn-warning">Edit</a>
            <a href="php/delete-book.php?id=<?=$book['id']?>" class="btn btn-danger">Delete</a>
          </td>
         </tr>
         <?php } ?>
      </tbody>

     </table>
      
     <?php } ?>
       <?php 
       if($categories == 0){ ?>
               <div class="alert alert-warning text-center p-5" role="alert">
              <img src="img/empty.jpg" width="100"><br>
          There is no categories in the database.
        
    </div>
       <?php }else{ ?>
    

       <!-- list of all books -->
     <h4 class="mt-5">All Categories</h4>
     <table class="table table-bordered shadow">
       <thead>
        <tr>
          <th>#</th>
          <th>Categories Name</th>
          <th>Aution</th>
        </tr>
       </thead>
       <tbody>
       <?php
         $j =0;
         foreach($categories as $category){
          $j++;
          ?>
          <tr>
            <td><?=$j ?></td>
            <td><?=$category['name']?></td>
            <td>
            <a href="edit-category.php?id=<?=$category['id']?>" class="btn btn-warning">Edit</a>
            <a href="php/delete-category.php?id=<?=$category['id']?>" class="btn btn-danger">Delete</a>
            </td>

          </tr>
         <?php } ?>
        </tbody>
     </table>
     <?php } ?>
     <?php 
       if($author == 0){ ?>
               <div class="alert alert-warning text-center p-5" role="alert">
              <img src="img/empty.jpg" width="100"><br>
          There is no authors in the database.
        
    </div>
       <?php }else{ ?>
    

       <!-- list of all Authors -->
     <h4 class="mt-5">All Authors</h4>
     <table class="table table-bordered shadow">
       <thead>
        <tr>
          <th>#</th>
          <th>Author Name</th>
          <th>Aution</th>
        </tr>
       </thead>
       <tbody>
       <?php
         $k =0;
         foreach($author as $auth){
          $k++;
          ?>
          <tr>
            <td><?=$k ?></td>
            <td><?=$auth['name']?></td>
            <td>
            <a href="edit-author.php?id=<?=$auth['id']?>"  class="btn btn-warning">Edit</a>
            <a href="php/delete-author.php?id=<?=$auth['id']?>" class="btn btn-danger">Delete</a>
            </td>

          </tr>
         <?php } ?>
        </tbody>
     </table>
     <?php } ?>

    </div>
</body>
</html>



