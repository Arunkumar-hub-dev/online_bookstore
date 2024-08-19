<?php
      session_start(); 
      

     if(True){
        // db connection file
        include "../conn_db.php";
        // check author name sumbitted
         if(isset($_POST['category_name'])){
            // get data from POST request and store the var
            $name = $_POST['category_name'];
            // simple form validation
            if(empty($name)){
                $em = "The category name is required";
                header("Location:../add-category.php?error=$em");
                exit;
            }else{
                // insert the database
                $sql = "INSERT INTO `categories` (name) VALUES(?)";
                $stmt = $pdo->prepare($sql);
                $res = $stmt->execute([$name]);
                // if there is no error while inserting data
                if($res){
                    $sm = "successfully created!";
                    header("Location:../add-category.php?success=$sm");
                    exit;
                   
                }else{
                    $em = "Unknown Error Occured!";
                    header("Location:../add-category.php?error=$em");
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