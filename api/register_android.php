<?php 

    include "../config.php";
    include "API_KEYS.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $api_key = $_POST['api_key'];
        $response = [];

        if($nama == '' || $password == '' || $email == ''){
            $response['status'] = false;
            exit;
        }

        $api = new API_KEYS();

        if($api->check_api($api_key) == "OK"){
            $result = mysqli_query($conn, "INSERT INTO tb_user VALUES(NULL,'$nama','$email','$password','user',0,NULL)");

            if($result){
                $response['status'] = true;
            }else{
                $response['status'] = false;
            }
            
        }else{
            $response['status'] = false;
        }

        echo json_encode($response,JSON_PRETTY_PRINT);
        
        $conn->close();

    }

?>