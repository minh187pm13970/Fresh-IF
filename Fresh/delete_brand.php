<?php
session_start();
if(empty($_SESSION)|| isset($_SESSION['customer']) || empty($_POST)){
    header("Location: brand_admin.php");
}
    if(isset($_POST['id'])){
        $id = $_POST['id'];
    require_once("dbhelper.php");
        $sql = 'DELETE FROM brand WHERE id ='.$id;
        execute($sql);
        echo 'Xóa nhà sản xuất thành công';
    }
?>