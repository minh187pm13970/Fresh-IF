<?php
session_start();
require_once("config.php");
function excecuteCustomer($query){
    $connect = new mysqli(HOST,USERNAME,PASSWORD,DATABASE);
    mysqli_set_charset($connect,"utf8");
    $result = mysqli_query($connect,$query);
    $data = [];
    while($row = mysqli_fetch_array($result,1)){
        $data[] = $row;
    }
    mysqli_close($connect);
    
    for($i=0;$i<count($data);$i++){
        $_SESSION['id'] = $data[$i]['id'];
        $_SESSION['customer'] = $data[$i]['customer_username'];
    }

    if($data != null && count($data)>0){        
        header("Location: index.php");
    }
}
function executeAdmin($query){
    $connect = new mysqli(HOST,USERNAME,PASSWORD,DATABASE);
    mysqli_set_charset($connect,"utf8");
    $result = mysqli_query($connect,$query);
    $data = [];
    while($row = mysqli_fetch_array($result,1)){
        $data[] = $row;
    }
    mysqli_close($connect);

    for($i=0;$i<count($data);$i++){
        $_SESSION['admin'] = $data[$i]['admin_username'];
    }

    if($data != null && count($data)>0){        
        header("Location: index.php");
    }
}
?>