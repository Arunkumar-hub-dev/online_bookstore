<?php
      session_start(); 
      

     if(True){
        // db connection file
        include "../conn_db.php";
        // check author name sumbitted
         if(isset($_POST['category_name']) && isset($_POST['category_id'])){
            // get data from POST request and store them var
            $name = $_POST['category_name'];
            $id = $_POST['category_id'];
            // simple form validation
            if(empty($name)){
                $em = "The category name is required";
                header("Location:../edit-category.php?error=$em&id=$id");
                exit;
            }else{
                // insert the database
                $sql = "UPDATE `categories` SET name=? WHERE id=?";
                $stmt = $pdo->prepare($sql);
                $res = $stmt->execute([$name,$id]);
                // if there is no error while inserting data
                if($res){
                    $sm = "successfully Updated!";
                    header("Location:../edit-category.php?success=$sm&id=$id");
                    exit;
                   
                }else{
                    $em = "Unknown Error Occured!";
                    header("Location:../edit-category.php?error=$em&id=$id");
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