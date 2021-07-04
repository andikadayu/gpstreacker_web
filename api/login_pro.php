<?php
    include '../config.php';
    
    session_start();
    
    $email = $_POST['email'];
    $pass = md5($_POST['password']);


    $data = mysqli_query($conn,"SELECT * FROM tb_user WHERE email = '$email' AND password = '$pass' AND is_active = 1");

    $cek = mysqli_num_rows($data);

    if($cek > 0){
        while($d = mysqli_fetch_assoc($data)){
            $_SESSION['nama'] = $d['nama'];
            $_SESSION['isLogin'] = true;
            $_SESSION['id_user'] = $d['id_user'];
            $_SESSION['role'] = $d['role'];
        }
        echo "<script>alert('Login Sukses'); location.href = '../main.php';</script>";
    }else{
        echo "<script>alert('Username/Password Salah!');location.href = '../index.php';</script>";
    }
    
    $conn->close();

?>