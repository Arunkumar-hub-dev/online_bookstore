<?php
   
   if (isset($_POST['email']) && (isset($_POST['password']))){
    // database connection file
    include "../conn_db.php";

    // validation helper function
    include "func_validation.php";

    // Get data from post request and store them var
    $email = $_POST['email'];
    $password = $_POST['password'];

    // simple form validation
    $text = "Email";
    $location = "../login.php";
    $ms = "error";
    is_empty($email,$text,$location,$ms,"");

    $text = "Password";
    $location = "../login.php";
    $ms = "error";
    is_empty($password,$text,$location,$ms,"");

    // search for email
    $sql = "SELECT * FROM `admin` WHERE email=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);

    // if the email is exit
    if($stmt->rowCount() === 1){
        $user = $stmt->fetch();


        $user_id = $user['id'];
        $user_email = $user['email'];
        $user_password = $user['password'];
        if($email === $user_email){
            if(password_verify($password,$user_password)){
                echo $user_email;
                 $_SESSION['user_id']=$user_id;
                 $_SESSION['user_email']=$user_email;
                 header("location:../admin.php");
            }else{
                // error message
                $em = "Incorrect Username or Password";
                header("Location:../login.php?error=$em");
            }
        }else{
              // error message
             $em = "Incorrect Username or Password";
             header("Location:../login.php?error=$em");
        }

    }else{
        // error message
        $em = "Incorrect Username or Password";
        header("Location:../login.php?error=$em");
        // echo "Nope";
    }

   }else{
    header("Location:../login.php");
   }
?>


