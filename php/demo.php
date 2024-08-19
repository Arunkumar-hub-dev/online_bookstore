/*
 <?php
   session_start(); 

   if(isset($_SESSION['user_id']) && isset($_SESSION['user_email'])){
     header("Location:admin.php");

}else{ 
 header("Location:login.php");
 exit;
} 
?>
  */

  <?php
   session_start();
   #connection db file
   include "conn_db.php";

   #book helper function
   include "php/func-books.php";
   $books = get_all_books($pdo);

   #author id function
    include "php/func-author.php";
    $author = get_all_author($pdo);

    #author id function
     include "php/func-category.php";
     $categories =get_all_category($pdo);

     if( $author == 0){

     }else{
       foreach($author as $auth){
         if($author_id == $auth['id']){
           ?>
           <option selected value="<?=$auth['id']?>"><?=$auth['name']?></option>
           <?php }else{ ?>
             <option value="<?=$auth['id']?>"><?=$auth['name']?></option>
             <?php }}} ?>
       
     
     
     </select>

     <?php
                  if( $author == 0){

                  }else{
                    foreach($author as $auth){
                      if($author_id == $auth['id']){
                        ?>
                        <option selected value="<?=$auth['id']?>"><?=$auth['name']?></option>
                        <?php }else{ ?>
                          <option value="<?=$auth['id']?>"><?=$auth['name']?></option>
                <?php }}} ?>


                <?php
                  if($categories == 0){

                  }else{
                    foreach($categories as $category){
                      if($category_id == $category['id']){
                        ?>
                        <option selected value="<?=$category['id']?>"><?=$category['name']?></option>
                        <?php }else{ ?>
                          <option value="<?=$category['id']?>"><?=$category['name']?></option>
                          <?php }}} ?>

                          if(isset($_GET['title'])){
      $title = $_GET['title'];
    }else $title = '';

    if(isset($_GET['desc'])){
      $desc = $_GET['desc'];
    }else{
      $desc = '';
    }


                          
    if(isset($_GET['category_id'])){
      $category_id = $_GET['category_id'];
    }else{
      $category_id = 0;
    }

    if(isset($_GET['author_id'])){
      $author_id = $_GET['author_id'];
    }else{
      $author_id = 0;
    }

?>
