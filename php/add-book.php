<?php
      session_start(); 
      

   
        // db connection file
        include "../conn_db.php";
        // validation helper function
        include "func_validation.php";
        // file upload helper funcion
        include "func-file-upload.php";
        // check author name sumbitted
         if(isset($_POST['book_title']) && isset($_POST['book_description']) && isset($_POST['book_author'])
                    && isset($_POST['book_category']) &&  isset($_FILES['book_cover']) &&  isset($_FILES['file']) ){
            // get data from POST request and all store the var
            $title = $_POST['book_title'];
            $description = $_POST['book_description'];
            $author = $_POST['book_author'];
            $category = $_POST['book_category'];

            // making url format
            $user_input = 'title='.$title.'$category_id='.$category.'$desc='.$description.'$author_id='.$author;
            // simple form validation
            $text = "Book Title";
            $location = "../add-book.php";
            $ms = "error";
            is_empty($title,$text,$location,$ms, $user_input);

            $text = "Book Description";
            $location = "../add-book.php";
            $ms = "error";
            is_empty($description,$text,$location,$ms, $user_input);

            $text = "Book Author";
            $location = "../add-book.php";
            $ms = "error";
            is_empty($author,$text,$location,$ms, $user_input);

            $text = "Book Category";
            $location = "../add-book.php";
            $ms = "error";
            is_empty($category,$text,$location,$ms, $user_input);

            // book cover uploading
            $allowed_image_exs = array('jpg','jpeg','png');
            $path = "cover";
            $book_cover = upload_file($_FILES['book_cover'],$allowed_image_exs,$path);

            // if error occured while uploading the book cover
            if($book_cover['status'] == "error"){
                $em= $book_cover['data'];
                // redirect to ../add-book.php and passing error message $ user_input
                header("Location:../add-book.php?error=$em&$user_input");
                exit;
            }else{
                // file uploading
                $allowed_file_exs = array('pdf','docx','pptx');
                $path = "files";
                $file = upload_file($_FILES['file'],$allowed_file_exs,$path);

                 // if error occured while uploading the file
                if($file['status'] == "error"){
                      $em= $file['data'];
                      // redirect to ../add-book.php and passing error message $ user_input
                      header("Location:../add-book.php?error=$em&$user_input");
                      exit;
                  }else{
                    //   getting the new file name and book cover name
                    $file_URL = $file['data'];
                    $book_cover_URL = $book_cover['data'];

                    // insert data in database
                    $sql = "INSERT INTO `books` (title,author_id,description,category_id,cover,file) VALUES(?,?,?,?,?,?)";
                    $stmt = $pdo->prepare($sql);
                    $res = $stmt->execute([$title, $author,$description,$category,  $book_cover_URL,  $file_URL]);
                    // if there is no error while inserting data
                    if($res){
                        $sm = "The book successfully created!";
                        header("Location:../add-book.php?success=$sm");
                        exit;
                       
                    }else{
                        $em = "Unknown Error Occured!";
                        header("Location:../add-book.php?error=$em");
                        exit;
                     }
                }

            }

           

         }else{
            header("Location:../admin.php");
            exit;
         }
   
?>