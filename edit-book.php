<?php
   session_start();

   if(!isset($_GET['id'])){
    header("Location:admin.php");
    exit;
   }
   $id = $_GET['id'];
   #connection db file
   include "conn_db.php";

    #book helper function
    include "php/func-books.php";
    $book =get_book($pdo,$id);

    // if id is invalid 
    if($book== 0){
        header("Location:admin.php");
        exit;

    }

   #category helper function
   include "php/func-category.php";
   $categories =get_all_category($pdo);

   #author helper function
    include "php/func-author.php";
    $author = get_all_author($pdo);

    // $desc = isset($_GET['desc']) ? $_GET['desc'] : '';
    // $desc = isset($_GET['desc'])  ?? '';
  //   if (isset($_GET['desc'])) {
  //     $desc = $_GET['desc'];
  // } else {
  //     $desc = '';
  // }
  
  

   

?>





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Book</title>
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
          <a class="nav-link " href="add-author.php">Add Author</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
      </ul>
    
    </div>
  </div>
</nav>
    <form action="php/edit-book.php" method="post" class="shadow p-4 rounded mt-5" style="width:90%;max-width:50rem;" enctype="multipart/form-data">
        <h4 class="text-center pb-5 display-4 fs-3">Edit Book</h4>
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
        <div class="mb-3">
            <label class="form-label">Book Title</label>
            <input type="text" hidden  name="book_id" value="<?=$book['id']?>">
            <input type="text" class="form-control"  name="book_title" value="<?=$book['title']?>">
       </div>
       <div class="mb-3">
            <label class="form-label">Book Description</label>
            <input type="text" class="form-control"  name="book_description" value="<?=$book['description']?>" >
       </div>
       <div class="mb-3">
            <label class="form-label">Book Author</label>
            <select name="book_author" class="form-control">
                <option selected value="0">Select author</option>
                <?php
                  if( $author == 0){

                  }else{
                    foreach($author as $auth){
                      if($book['author_id'] == $auth['id']){
                        ?>
                        <option selected value="<?=$auth['id']?>"><?=$auth['name']?></option>
                        <?php }else{ ?>
                          <option value="<?=$auth['id']?>"><?=$auth['name']?></option>
                <?php }}} ?>
              
                    
          

            </select>
       </div>
       <div class="mb-3">
            <label class="form-label">Book Category</label>
            <select name="book_category" class="form-control">
                <option selected  value="0">Select category</option>
                <?php
                  if($categories == 0){

                  }else{
                    foreach($categories as $category){
                      if($book['category_id'] == $category['id']){
                        ?>
                        <option selected value="<?=$category['id']?>"><?=$category['name']?></option>
                        <?php }else{ ?>
                          <option value="<?=$category['id']?>"><?=$category['name']?></option>
                    <?php }}} ?>
               
          

            </select>
       </div>
       <div class="mb-3">
            <label class="form-label">Book Cover</label>
            <input type="file" class="form-control" name="book_cover">
            <input type="text" hidden  name="current_cover" value="<?=$book['cover']?>">
            <a href="uploads/cover/<?=$book['cover']?>" class="link-dark">Current Cover</a>
       </div>
       <div class="mb-3">
            <label class="form-label"> File</label>
            <input type="file" class="form-control" name="file">
            <input type="text" hidden  name="current_file" value="<?=$book['file']?>">
            <a href="uploads/files/<?=$book['file']?>" class="link-dark">Current File</a>
       </div>
       <button type="submit" class="btn btn-primary">Update</button>
    </form>

    </div>
</body>
</html>



