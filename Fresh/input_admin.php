<?php
session_start();
require_once("dbhelper.php");   
if(empty($_SESSION)|| isset($_SESSION['customer'])){
    header("Location: index.php");
}
    $username = $password = "";
    if(!empty($_POST)){
        $s_id = "";
        if(isset($_POST['username'])){
            $username = $_POST['username'];
        }
        if(isset($_POST['password'])){
            $password = $_POST['password'];
        }
        if(isset($_POST['id'])){
            $s_id = $_POST['id'];
        }
        $username = str_replace('\'','\\\'',$username);
        $password = str_replace('\'','\\\'',$password);
        $s_id = str_replace('\'','\\\'',$s_id);

        if($s_id != ""){
            // update
            $sql = "UPDATE admin SET admin_username = '$username', admin_password = '$password'
            WHERE id = ".$s_id;
        }else{
            // insert
            $sql = "INSERT INTO admin(admin_username,admin_password)
            VALUES ('$username','$password')";
        }
        execute($sql);
        header("Location: list_admin.php");
        die();
    }

    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = 'SELECT * FROM admin WHERE id ='.$id;
        $adminlist = executeResult($sql);
        if($adminlist != null && count($adminlist)>0){
            $admin = $adminlist[0];
            $username = $admin['admin_username'];
            $password = $admin['admin_password'];
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
    <title>Admin</title>
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
				<h2 class="text-center">Admin</h2>
			</div>
			<div class="panel-body">
                <form action="" method="post" name="frm" id="frm">
                    <div class="form-group">
                        <input type="number" name="id" value="<?=$id?>" style="display: none;">
                        <input type="text" class="form-control" name="username" id="username" size="30" placeholder="Tên đăng nhập:" pattern="[A-Za-z0-9]{1,}" value="<?=$username?>" required><br>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" size="30" placeholder="Mật khẩu:" pattern="[A-Za-z0-9]{1,}" value="<?=$password?>" required><br>
                    </div>
                        <button class="btn btn-primary" type="reset">Reset</button>
                        <button class="btn btn-success" type="submit">Input</button>
                        <a href="list_admin.php">Back to List Customer</a>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#frm").validate({
                rules: {
                    username: "required",
                    password: "required"
                },
                messages: {
                    username: "Vui lòng nhập tên đăng nhập",
                    password: "Vui lòng nhập mật khẩu"
                }
            });
        });
    </script>
</body>
</html>