<?php

require_once 'db.php';

session_start();


if (isset($_SESSION['LAST_ACTIVITY']) &&
   (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {

    session_unset();
    session_destroy();
}

$_SESSION['LAST_ACTIVITY'] = time();


function db(){
    global $mysqli;
    return $mysqli;
}


function db_prepare_execute($query, $types='', $params=[]){

    global $mysqli;

    $stmt = $mysqli->prepare($query);

    if(!$stmt){
        throw new Exception("Prepare Failed: ".$mysqli->error);
    }

    if(!empty($types) && !empty($params)){
        $stmt->bind_param($types, ...$params);
    }

    if(!$stmt->execute()){
        throw new Exception("Execute Failed: ".$stmt->error);
    }

    return $stmt;
}


function sanitize_string($str){
    return htmlspecialchars(trim($str));
}
function is_logged_in(){
    return isset($_SESSION['user_id']);
}

function is_admin(){
    return isset($_SESSION['role']) &&
           $_SESSION['role'] === 'admin';
}


function handle_file_upload($field, $folder='uploads'){

    if(!isset($_FILES[$field])){
        return null;
    }

    $file = $_FILES[$field];

    if($file['error'] !== 0){
        return null;
    }

    if(!is_dir($folder)){
        mkdir($folder, 0777, true);
    }

    $filename = time().'_'.$file['name'];

    move_uploaded_file(
        $file['tmp_name'],
        $folder.'/'.$filename
    );

    return $filename;
}

?>