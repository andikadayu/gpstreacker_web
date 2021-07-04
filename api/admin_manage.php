<?php 
include '../config.php';
    if($_GET['propose'] == 'get'){
        $data = [];
        $id = $_GET['id'];
        $sql = mysqli_query($conn,"SELECT id_user,nama FROM tb_user WHERE id_user='".$id."'");
        while($d = mysqli_fetch_assoc($sql)){
            $data = $d;
        }

        echo json_encode($data);
    }

    if($_GET['propose'] == 'change'){
        $id = $_GET['id'];
        $pass = md5($_GET['pass']);
        $sql = mysqli_query($conn,"UPDATE tb_user SET password='$pass' WHERE id_user='$id'");
        if($sql){
            echo 'success';
        }else{
            echo mysqli_error($conn);
        }
    }



?>