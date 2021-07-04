<?php 
    include "../config.php";
    include "API_KEYS.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $api_key = $_POST['api_key'];
        $id = $_POST['id'];
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];
        $tgl = date('Y-m-d H:i:s');
        $response = [];

        $api = new API_KEYS();

        if($api->check_api($api_key) == "OK"){
            
            $cek = mysqli_query($conn, "SELECT * FROM tb_gps WHERE id_gps='$id'");
            if(mysqli_num_rows($cek) > 0){
                $sql = "UPDATE tb_gps SET lat='$lat',lng='$lng',update_at='$tgl' WHERE id_gps='$id'";
                $response['status'] = true;
            }else{
                $response['status'] = false;
            }

            $save = mysqli_query($conn,$sql);   
    
            if(!$save){
                $response['status'] = false;
            }
            
        }else{
            $response['status'] = false;
        }

        echo json_encode($response,JSON_PRETTY_PRINT);
        
        $conn->close();

    }


    
?>