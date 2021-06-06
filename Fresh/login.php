<?php
require_once("execute_account.php");
if(!empty($_POST)){
    $username = $_POST['username'];
    $password = $_POST['password'];
if($username != "" && $password != ""){
    $sql = 'SELECT * FROM customer WHERE customer_username = "'.$username.'" AND customer_password = "'.$password.'" ';
    excecuteCustomer($sql);
    $sql = 'SELECT * FROM admin  WHERE admin_username = "'.$username.'" AND admin_password = "'.$password.'" ';
    executeAdmin($sql);
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Fail</title>
</head>
<body>
    <h1>Bạn đã đăng nhập không thành công xin hãy bấm quay lại trang đăng nhập</h1>
    <a href="login.html">Login</a>
</body>
</html>