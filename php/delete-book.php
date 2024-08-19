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
                // get book from database
                $sql2 = "SELECT * FROM `books` WHERE id=?";
                $stmt2 = $pdo->prepare($sql2);
                $stmt2->execute([$id]);
                $the_book = $stmt2->fetch();

                if($stmt2->rowCount()>0){
                      //Delete the database
                        $sql = "DELETE FROM `books` WHERE id=?";
                        $stmt = $pdo->prepare($sql);
                        $res = $stmt->execute([$id]);
                        // if there is no error while inserting data
                        if($res){
                            $cover = $the_book['cover'];
                            $file = $the_book['file'];
                            $c_b_c = "../uploads/cover/$cover";
                            $c_f= "../uploads/files/$file";
                            unlink($c_b_c);
                            unlink($c_f);


                            $sm = "successfully Removed!";
                            header("Location:../admin.php?success=$sm");
                            exit;
                        
                        }else{
                            $em = "Unknown Error Occured!";
                            header("Location:../admin.php?error=$em");
                            exit;
                        }

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