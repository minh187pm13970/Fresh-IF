<?php
session_start();
require_once("dbhelper.php");
if(empty($_SESSION) || isset($_SESSION['admin'])){
    header("Location: index.php");
}
$id = "";
if(isset($_GET['id'])){
    $id = $_GET['id'];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Detail</title>
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
        <a href="index.php">Go to Index</a><br>
        <div class="panel panel-primary">
            <div class="panel-heading">
                Customer Detail
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                <?php
                    if($id != ""){
                        $sql = 'SELECT * FROM customer
                        WHERE id ='.$id;
                        $info_cus = executeResult($sql);
                        foreach ($info_cus as $info){
                            echo'
                                <tr>
                                    <th>Tên đăng nhập</th>
                                    <td>'.$info['customer_username'].'</td>
                                </tr>
                                <tr>
                                    <th>Mật khẩu</th>
                                    <td>'.$info['customer_password'].'</td>
                                </tr>
                                <tr>
                                    <th>Tên user</th>
                                    <td>'.$info['customer_name'].'</td>
                                </tr>
                                <tr>
                                    <th>Sinh nhật</th>
                                    <td>'.$info['birthday'].'</td>
                                </tr>
                                <tr>
                                    <th>Địa chỉ</th>
                                    <td>'.$info['address'].'</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>'.$info['phone_number'].'</td>
                                </tr>
                            ';
                        }
                    }
                ?>
                </table>
            </div>
        </div>
    </div>

</body>
</html>

