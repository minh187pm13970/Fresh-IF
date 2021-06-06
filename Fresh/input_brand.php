<?php
session_start();
require_once("dbhelper.php");   
if(empty($_SESSION)|| isset($_SESSION['customer'])){
    header("Location: index.php");
}
    $brandcode = $brandname = $origin = "";
    if(!empty($_POST)){
        $s_id = "";
        if(isset($_POST['brandcode'])){
            $brandcode = $_POST['brandcode'];
        }
        if(isset($_POST['brandname'])){
            $brandname = $_POST['brandname'];
        }
        if(isset($_POST['origin'])){
            $origin = $_POST['origin'];
        }
        if(isset($_POST['id'])){
            $s_id = $_POST['id'];
        }
        $brandcode = str_replace('\'','\\\'',$brandcode);
        $brandname = str_replace('\'','\\\'',$brandname);
        $origin = str_replace('\'','\\\'',$origin);
        $s_id = str_replace('\'','\\\'',$s_id);

        if($s_id != ""){
            // update
            $sql = "UPDATE brand SET brandCode = '$brandcode', brandName = '$brandname', origin = '$origin'
            WHERE id = ".$s_id;
        }else{
            // insert
            $sql = "INSERT INTO brand(brandCode,brandName,origin)
            VALUES ('$brandcode','$brandname','$origin')";
        }
        execute($sql);
        header("Location: brand_admin.php");
        die();
    }
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = 'SELECT * FROM brand WHERE id ='.$id;
        $brandlist = executeResult($sql);
        if($brandlist != null && count($brandlist)>0){
            $brand = $brandlist[0];
            $brandcode = $brand['brandCode'];
            $brandname = $brand['brandName'];
            $origin = $brand['origin'];
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
    <title>Brand</title>
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
				<h2 class="text-center">Brand</h2>
			</div>
			<div class="panel-body">
                <form action="" method="post" name="frm" id="frm">
                    <div class="form-group">
                        <input type="number" name="id" value="<?=$id?>" style="display: none;">
                        <input type="text" class="form-control" name="brandcode" id="brandcode" size="30" placeholder="Mã nhà sản xuất:" pattern="[A-Z0-9]{1,}" value="<?=$brandcode?>" required><br>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="brandname" id="brandname" size="30" placeholder="Tên nhà sản xuất:" pattern="[A-Za-z ]{1,}" value="<?=$brandname?>" required><br>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="origin" id="origin" size="30" placeholder="Xuất sứ:" pattern="[A-Z]{1,}" value="<?=$origin?>" required><br>
                    </div>
                        <button class="btn btn-primary" type="reset">Reset</button>
                        <button class="btn btn-success" type="submit">Input</button>
                        <a href="brand_admin.php">Back to Brand Admin</a>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#frm").validate({
                rules: {
                    brandcode: "required",
                    brandname: "required",
                    origin: "required"
                },
                messages: {
                    brandcode: "Vui lòng nhập mã nhà sản xuất",
                    brandname: "Vui lòng nhập tên nhà sản xuất",
                    origin: "Vui lòng nhập xuất sứ"
                }
            });
        });
    </script>
</body>
</html>