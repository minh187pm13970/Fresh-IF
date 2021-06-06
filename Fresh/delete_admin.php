<?php
session_start();
if(empty($_SESSION)|| isset($_SESSION['customer']) || empty($_POST)){
    header("Location: list_admin.php");
}
    if(isset($_POST['id'])){
        $id = $_POST['id'];
    require_once("dbhelper.php");
        $sql = 'DELETE FROM admin WHERE id ='.$id;
        execute($sql);
        echo 'Xóa Admin thành công';
    }
?>