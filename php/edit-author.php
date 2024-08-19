<?php
      session_start(); 
      

     if(True){
        // db connection file
        include "../conn_db.php";
        // check author name sumbitted
         if(isset($_POST['author_name']) && isset($_POST['author_id'])){
            // get data from POST request and store them var
            $name = $_POST['author_name'];
            $id = $_POST['author_id'];
            // simple form validation
            if(empty($name)){
                $em = "The category name is required";
                header("Location:../edit-author.php?error=$em&id=$id");
                exit;
            }else{
                // insert the database
                $sql = "UPDATE `author` SET name=? WHERE id=?";
                $stmt = $pdo->prepare($sql);
                $res = $stmt->execute([$name,$id]);
                // if there is no error while inserting data
                if($res){
                    $sm = "successfully Updated!";
                    header("Location:../edit-author.php?success=$sm&id=$id");
                    exit;
                   
                }else{
                    $em = "Unknown Error Occured!";
                    header("Location:../edit-author.php?error=$em&id=$id");
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