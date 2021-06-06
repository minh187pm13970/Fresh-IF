<?php
session_start();
if(empty($_SESSION)|| isset($_SESSION['admin']) || empty($_POST)){
    header("Location: product_admin.php");
}
    if(isset($_POST['id'])){
        $id = $_POST['id'];
    require_once("dbhelper.php");
        $sql = 'DELETE FROM cart WHERE id ='.$id;
        execute($sql);
        echo 'Xóa sản phẩm thành công';
    }
?>