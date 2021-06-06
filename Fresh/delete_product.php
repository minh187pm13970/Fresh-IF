<?php
session_start();
if(empty($_SESSION)|| isset($_SESSION['customer']) || empty($_POST)){
    header("Location: product_admin.php");
}
    if(isset($_POST['id'])){
        $id = $_POST['id'];
    require_once("dbhelper.php");
        $sql = 'DELETE FROM product WHERE id ='.$id;
        execute($sql);
        echo 'Xóa sản phẩm thành công';
    }
?>