<?php
      session_start(); 
      

     if(True){
        // db connection file
        include "../conn_db.php";
        // check author name sumbitted
         if(isset($_GET['id'])){
            // get data from POST request and store them var
            $id = $_GET['id'];
            // simple form validation
            if(empty($id)){
                $em = "Error occured";
                header("Location:../admin.php?error=$em");
                exit;
            }else{
                //Delete the database
                $sql = "DELETE FROM `categories` WHERE id=?";
                $stmt = $pdo->prepare($sql);
                $res = $stmt->execute([$id]);
               // if there is no error while inserting data
                if($res){
                    $sm = "successfully Removed!";
                    header("Location:../admin.php?success=$sm");
                    exit;
                }else{
                    $em = "Error occured";
                    header("Location:../admin.php?error=$em");
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