<?php
session_start();
require_once("dbhelper.php");
if(empty($_SESSION)|| isset($_SESSION['admin'])){
    header("Location: index.php");
}

$buy =  $id = $cartid = "";
if(isset($_GET['buy'])){
    $buy = $_GET['buy'];
}
if(isset($_SESSION['id'])){
    $id = $_SESSION['id'];
}
if($buy != "" && $id != ""){
    $connect = new mysqli(HOST,USERNAME,PASSWORD,DATABASE);
    mysqli_set_charset($connect,"utf8");
    $query = 'SELECT * FROM cart WHERE idCustomer ='.$id;
    $data = [];
    $result = mysqli_query($connect,$query);
    while($row = mysqli_fetch_array($result,1)){
        $data[] = $row;
    }
    mysqli_close($connect);
    for($i=0;$i<count($data);$i++){
        $sql = 'INSERT INTO bill(Productid,Customerid,buydatetime,amount)
        VALUES ('.$data[$i]['idProduct'].','.$data[$i]['idCustomer'].',Now(),1)';
        execute($sql);
    }
    $sql = 'DELETE FROM cart WHERE idCustomer ='.$id;
    execute($sql);
    $sql = 'SELECT p.in_Stock , b.amount, p.id , b.Productid, b.buydatetime FROM product p, bill b WHERE p.id = b.Productid';
    $billlist = executeResult($sql);
    foreach($billlist as $bill){
        $query = 'UPDATE product SET in_Stock = "'.($bill['in_Stock'] - $bill['amount']).'"WHERE id = "'.$bill['Productid'].'" AND "'.$bill['buydatetime'].'" = NOW()';
        execute($query);
    }
}else{
    if(isset($_GET['cartid'])){
        $cartid = $_GET['cartid'];
        if($cartid != ""){
            $sql = 'SELECT * FROM cart WHERE id = '.$cartid;
            $billlist = executeResult($sql);
            foreach($billlist as $bill){
                $query = 'INSERT INTO bill(Productid,Customerid,buydatetime,amount)
                VALUES ('.$bill['idProduct'].','.$bill['idCustomer'].',Now(),'.$bill['amount'].')';
                execute($query);
               
            }
            $sql = 'DELETE FROM cart WHERE id ='.$cartid;
            execute($sql);
        }
    }
    $sql = 'SELECT p.in_Stock , b.amount, p.id , b.Productid, b.buydatetime FROM product p, bill b WHERE p.id = b.Productid';
    $billlist = executeResult($sql);
    foreach($billlist as $bill){
        $query = 'UPDATE product SET in_Stock = "'.($bill['in_Stock'] - $bill['amount']).'"WHERE id = "'.$bill['Productid'].'" AND "'.$bill['buydatetime'].'" = NOW()';
        execute($query);
    }
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
    <a href="product_customer.php">Go to Product</a><br>
    <a href="cart.php">Go to cart</a>
        <div class="panel panel-primary">
            <div class="panel-heading">
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                           
                            <th>Tên sản phẩm</th>
                           
                            <th>thời gian mua</th>
         
                            <th>Số lượng mua</th>

                            <th>Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = 'SELECT b.id , b.Productid , b.Customerid, b.buydatetime , p.productName, b.amount, p.price
                            FROM bill b, product p, customer c
                            WHERE b.Productid = p.id AND b.Customerid = c.id AND b.Customerid ='.$id;
                            $billlist = executeResult($sql);
                            $no = 1;
                            foreach($billlist as $bill){
                                // <td>'.$no++.'</td>
                                $sum = $bill['price'] * $bill['amount'];
                                echo '
                                <tr>
                                    <td>'.$bill['id'].'</td>
                                    <td>'.$bill['productName'].'</td>
                                    
                                    <td>'.$bill['buydatetime'].'</td>

                                    <td>'.$bill['amount'].'</td>

                                    <td>'.$sum.'</td>
                                ';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>