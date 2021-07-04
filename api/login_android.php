<?php 

    include "../config.php";
    include "API_KEYS.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $api_key = $_POST['api_key'];
        $response = [];

        if($email == '' || $password == ''){
            $response['status'] = false;
            exit;
        }

        $api = new API_KEYS();

        if($api->check_api($api_key) == "OK"){
            $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE email = '$email' AND password = '$password' AND is_active = 1");
            $data = mysqli_num_rows($result);

            if($data > 0){
                while($d = mysqli_fetch_object($result)){
                    $response['status'] = true;
                    $response['data'][] = $d;
                }
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