<?php
      session_start(); 
      

     if(True){
        // db connection file
        include "../conn_db.php";
         // validation helper function
         include "func_validation.php";
         // file upload helper funcion
         include "func-file-upload.php";
        // check author name sumbitted
         if(isset($_POST['book_id']) && isset($_POST['book_title'])  && isset($_POST['book_description']) && isset($_POST['book_author'])
         && isset($_POST['book_category']) &&  isset($_FILES['book_cover']) &&  isset($_FILES['file']) &&  isset($_POST['current_cover']) &&  isset($_POST['current_file'])){
            // get data from POST request and store them var
            $id = $_POST['book_id'];
            $title = $_POST['book_title'];
            $description = $_POST['book_description'];
            $author = $_POST['book_author'];
            $category = $_POST['book_category'];

            $current_cover = $_POST['current_cover'];
            $current_file  = $_POST['current_file'];
             // simple form validation
             $text = "Book Title";
             $location = "../edit-book.php";
             $ms = "id=$id&error";
             is_empty($title,$text,$location,$ms,"");
 
             $text = "Book Description";
             $location = "../edit-book.php";
             $ms = "id=$id&error";;
             is_empty($description,$text,$location,$ms, "");
 
             $text = "Book Author";
             $location = "../edit-book.php";
             $ms = "id=$id&error";;
             is_empty($author,$text,$location,$ms,"");
 
             $text = "Book Category";
             $location = "../edit-book.php";
             $ms = "id=$id&error";;
             is_empty($category,$text,$location,$ms,"");

            if(!empty($_FILES['book_cover']['name'])){
                if(!empty($_FILES['file']['name'])){
                    // update both here
                    // book cover uploading
                    $allowed_image_exs = array('jpg','jpeg','png');
                    $path = "cover";
                    $book_cover = upload_file($_FILES['book_cover'],$allowed_image_exs,$path);

                    // book cover uploading
                    $allowed_file_exs = array('pdf','docx','pptx');
                    $path = "file";
                    $file = upload_file($_FILES['file'],$allowed_file_exs,$path);

                    if($book_cover['status'] == "error" || $file['status'] == "error") {
                        $em= $book_cover['data'];
                        // redirect to ../add-book.php and passing error message $ user_input
                        header("Location:../edit-book.php?error=$em&id=$id");
                        exit;
                    }else{
                        // current book cover path
                        $c_p_book_cover = "uploads/cover/$current_cover";

                         // current files path
                         $c_p_file = "uploads/files/$current_file";

                        //  delete from server both
                        unlink( $c_p_book_cover);
                        echo unlink( $c_p_file);

                         //   getting the new file name and book cover name
                        $file_URL = $file['data'];
                        $book_cover_URL = $book_cover['data'];

                         // update the just data
                        $sql = "UPDATE books SET title=?,author_id=?,`description`=?,category_id=?,cover=?,`file`=? WHERE id=?";
                        $stmt = $pdo->prepare($sql);
                        $res = $stmt->execute([$title, $author,$description,$category,$book_cover_URL, $file_URL,$id]);

                        // if there is no error while inserting data
                        if($res){
                            $sm = " successfully Updated!";
                            header("Location:../edit-book.php?success=$sm&id=$id");
                            exit;
                        
                        }else{
                            $em = "Unknown Error Occured!";
                            header("Location:../edit-book.php?error=$em&id=$id");
                            exit;
                        }

                    }
                

                }else{
                    // update just the book here
                      // book cover uploading
                      $allowed_image_exs = array('jpg','jpeg','png');
                      $path = "cover";
                      $book_cover = upload_file($_FILES['book_cover'],$allowed_image_exs,$path);
  
  
                      if($book_cover['status'] == "error") {
                          $em= $book_cover['data'];
                          // redirect to ../add-book.php and passing error message $ user_input
                          header("Location:../edit-book.php?error=$em&id=$id");
                          exit;
                      }else{
                          // current book cover path
                          $c_p_book_cover = "uploads/cover/$current_cover";
  
                          //  delete from server both
                          unlink( $c_p_book_cover);
  
                           //   getting the new file name and book cover name
                          $book_cover_URL = $book_cover['data'];
  
                           // update the just data
                          $sql = "UPDATE books SET title=?,author_id=?,`description`=?,category_id=?,cover=? WHERE id=?";
                          $stmt = $pdo->prepare($sql);
                          $res = $stmt->execute([$title, $author,$description,$category,$book_cover_URL,$id]);
  
                          // if there is no error while inserting data
                          if($res){
                              $sm = " successfully Updated!";
                              header("Location:../edit-book.php?success=$sm&id=$id");
                              exit;
                          
                          }else{
                              $em = "Unknown Error Occured!";
                              header("Location:../edit-book.php?error=$em&id=$id");
                              exit;
                          }
  
                      }

                }
            }else if(!empty($_FILES['file']['name'])){
                // update just the file
                  // book cover uploading
                  $allowed_file_exs = array('pdf','docx','pptx');
                  $path = "files";
                  $file = upload_file($_FILES['file'],$allowed_file_exs,$path);


                  if($file['status'] == "error") {
                      $em= $file['data'];
                      // redirect to ../add-book.php and passing error message $ user_input
                      header("Location:../edit-book.php?error=$em&id=$id");
                      exit;
                  }else{
                      // current book cover path
                      $c_p_file = "uploads/files/$current_file";

                      //  delete from server both
                      unlink($c_p_file);

                       //   getting the new file name and book cover name
                      $file_URL = $file['data'];

                       // update the just data
                      $sql = "UPDATE books SET title=?,author_id=?,`description`=?,category_id=?,file=? WHERE id=?";
                      $stmt = $pdo->prepare($sql);
                      $res = $stmt->execute([$title, $author,$description,$category, $file_URL,$id]);

                      // if there is no error while inserting data
                      if($res){
                          $sm = " successfully Updated!";
                          header("Location:../edit-book.php?success=$sm&id=$id");
                          exit;
                      
                      }else{
                          $em = "Unknown Error Occured!";
                          header("Location:../edit-book.php?error=$em&id=$id");
                          exit;
                      }

                  }

            

            }else{
                // update the just data
                $sql = "UPDATE `books` SET title=?,author_id=?,description=?,category_id=? WHERE id=?";
                $stmt = $pdo->prepare($sql);
                $res = $stmt->execute([$title, $author,$description,$category,$id]);

                 // if there is no error while inserting data
                 if($res){
                    $sm = " successfully Updated!";
                    header("Location:../edit-book.php?success=$sm&id=$id");
                    exit;
                   
                }else{
                    $em = "Unknown Error Occured!";
                    header("Location:../edit-book.php?error=$em&id=$id");
                    exit;
                 }
            }
         }else{
            header("Location:../admin.php");
            exit;
         }
        }else{
            header("location:../login.php");
            exit;
        }
   
?>