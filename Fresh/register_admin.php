<?php
require_once("dbhelper.php");
$username = $password = $resetpass = "";
if(!empty($_POST)){
    if(isset($_POST['username'])){
        $username = $_POST['username'];
    }
    if(isset($_POST['password'])){
        $password = $_POST['password'];
    }
    if(isset($_POST['resetpass'])){
        $resetpass = $_POST['resetpass'];
    }
    $username = str_replace('\'','\\\'',$username);
    $password = str_replace('\'','\\\'',$password);
    $resetpass = str_replace('\'','\\\'',$resetpass);

    if($password == $resetpass){
        $sql = "INSERT INTO admin(admin_username,admin_password)
        VALUES ('$username','$password')";
        execute($sql);
        header("Location: login.html");
    }else{
        header("Location: register_admin.html");
    }
}
?>