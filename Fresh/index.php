<?php
session_start();
require_once("dbhelper.php");
$id = $user = "";
if(isset($_SESSION['id'])){
    $id = $_SESSION['id'];
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
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
    <h1><span style="color: aquamarine;">Fresh IF</span></h1>
        <p>
        <?php
            if(isset($_SESSION['admin'])){
                $user = $_SESSION['admin'];
            }
            if(isset($_SESSION['customer'])){
                $user = $_SESSION['customer'];
            }
            if($user != ""){
                echo 'Chào mừng '.$user.' đã đăng nhập vào trang chủ của Fresh IF <br>';
                echo '<a href="logout.php" style="text-decoration: none;">Đăng xuất</a>';
            }else{
                echo'
                <a href="login.html" style="text-decoration: none;">Đăng nhập</a><br>
                <a href="register_customer.html" style="text-decoration: none;">Đăng ký khách hàng</a>';
            }
        ?>
        </p>
        <?php
         if(isset($_SESSION['customer'])){
             if($id != ""){
                 $query = 'SELECT * FROM customer WHERE id= "'.$id.'" AND customer_username = "'.$user.'"';
                 $info_cus = executeResult($query);
                 foreach($info_cus as $info){
                     echo'
                     <button class="btn btn-primary" onclick=\'window.open("customer_detail.php?id='.$info['id'].'","_self")\'>Information Customer</button>
                     ';
                 }
            }
        }
        ?>
        <?php
            if(isset($_SESSION['admin'])){
                echo'
                <form action="product_admin.php" method="get">
                <input type="text" name="s_product" id="s_product" class="form-control" class="form-control" placeholder="Tìm kiếm sản phẩm theo tên" style="margin-top:4px;margin-bottom:4px;">
                </form>
                <a href="list_admin.php">Danh sách tài khoản admin</a><br>
                <a href="list_customer.php">Danh sách tài khoản khách hàng</a><br>
                <a href="product_admin.php">Danh sách sản phẩm</a><br>
                <a href="brand_admin.php">Danh sách nhà sản xuất</a><br>
                <a href="bill_admin.php">Hồ sơ đơn hàng</a>
                ';
            }
            if(isset($_SESSION['customer'])){
                echo'
                <form action="product_customer.php" method="get">
                <input type="text" name="s_product" id="s_product" class="form-control" class="form-control" placeholder="Tìm kiếm sản phẩm theo tên" style="margin-top:4px;margin-bottom:4px;">
                <a href="product_customer.php">Sản phẩm</a><br>
                <a href="cart.php">Giỏ hàng</a><br>
                <a href="bill.php">Đơn hàng</a>
                </form>
                ';
            }
        ?>
        <?php
            if(isset($_SESSION['customer'])){
                $query = 'SELECT * FROM product
                WHERE DATE(createDate) <= CURDATE() && DATE(createDATE) >= (CURDATE() - INTERVAL 7 DAY)';
                $productlist = executeResult($query);
                foreach ($productlist as $product){
                    echo'                    
                        <div class="col-md-4">
                            <img src="images/'.$product['image'].'" alt="Product image" width="50%">
                            <p>'.$product['productName'].' <span style="color: red; background-color: yellow">NEW</span></p>
                            <button class="btn btn-warning" onclick=\'window.open("product_detail.php?id='.$product['id'].'","_self")\'>Detail</button>
                        </div>
                    ';
                }
            }
        ?>
</body>

</html>