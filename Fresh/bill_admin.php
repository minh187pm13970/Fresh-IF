<?php
session_start();
require_once("dbhelper.php");
if(empty($_SESSION)|| isset($_SESSION['customer'])){
    header("Location: index.php");
}

$buy =  $id = "";
if(isset($_POST['buy'])){
    $buy = $_POST['buy'];
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
        $sql = 'INSERT INTO bill(Productid,Customerid,buydatetime)
        VALUES ('.$data[$i]['idProduct'].','.$data[$i]['idCustomer'].',Now())';
        execute($sql);
    }
    $sql = 'DELETE FROM cart WHERE idCustomer ='.$id;
    execute($sql);
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
         
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = 'SELECT b.id , b.Productid , b.Customerid, b.buydatetime , p.productName, c.customer_name
                            FROM bill b, product p, customer c
                            WHERE b.Productid = p.id AND b.Customerid = c.id';
                            
                            $billlist = executeResult($sql);
                            $no = 1;
                            foreach($billlist as $bill){
                                echo '
                                <tr>
                                    <td>'.$no++.'</td>
                                   
                                    <td>'.$bill['productName'].'</td>
                                    
                                    <td>'.$bill['buydatetime'].'</td>

                                    <td>'.$bill['customer_name'].'</td>
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