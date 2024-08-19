<?php

//    file upload helper function
function upload_file($files,$allowed_exs,$path) {
    // get data and store them in var
    $file_name = $files['name'];
    $tmp_name = $files['tmp_name'];
    $error  = $files['error'];
    
    // if there is no error occured while uploading
    if($error == 0){
        // get file extension store it in var
        $file_ex = pathinfo($file_name,PATHINFO_EXTENSION);
        // convert the file extension into lower case and it in var
        $file_ex_lc = strtolower($file_ex);

        // check if the file extension exist in $allowed_exs array
        if(in_array($file_ex_lc,$allowed_exs)){
            // remaing the file with random strings
            $new_file_name = uniqid("",true).'.'.$file_ex_lc;

            // assigning upload path
            $file_upload_path = '../uploads/'.$path.'/'.$new_file_name;
            // $file_upload_path ="../uploads/".$path."/".$file_name;

            // moving uploaded file to root directory upload $path folder
            move_uploaded_file($tmp_name,$file_upload_path);

              // creating a success message associative array with named keys status and data
              $sm['status'] = 'success';
              $sm['data'] = $new_file_name;
         
              // return em array 
               return $sm;


        }else{
             // creating a error message associative array with named keys status and data
             $em['status'] = 'error';
             $em['data'] = "You can't upload files of the type!";
        
             // return em array 
              return $em;

        }

    }else{
        // creating a error message associative array with named keys status and data
        $em['status'] = 'error';
        $em['data'] = 'Error occured while uploading!';
        
        // return em array 
        return $em;
    }
}
?>