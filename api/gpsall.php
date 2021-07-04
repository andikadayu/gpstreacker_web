<?php 

    include "../config.php";
    include "API_KEYS.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $api_key = $_POST['api_key'];


        $api = new API_KEYS();

        if($api->check_api($api_key) == "OK"){
            
            $sql = mysqli_query($conn, "SELECT * FROM tb_gps INNER JOIN tb_user ON tb_user.id_tracker = tb_gps.id_gps");
             
            while($row = mysqli_fetch_object($sql)){
                $data['status'] = true;
                $data['result'][] = $row;
            }
            echo json_encode($data,JSON_PRETTY_PRINT);
            
            
        }else{
            echo "fail";
        }
        
        $conn->close();

    }



?>