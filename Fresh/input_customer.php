<?php
session_start();
require_once("dbhelper.php");
if(empty($_SESSION)|| isset($_SESSION['customer'])){
    header("Location: index.php");
}
$username = $password = $customername = $birthday = $address = $phone = "";
    if(!empty($_POST)){
        $s_id = "";
        if(isset($_POST['username'])){
            $username = $_POST['username'];
        }
        if(isset($_POST['password'])){
            $password = $_POST['password'];
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
        if(isset($_POST['id'])){
            $s_id = $_POST['id'];
        }
        $username = str_replace('\'','\\\'',$username);
        $password = str_replace('\'','\\\'',$password);
        $customername = str_replace('\'','\\\'',$customername);
        $birthday = str_replace('\'','\\\'',$birthday);
        $address = str_replace('\'','\\\'',$address);
        $phone = str_replace('\'','\\\'',$phone);
        $s_id = str_replace('\'','\\\'',$s_id);

        if($s_id != ""){
            // update
            $sql = "UPDATE customer SET customer_username = '$username', customer_password = '$password', customer_name = '$customername', birthday = '$birthday', address = '$address', phone_number = '$phone'
            WHERE id = ".$s_id;
        }else{
            // insert
            $sql = "INSERT INTO customer(customer_username,customer_password,customer_name,birthday,address,phone_number)
            VALUES ('$username','$password','$customername','$birthday','$address','$phone')";
        }
        execute($sql);
        header("Location: list_customer.php");
        die();
    }

    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = 'SELECT * FROM customer WHERE id ='.$id;
        $customerlist = executeResult($sql);
        if($customerlist != null && count($customerlist)>0){
            $customer = $customerlist[0];
            $username = $customer['customer_username'];
            $password = $customer['customer_password'];
            $customername = $customer['customer_name'];
            $birthday = $customer['birthday'];
            $address = $customer['address'];
            $phone = $customer['phone_number'];
        }else{
            $id = "";
        }
    }
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="text-center">Customer</h2>
			</div>
			<div class="panel-body">
                <form action="" method="post" name="frm" id="frm">
                        <div class="form-group">
                        <input type="number" name="id" value="<?=$id?>" style="display: none;">
                        <input type="text" class="form-control" name="username" id="username" size="30" placeholder="Tên đăng nhập:" pattern="[A-Za-z0-9]{1,}" value="<?=$username?>" required><br>
                        </div>
                        <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" size="30" placeholder="Mật khẩu:" pattern="[A-Za-z0-9]{1,}" value="<?=$password?>" required><br>
                        </div>
                        <div class="form-group">
                        <input type="text" class="form-control" name="customername" id="customername" size="30" placeholder="Tên Khách Hàng:" pattern="[A-Za-zÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚÝàáâãèéêìíòóôõùúýĂăĐđĨĩŨũƠơƯưẠ-ỹ ]{2,}" value="<?=$customername?>" required><br>
                        </div>
                        <div class="form-group">
                        <label for="birthday">Nhập ngày tháng năm sinh:</label>
                        <input type="date" class="form-control" name="birthday" id="birthday" size="30" min="1980-01-01" max="2017-01-01" value="<?=$birthday?>" required><br>
                        </div>
                        <div class="form-group">
                        <input type="text" class="form-control" name="address" id="address" size="30" placeholder="Địa chỉ:" pattern="[A-Za-z0-9ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚÝàáâãèéêìíòóôõùúýĂăĐđĨĩŨũƠơƯưẠ-ỹ./ ]{1,}" value="<?=$address?>" required><br>
                        </div>
                        <div class="form-group">
                        <input type="tel" class="form-control" name="phone" id="phone" size="30" placeholder="Điện thoại: 0123456789" pattern="[0-9]{10}" value="<?=$phone?>" required><br>
                        </div>
                        <button class="btn btn-primary" type="reset">Reset</button>
                        <button class="btn btn-success" type="submit">Input</button>
                        <a href="list_customer.php">Back to List Customer</a>
                    </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#frm").validate({
                rules: {
                    username: "required",
                    password: "required",
                    customername: "required",
                    birthday: "required",
                    address: "required",
                    phone: "required"
                },
                messages: {
                    username: "Vui lòng nhập tên đăng nhập",
                    password: "Vui lòng nhập mật khẩu",
                    customername: "Vui lòng nhập tên của bạn",
                    birthday: "Vui lòng nhập ngày tháng năm sinh",
                    address: "Vui lòng nhập địa chỉ",
                    phone: "Vui lòng nhập số điện thoại"
                }
            });
        });
    </script>
</body>
</html>