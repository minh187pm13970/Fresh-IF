<?php
session_start();
require_once("dbhelper.php");
if(empty($_SESSION)|| isset($_SESSION['customer'])){
    header("Location: index.php");
}
$productCode = $productName = $in_Stock = $price = $image = $description = $note = $createDate = $categoryName = $brandName = "";
    if(!empty($_POST)){
        $s_id = "";
        if(isset($_POST['productCode'])){
            $productCode = $_POST['productCode'];
        }
        if(isset($_POST['productName'])){
            $productName = $_POST['productName'];
        }
        if(isset($_POST['in_Stock'])){
            $in_Stock = $_POST['in_Stock'];
        }
        if(isset($_POST['price'])){
            $price = $_POST['price'];
        }
        if(isset($_POST['image'])){
            $image = $_POST['image'];
        }
        if(isset($_POST['description'])){
            $description = $_POST['description'];
        }

        if(isset($_POST['note'])){
            $note = $_POST['note'];
        }
        if(isset($_POST['createDate'])){
            $createDate = $_POST['createDate'];
        }
        if(isset($_POST['idCategory'])){
            $idCategory = $_POST['idCategory'];
        }
        if(isset($_POST['idBrand'])){
            $idBrand = $_POST['idBrand'];
        }
        if(isset($_POST['id'])){
            $s_id = $_POST['id'];
        }
        $productCode = str_replace('\'','\\\'',$productCode);
        $productName = str_replace('\'','\\\'',$productName);
        $in_Stock = str_replace('\'','\\\'',$in_Stock);
        $price = str_replace('\'','\\\'',$price);
        $image = str_replace('\'','\\\'',$image);
        $description = str_replace('\'','\\\'',$description);
        $note = str_replace('\'','\\\'',$note);
        $createDate = str_replace('\'','\\\'',$createDate);
        $idCategory = str_replace('\'','\\\'',$idCategory);
        $idBrand = str_replace('\'','\\\'',$idBrand);
        $s_id = str_replace('\'','\\\'',$s_id);



        if($s_id != ""){
            // update
            $sql = "UPDATE product SET productCode = '$productCode', productName = '$productName', in_Stock = '$in_Stock',
             price = '$price', image = '$image', description = '$description', note = '$note',
             createDate = '$createDate', idCategory ='$idCategory', idBrand = '$idBrand'
            WHERE id = ".$s_id;
        }else{
            // insert
            $sql = "INSERT INTO product(productCode,productName,in_Stock,price,image,description,note,createDate,idCategory,idBrand)
            VALUES ('$productCode','$productName','$in_Stock','$price','$image','$description','$note','$createDate','$idCategory','$idBrand')";
        }
        execute($sql);
        header("Location: product_admin.php");
        die();
    }

    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = 'SELECT p.id, p.productCode, p.productName, p.in_Stock, p.price, p.image, p.description, p.note, p.createDate, p.idCategory, p.idBrand, c.categoryName, b.brandName
        FROM product p, brand b, category c 
        WHERE p.idBrand = b.id AND p.idCategory = c.id AND p.id ='.$id;
        $productlist = executeResult($sql);
        if($productlist != null && count($productlist)>0){
            $product = $productlist[0];
            $productCode = $product['productCode'];
            $productName = $product['productName'];
            $in_Stock = $product['in_Stock'];
            $price = $product['price'];
            $image = $product['image'];
            $description = $product['description'];
            $note = $product['note'];
            $createDate = $product['createDate'];
            $categoryName = $product['categoryName'];
            $brandName = $product['brandName'];
            $idCategory = $product['idCategory'];
            $idBrand = $product['idBrand'];
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
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="text-center">Product</h2>
			</div>
			<div class="panel-body">
                <form action="" method="post" name="frm" id="frm">
                        <div class="form-group">
                        <input type="number" name="id" value="<?=$id?>" style="display: none;">
                        <input type="text" class="form-control" name="productCode" id="productCode" size="30" placeholder="Mã sản phẩm:" pattern="[A-Za-z0-9]{1,}" value="<?=$productCode?>" required><br>
                        </div>
                        <div class="form-group">
                        <input type="text" class="form-control" name="productName" id="productName" size="30" placeholder="Tên sản phẩm:" pattern="[A-Za-zÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚÝàáâãèéêìíòóôõùúýĂăĐđĨĩŨũƠơƯưẠ-ỹ ]{1,}" value="<?=$productName?>" required><br>
                        </div>
                        <div class="form-group">
                        <input type="number" class="form-control" name="in_Stock" id="in_Stock" size="30" placeholder="Số lượng:" pattern="[0-9]{1,}" value="<?=$in_Stock?>" min="1" required><br>
                        </div>
                        <div class="form-group">
                        <input type="number" class="form-control" name="price" id="price" size="30" placeholder="Giá tiền:" pattern="[0-9]{1000,}" value="<?=$price?>" required><br>
                        </div>
                        <div class="form-group">
                        <input type="text" class="form-control" name="image" id="image" size="30" placeholder="Hình ảnh:" pattern="[A-Za-z0-9._]{1,}" value="<?=$image?>" required><br>
                        </div>
                        <div class="form-group">
                        <input type="text" class="form-control" name="description" id="description" size="30" placeholder="Mô tả:" pattern="[A-Za-z0-9ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚÝàáâãèéêìíòóôõùúýĂăĐđĨĩŨũƠơƯưẠ-ỹ., ]{1,}" value="<?=$description?>"><br>
                        </div>
                        <div class="form-group">
                        <input type="text" class="form-control" name="note" id="note" size="30" placeholder="Ghi chú:" pattern="[A-Za-z0-9ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚÝàáâãèéêìíòóôõùúýĂăĐđĨĩŨũƠơƯưẠ-ỹ., ]{1,}" value="<?=$note?>"><br>
                        </div>
                        <div class="form-group">
                        <input type="text" class="form-control" name="createDate" id="createDate" placeholder="Ngày tạo: YYYY-MM-DD" size="30" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" min="2021-04-01" max="2021-06-01" value="<?=$createDate?>" required><br>
                        </div>
                        <div class="form-group">
                        <label for="idCategory">Loại sản phẩm:</label>
                        <select name="idCategory" id="idCategory">
                            <?php
                                $sql = 'SELECT * FROM category';
                                $categorylist = executeResult($sql);
                                if($categoryName != null){
                                    foreach ($categorylist as $category){
                                        echo'
                                        <option value="'.$category['id'].'" hidden>'.$categoryName.'</option>
                                        <option value="'.$category['id'].'">'.$category['categoryName'].'</option>
                                    ';
                                    }

                                }else{
                                    foreach ($categorylist as $category){
                                        echo'
                                            <option value="'.$category['id'].'">'.$category['categoryName'].'</option>
                                        ';
                                    }
                                }
                            ?>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="idBrand">Nhà sản xuất:</label>
                        <select name="idBrand" id="idBrand">
                            <?php
                                $sql = 'SELECT * FROM brand';
                                $brandlist = executeResult($sql);
                                if($brandName != null){
                                    foreach ($brandlist as $brand){
                                        echo'
                                            <option value="'.$brand['id'].'" hidden>'.$brandName.'</option>
                                            <option value="'.$brand['id'].'">'.$brand['brandName'].'</option>
                                        ';
                                    }
                                }else{
                                    foreach ($brandlist as $brand){
                                        echo'
                                            <option value="'.$brand['id'].'">'.$brand['brandName'].'</option>
                                        ';
                                    }
                                }
                            ?>
                        </select>
                        </div>
                        <button class="btn btn-primary" type="reset">Reset</button>
                        <button class="btn btn-success" type="submit">Input</button>
                        <a href="product_admin.php">Back to Product Admin</a>
                    </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#frm").validate({
                rules: {
                    productCode: "required",
                    productName: "required",
                    in_Stock: "required",

                    price: "required",
                    image: "required",

                    createDate: "required",
                    idCategory: "required",
                    idBrand: "required"
                },
                messages: {
                    productCode: "Vui lòng nhập mã sản phẩm",
                    productName: "Vui lòng nhập tên sản phẩm",

                    in_Stock: "Vui lòng nhập số lượng",
                    price: "Vui lòng nhập giá tiền",

                    image: "Vui lòng nhập hình ảnh",
                    createDate: "Vui lòng nhập ngày tạo",

                    idCategory: "Vui lòng chọn loại sản phẩm",
                    idBrand: "Vui lòng chọn nhà sản xuất"
                }
            });
        });
    </script>
</body>
</html>