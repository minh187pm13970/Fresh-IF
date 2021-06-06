<?php
session_start();
require_once("dbhelper.php");
$id = "";
if(empty($_SESSION) || isset($_SESSION['admin'])){
    header("Location: index.php");
}

if(isset($_SESSION['id'])){
    $id = $_SESSION['id'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <a href="cart.php">Go to cart</a>
    <?php
        $query = 'SELECT COUNT(*) as number FROM cart WHERE idCustomer = '.$id;
        $result = executeResult($query);
        $number = 0;
        if($result != null && count($result)>0){
            $number = $result[0]['number'];
        }
        echo 'Sản phẩm hiện tại có trong giỏ hàng: '.$number;
    ?>
        <div class="row">
            <div class="col-md-3">
            <?php
            $sql = 'SELECT COUNT(id) as number FROM product';
            $result = executeResult($sql);
            // var_dump($result);
            $number = 0;
            if($result != null && count($result)>0){
                $number = $result[0]['number'];
            }
            $pages = ceil($number/4);
            // ceil dùng để làm tròn
            $current_page = 1;
            if(isset($_GET['page'])){
                $current_page = $_GET['page'];
            }

            $index = ($current_page - 1)* 4;

            if(isset($_GET['s_product']) && $_GET['s_product'] != ''){
                $query = 'SELECT p.id, p.productCode, p.productName,p.in_Stock,p.price, p.image,p.description,p.note,p.createDate, c.categoryName, b.brandName
                 FROM product p, brand b, category c 
                 WHERE p.idBrand = b.id AND p.idCategory = c.id AND p.productName like "%'.$_GET['s_product'].'%"
                LIMIT '.$index.', 4';
            }else{
                $query = 'SELECT p.id, p.productCode, p.productName,p.in_Stock,p.price, p.image,p.description,p.note,p.createDate, c.categoryName, b.brandName
                FROM product p, brand b, category c 
                WHERE p.idBrand = b.id AND p.idCategory = c.id 
                LIMIT '.$index.', 4';
            }
            $productlist = executeResult($query);
            foreach ($productlist as $product){
                echo'
                    <img src="images/'.$product['image'].'" alt="Product image" width="100%">
                    <p>Tên sản phẩm: '.$product['productName'].'</p>
                    <p>Số lượng: '.$product['in_Stock'].'</p>
                    <p>Giá: '.$product['price'].' VND</p>
                    <button class="btn btn-warning" onclick=\'window.open("product_detail.php?id='.$product['id'].'","_self")\'>Detail</button>
                    <td><button class="btn btn-primary" onclick=\'window.open("cart.php?idProduct='.$product['id'].'&idCustomer='.$id.'","_self")\'>Buy</button></td>          
                    ';
                }
                ?>
                </div>
        </div>
        <div class="row">
            <ul class="pagination">
                <?php
                for($i=1;$i<=$pages;$i++){
                    echo'
                    <li><a href="?page='.$i.'" style="margin-left: 10px;">'.$i.'</a></li>
                    ';
                }
                ?>    
            </ul>
        </div>
    </div>
    
</body>
</html>