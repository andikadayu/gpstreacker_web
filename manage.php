<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPS Tracker | Tracking</title>
    <link rel="icon" type="image/png" href="image/map.png" sizes="128x128">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>


</head>

<body>
    <?php
    include "config.php";
    session_start();
    if($_SESSION['isLogin'] == false){
        header("location:index.php");
    }

    if($_SESSION['role'] != 'superadmin'){
        header("location:main.php");
    }

    if($_SERVER['HTTPS']!="on") {
    $redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    header("Location:$redirect");
    }
    

    $data = mysqli_query($conn,"SELECT * FROM tb_gps");

    ?>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: rgba(159, 200, 212,0.5)">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="image/map.png" alt="" width="30" height="30"
                    class="d-inline-block align-text-top"> GPS Tracker

            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link " href="main.php">Main</a>
                    </li>
                    <?php 
                        if($_SESSION['role'] == 'superadmin'){
                    ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="manage.php">Manage</a>
                    </li>
                    <?php }?>
                    <li class="nav-item ">
                        <a class="nav-link" href="api/logout.php" tabindex="-1" aria-disabled="true">Logout [
                            <?php echo $_SESSION['nama']; ?>]
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <br>
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Data User
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="datatables">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no = 1;
                                    $query = mysqli_query($conn,"SELECT * FROM tb_user");
                                    while($d = mysqli_fetch_assoc($query)){
                                        ?>
                                    <tr>
                                        <td>
                                            <?php echo $no++;?>
                                        </td>
                                        <td>
                                            <?php echo $d['nama'];  ?>
                                        </td>
                                        <td>
                                            <?php echo $d['email'];?>
                                        </td>
                                        <td>
                                            <?php echo $d['role'];?>
                                        </td>
                                        <td>
                                            <?php if($d['is_active'] == 0){ echo "<span class='badge bg-danger'>Inacive</span>";}else{ echo "<span class='badge bg-success'>Active</span>"; }?>
                                        </td>
                                        <td>
                                            <?php 
                                                    if($d['is_active'] == 0 && $d['role'] == 'user'){
                                                        echo "<button class='btn btn-warning btn-sm' onclick='activates(".$d['id_user'].")'>Activate</button>";
                                                    }

                                                    if($d['is_active'] == 1 && $d['role'] == 'user'){
                                                        echo "<button class='btn btn-primary btn-sm' onclick='deactivates(".$d['id_user'].")'>Deactivate</button>";
                                                    }

                                                     echo "<button class='btn btn-secondary btn-sm' data-bs-toggle='modal' data-bs-target='#exampleModal' onclick='change(".$d['id_user'].")'>Change Password</button>";
                                                ?>
                                            <button class="btn btn-danger btn-sm"
                                                onclick="deletes(<?php echo $d['id_user'];?>)">Delete</button>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    $conn->close();
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-2"></div>
        </div>

        <!-- Modal Add  -->
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form autocomplete="off" id="change_password" aria-autocomplete="none"
                            onsubmit="change_password();return false;">
                            <input type="hidden" name="change" value="change">
                            <input type="hidden" id="id_user" name="id_user">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nama" placeholder="Nama" name="nama"
                                    required aria-required="true" readonly aria-readonly="true">
                                <label for="nama">Nama</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" placeholder="Password"
                                    name="password" required aria-required="true">
                                <label for="password">Password</label>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="change_password();">Save changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- End Modal  -->

    </div>


    <script>
        $(document).ready(function () {
            $("#datatables").DataTable();
        })

        function activates(id) {
            var r = confirm("Are you sure to activate this?");
            if (r == true) {
                $.ajax({
                    url: 'api/manage_api.php',
                    method: 'GET',
                    data: {
                        id: id,
                        propose: 'activate'
                    },
                }).done(function (data) {
                    if (data == 'success') {
                        location.reload();
                    } else {
                        alert('Error Action');
                    }
                })
            }
        }

        function deactivates(id) {
            var r = confirm("Are you sure to deactivate this?");
            if (r == true) {
                $.ajax({
                    url: 'api/manage_api.php',
                    method: 'GET',
                    data: {
                        id: id,
                        propose: 'deactivate'
                    },
                }).done(function (data) {
                    if (data == 'success') {
                        location.reload();
                    } else {
                        alert('Error Action');
                    }
                })
            }
        }

        function deletes(id) {
            var r = confirm("Are you sure to delete this?");
            if (r == true) {
                $.ajax({
                    url: 'api/manage_api.php',
                    method: 'GET',
                    data: {
                        id: id,
                        propose: 'deletes'
                    },
                }).done(function (data) {
                    if (data == 'success') {
                        location.reload();
                    } else {
                        alert(data);
                    }
                })
            }
        }

        function change(id) {
            $.ajax({
                url: 'api/admin_manage.php',
                method: 'GET',
                data: {
                    propose: 'get',
                    id: id,
                },
                dataType: 'json',
            }).done(function (response) {
                $('#id_user').val(response.id_user),
                    $('#nama').val(response.nama)
            })
        }

        function change_password() {
            $.ajax({
                url: 'api/admin_manage.php',
                method: 'GET',
                data: {
                    propose: 'change',
                    id: $('#id_user').val(),
                    pass: $('#password').val()
                }

            }).done(function (data) {
                if (data == 'success') {
                    alert("Change Password Success");
                    location.reload();
                } else {
                    alert(data);
                }
            })
        }

    </script>
</body>

</html>