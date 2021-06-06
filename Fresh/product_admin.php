<?php
session_start();
require_once("dbhelper.php");
if(empty($_SESSION) || isset($_SESSION['customer'])){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
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
                List Product Admin
                <form action="" method="get">
                    <input type="text" name="s_product" id="s_product" class="form-control" placeholder="Tìm kiếm theo tên" style="margin-top:4px;margin-bottom:4px;">
                </form>
                <button  class="btn btn-success" onclick="window.open('input_product.php','_self')">Add Product</button>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Mã sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Tồn kho</th>
                            <th>Giá</th>
                            <th>Hình ảnh</th>
                            <th>Mô tả</th>
                            <th>Ghi chú</th>
                            <th>Ngày tạo</th>
                            <th>Tên loại Sản phẩm</th>
                            <th>Tên nhà sản xuất</th>
                            <th colspan="2">Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(isset($_GET['s_product']) && $_GET['s_product'] != ''){
                            $sql = 'SELECT p.id, p.productCode, p.productName,p.in_Stock,p.price, p.image,p.description,p.note,p.createDate, c.categoryName, b.brandName
                            FROM product p, brand b, category c
                            WHERE p.idBrand = b.id AND p.idCategory = c.id AND p.productName like "%'.$_GET['s_product'].'%"';
                        }else{
                            $sql = 'SELECT p.id, p.productCode, p.productName,p.in_Stock,p.price, p.image,p.description,p.note,p.createDate, c.categoryName, b.brandName
                             FROM product p, brand b, category c 
                             WHERE p.idBrand = b.id AND p.idCategory = c.id';                            
                        }
                        $productlist = executeResult($sql);
                        
                        foreach($productlist as $product){
                            echo '
                            <tr>
                                <td>'.$product['id'].'</td>
                                <td>'.$product['productCode'].'</td>
                                <td>'.$product['productName'].'</td>
                                <td>'.$product['in_Stock'].'</td>
                                <td>'.$product['price'].'</td>
                                <td><img src="images/'.$product['image'].'" alt="Product image" width="100px" height="100px"></td>
                                <td>'.$product['description'].'</td>
                                <td>'.$product['note'].'</td>
                                <td>'.$product['createDate'].'</td>
                                <td>'.$product['categoryName'].'</td>
                                <td>'.$product['brandName'].'</td>
                                <td><button class="btn btn-warning" onclick=\'window.open("input_product.php?id='.$product['id'].'","_self")\'>Edit</button></td>
                                <td><button class="btn btn-danger" onclick="deleteProduct('.$product['id'].')">Delete</button></td>
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
        function deleteProduct(id){
            // console.log(id)
            option = confirm('Bạn có muốn xóa sản phẩm này không?')
            if(!option){
                return;
            }
            $.post('delete_product.php',{
                'id':id
            },function(data){
                alert(data)
                location.reload()
            })
        }
    </script>
</body>
</html>