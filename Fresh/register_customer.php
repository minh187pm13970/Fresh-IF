<?php
require_once("dbhelper.php");
$username = $password = $resetpass = $customername = $birthday = $address = $phone = "";
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
    if(isset($_POST['customername'])){
        $customername = $_POST['customername'];
    }
    if(isset($_POST['birthday'])){
        $birthday = $_POST['birthday'];
    }
    if(isset($_POST['address'])){
        $address = $_POST['address'];
    }

    if(isset($_POST['phone'])){
        $phone = $_POST['phone'];
    }
    $username = str_replace('\'','\\\'',$username);
    $password = str_replace('\'','\\\'',$password);
    $resetpass = str_replace('\'','\\\'',$resetpass);
    $customername = str_replace('\'','\\\'',$customername);
    $birthday = str_replace('\'','\\\'',$birthday);
    $address = str_replace('\'','\\\'',$address);
    $phone = str_replace('\'','\\\'',$phone);

    if($password == $resetpass){
        $sql = "INSERT INTO customer(customer_username,customer_password,customer_name,birthday,address,phone_number)
        VALUES ('$username','$password','$customername','$birthday','$address','$phone')";
        execute($sql);
        header("Location: login.html");
    }else{
        header("Location: register_customer.html");
    }
}
?>