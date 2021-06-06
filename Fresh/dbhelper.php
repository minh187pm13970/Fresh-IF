<?php
require_once("config.php");
function execute($query){
    $connect = new mysqli(HOST,USERNAME,PASSWORD,DATABASE);
    mysqli_set_charset($connect,"utf8");
    // check connection
    if($connect->connect_error){
        var_dump($connect->connect_error);
        die();
    }
    mysqli_query($connect,$query);
    mysqli_close($connect);
}
function executeResult($query){
    $connect = new mysqli(HOST,USERNAME,PASSWORD,DATABASE);
    mysqli_set_charset($connect,"utf8");
    $data = [];
    $result = mysqli_query($connect,$query);
    while($row = mysqli_fetch_array($result,1)){
        $data[] = $row;
    }
    mysqli_close($connect);
    return $data;
}

?>