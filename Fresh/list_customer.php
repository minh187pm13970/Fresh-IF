<?php
session_start();
require_once("dbhelper.php");
if(empty($_SESSION)|| isset($_SESSION['customer'])){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
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
        <a href="index.php">Go to Index</a>
        <div class="panel panel-primary">
            <div class="panel-heading">
                List Account Customer
                <form action="" method="get">
                    <input type="text" name="s_customer" id="s_customer" class="form-control" placeholder="Tìm kiếm theo tên" style="margin-top:4px;margin-bottom:4px;">
                </form>
                <button  class="btn btn-success" onclick="window.open('input_customer.php','_self')">Add Customer</button>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tên đăng nhập</th>
                            <th>Mật khẩu</th>
                            <th>Tên user</th>
                            <th>Sinh nhật</th>
                            <th>Địa chỉ</th>
                            <th>Phone</th>
                            <th colspan="2">Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(isset($_GET['s_customer']) && $_GET['s_customer'] != ''){
                            $sql = 'SELECT * FROM customer WHERE customer_username like "%'.$_GET['s_customer'].'%"';
                        }else{
                            $sql = 'SELECT * FROM customer';
                        }
                        $customerlist = executeResult($sql);
                        foreach($customerlist as $customer){
                            echo '
                            <tr>
                                <td>'.$customer['id'].'</td>
                                <td>'.$customer['customer_username'].'</td>
                                <td>'.$customer['customer_password'].'</td>
                                <td>'.$customer['customer_name'].'</td>
                                <td>'.$customer['birthday'].'</td>
                                <td>'.$customer['address'].'</td>
                                <td>'.$customer['phone_number'].'</td>
                                <td><button class="btn btn-warning" onclick=\'window.open("input_customer.php?id='.$customer['id'].'","_self")\'>Edit</button></td>
                                <td><button class="btn btn-danger" onclick="deleteCustomer('.$customer['id'].')">Delete</button></td>
                            </tr>
                            ';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        <script type="text/javascript">
        function deleteCustomer(id){
            // console.log(id)
            option = confirm('Bạn có muốn xóa Khách hàng này không?')
            if(!option){
                return;
            }
            $.post('delete_customer.php',{
                'id':id
            },function(data){
                alert(data)
                location.reload()
            })
        }
    </script>
</body>
</html>