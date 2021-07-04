<?php 

	include '../config.php';

	$id = $_GET['id'];
	$propose = $_GET['propose'];
	$tgl = date('Y-m-d H:i:s');

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
	}else if($propose == 'deactivate'){
		$sql = mysqli_query($conn,"UPDATE tb_user SET is_active=0 WHERE id_user = $id");
	}else{
		$sql1 = mysqli_query($conn,"SELECT * FROM tb_user WHERE id_user = $id");
		while($d = mysqli_fetch_assoc($sql1)){
			if($d['id_tracker'] != NULL){
				mysqli_query($conn,"DELETE FROM tb_gps WHERE id_gps='".$d['id_tracker']."'");
				$sql = mysqli_query($conn,"DELETE FROM tb_user WHERE id_user = $id");
			}else{
				$sql = mysqli_query($conn,"DELETE FROM tb_user WHERE id_user = $id");
			}
		}
	}

	if($sql){
		echo 'success';
	}else{
		echo mysqli_error($conn);
	}

	$conn->close();


?>