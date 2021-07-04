<?php 

	include '../config.php';
    include "API_KEYS.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $id = $_POST['id'];
        $propose = $_POST['propose'];
        $tgl = date('Y-m-d H:i:s');
        $api_key = $_POST['api_key'];

         $api = new API_KEYS();

        if($api->check_api($api_key) == "OK"){
        
            if($propose == 'activate'){

                $s = 0;
                $sql2 = mysqli_query($conn,"SELECT * FROM tb_user WHERE id_user = $id LIMIT 1");
                while($d = mysqli_fetch_assoc($sql2)){
                    if($d['id_tracker'] != NULL || $d['id_tracker'] != ''){
                        $s=1;
                    }

                }
                
                $sql = mysqli_query($conn,"UPDATE tb_user SET is_active=1 WHERE id_user = $id");

                if($s = 1){
                    $sql1 = mysqli_query($conn,"INSERT INTO tb_gps VALUES(NULL,	'-7.983908','112.621391','$tgl')");
                    if($sql1){
                        mysqli_query($conn,"UPDATE tb_user SET id_tracker=".mysqli_insert_id($conn)." WHERE id_user = $id");
                    }
                }
        
    
                if($sql){
                    $data['status'] = true;
                }else{
                    $data['status'] = false;
                }
            }else if($propose == 'get'){
                $sql = mysqli_query($conn,"SELECT * FROM tb_user");
                while($row = mysqli_fetch_object($sql)){
                    $data['status'] = true;
                    $data['result'][] = $row;
                }
                
            }else if($propose == 'deletes'){
                $sql1 = mysqli_query($conn,"SELECT * FROM tb_user WHERE id_user = $id");
                while($d = mysqli_fetch_assoc($sql1)){
                    if($d['id_tracker'] != NULL){
                        mysqli_query($conn,"DELETE FROM tb_gps WHERE id_gps='".$d['id_tracker']."'");
                        $sql = mysqli_query($conn,"DELETE FROM tb_user WHERE id_user = $id");
                    }else{
                        $sql = mysqli_query($conn,"DELETE FROM tb_user WHERE id_user = $id");
                    }
                }
    
                if($sql){
                   $data['status'] = true;
                }else{
                    $data['status'] = false;
                }
            }
        }else{
             $data['status'] = false;
        }
    
        echo json_encode($data,JSON_PRETTY_PRINT);

        $conn->close();
    }




?>