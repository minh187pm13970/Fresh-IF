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
    <title>Product Detail</title>
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
        <a href="product_customer.php">Go to Product</a>
        <div class="panel panel-primary">
            <div class="panel-heading">
                Product Detail
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                <?php
                    if($id != ""){
                        $sql = 'SELECT p.id, p.productCode, p.productName,p.in_Stock,p.price, p.image,p.description,p.note,p.createDate, c.categoryName, b.brandName
                        FROM product p, brand b, category c 
                        WHERE p.idBrand = b.id AND p.idCategory = c.id AND p.id ='.$id;
                        $productlist = executeResult($sql);
                        foreach ($productlist as $product){
                            echo'
                                <tr>
                                    <th>No</th>
                                    <td>'.$product['id'].'</td>
                                </tr>
                                <tr>
                                    <th>Mã sản phẩm</th>
                                    <td>'.$product['productCode'].'</td>
                                </tr>
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <td>'.$product['productName'].'</td>
                                </tr>
                                <tr>
                                    <th>Tồn kho</th>
                                    <td>'.$product['in_Stock'].'</td>
                                </tr>
                                <tr>
                                    <th>Giá</th>
                                    <td>'.$product['price'].' VNĐ</td>
                                </tr>
                                <tr>
                                    <th>Hình ảnh</th>
                                    <td><img src="images/'.$product['image'].'" alt="Product image" width="100px" height="100px"></td>
                                </tr>
                                <tr>
                                    <th>Mô tả</th>
                                    <td>'.$product['description'].'</td>
                                </tr>
                                <tr>
                                    <th>Ghi chú</th>
                                    <td>'.$product['note'].'</td>
                                </tr>
                                <tr>
                                    <th>Ngày tạo</th>
                                    <td>'.$product['createDate'].'</td>
                                </tr>
                                <tr>
                                    <th>Tên loại Sản phẩm</th>
                                    <td>'.$product['categoryName'].'</td>
                                </tr>
                                <tr>
                                    <th>Tên nhà sản xuất</th>
                                    <td>'.$product['brandName'].'</td>
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

