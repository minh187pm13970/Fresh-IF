<?php
session_start();
require_once("dbhelper.php");
if(empty($_SESSION) || isset($_SESSION['admin'])){
    header("Location: index.php");
}
$name = $id = "";
if(isset($_SESSION['customer'])){
    $name = $_SESSION['customer'];
}
$idCus = $idPro = "";
if(isset($_GET['idCustomer'])){
    $idCus = $_GET['idCustomer'];
}
if(isset($_GET['idProduct'])){
    $idPro = $_GET['idProduct'];
}
if($idCus != "" && $idPro != ""){
    $sql = "INSERT INTO cart (idCustomer,idProduct)
    VALUES ('$idCus','$idPro')";
    execute($sql);
    header("Location: product_customer.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
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
    <a href="product_customer.php">Go to Product</a>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <?php
                    echo'List Product of '.$name;
                ?>            
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Mã sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Hình ảnh</th>
                            <th>Tổng tiền</th>
                            <th colspan="2">Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $all = 0;
                        if(isset($_SESSION['id'])){
                            $id = $_SESSION['id'];
                        }
                        if($id !=""){
                            $sql = 'SELECT p.productCode, p.productName,p.in_Stock,p.price, p.image,ct.idProduct,ct.idCustomer, ct.id, ct.amount
                            FROM product p, customer cr, cart ct
                            WHERE ct.idCustomer= cr.id  AND ct.idProduct=p.id AND ct.idCustomer ='.$id;
                            $cartlist = executeResult($sql);
                            $no = 1;
                            foreach($cartlist as $cart){
                                $amount = 1;
                                $sum = $cart['price'] * $amount;
                                $all += $sum;
                                // <td><input type="number" name ="amount" value="1" min="1" max="'.$cart['in_Stock'].'"></td>
                                echo '
                                <tr>
                                    <td>'.$no++.'</td>
                                    <td>'.$cart['productCode'].'</td>
                                    <td>'.$cart['productName'].'</td>
                                    <td>'.$amount.'</td>
                                    <td>'.$cart['price'].'</td>
                                    <td><img src="images/'.$cart['image'].'" alt="cart image" width="100px" height="100px"></td>
                                    <td>'.$sum.'</td>
                                    <td>
                                    <button class="btn btn-warning" onclick=\'window.open("bill.php?cartid='.$cart['id'].'","_self")\'>Buy</button>
                                    </td>
                                    <td><button class="btn btn-danger" onclick="deleteCart('.$cart['id'].')">Delete</button></td>
                                    </tr>
                                    ';
                                }
                            }
                            ?>
                    </tbody>
                </table>
                <?php
                    echo "Tổng toàn bộ số tiền: ".$all."<br/>";
                    echo'<button class="btn btn-warning" onclick=\'window.open("bill.php?buy=all","_self")\'>BuyAll</button>';
                ?>    
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function deleteCart(id){
            // console.log(id)
            option = confirm('Bạn có muốn xóa Sản phẩm này ra khỏi Giỏ Hàng không')
            if(!option){
                return;
            }
            $.post('delete_cart.php',{
                'id':id
            },function(data){
                alert(data)
                location.reload()
            })
        }
    </script>
</body>
</html>