<?php 
require_once './config/dbConfig.php';
function connect(){
    $C = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if($C->connect_error){
        return false;
    }
    return $C;
}

function sqlInsert($C, $query, $format= false, ...$vars){
    $stmt = $C->prepare($query);
    if($format){
        $stmt->bind_Param($format, ...$vars);
    }

    if($stmt->execute()){
        $id = $stmt->insert_id;
        $stmt->close();
        return $id;
    }

    $stmt->close();
    return -1;
}



function sqlSelect($C, $query , $format= false, ...$vars){
    $stmt = $C->prepare($query);

    if($format){
        $stmt->bind_Param($format, ...$vars);
    }

    if($stmt->execute()){
        $res = $stmt->get_result();
        $stmt->close();

        return $res;
    }

    $stmt->close();
    return false;
}


function sqlUpdate($C , $query, $format=false, ...$vars){
    $stmt = $C->prepare($query);

    if($format){
        $stmt->bind_Param($format, ...$vars);
    }

    if($stmt->execute()){
        $stmt->close();
        return true;
    }

    $stmt->close();
    return false;
}


function sqlDelete($C, $query, $format=false, ...$vars){

    $stmt = $C->prepare($query);

    if($format){
        $stmt->bind_Param($format, ...$vars);
    }

    if($stmt->execute()){
        $stmt->close();
        return true;
    }
    $stmt->close();
    return false;

}

function validateUserInput($data){
    $C = connect();
    trim($data);
    strip_tags($data);
    stripcslashes($data);
    htmlspecialchars($data);
    mysqli_real_escape_string($C ,$data);

    return $data;
}

?>