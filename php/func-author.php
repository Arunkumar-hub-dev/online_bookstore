<?php
//    Get all author function
function get_all_author($pdo){
    $sql = "SELECT * FROM `author`";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    if($stmt->rowCount()>0){
        $author = $stmt->fetchAll();
    }else{
        $author = 0;
    }
    return $author;
}
// get author by id function
function get_author($pdo,$id){
    $sql = "SELECT * FROM `author` WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    if($stmt->rowCount()>0){
        $auth = $stmt->fetch();
    }else{
        $auth = 0;
    }
    return $auth;
}
?>