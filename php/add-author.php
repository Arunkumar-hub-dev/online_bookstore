<?php
      session_start(); 
      

   
        // db connection file
        include "../conn_db.php";
        // check author name sumbitted
         if(isset($_POST['author_name'])){
            // get data from POST request and store the var
            $name = $_POST['author_name'];
            // simple form validation
            if(empty($name)){
                $em = "The author name is required";
                header("Location:../add-author.php?error=$em");
                exit;
            }else{
                // insert the database
                $sql = "INSERT INTO `author` (name) VALUES(?)";
                $stmt = $pdo->prepare($sql);
                $res = $stmt->execute([$name]);
                // if there is no error while inserting data
                if($res){
                    $sm = "successfully created!";
                    header("Location:../add-author.php?success=$sm");
                    exit;
                   
                }else{
                    $em = "Unknown Error Occured!";
                    header("Location:../add-author.php?error=$em");
                    exit;
                 }
            }

         }else{
            header("Location:../admin.php");
            exit;
         }
   
?>