<?php 
	
    include '../config.php';

    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = mysqli_query($conn,"INSERT INTO tb_user VALUES(NULL,'$nama','$email','$password','user',0,NULL)");

    if($sql){
        echo "<script>alert('Register Successfull, wait for approval');location.href = '../index.php';</script>";
    }else{
        echo "<script>alert('Error Register');location.href = '../register.php';</script>";
    }


?>