<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPS Tracker | Tracking</title>
    <link rel="icon" type="image/png" href="image/map.png" sizes="128x128">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet' />
    <script src="js/script.js"></script>

</head>

<body>
    <?php
    include "config.php";
    session_start();
    if ($_SESSION['isLogin'] == false) {
        header("location:index.php");
    }


    if ($_SESSION['role'] == 'superadmin') {
        $data = mysqli_query($conn, "SELECT * FROM tb_gps INNER JOIN tb_user ON tb_gps.id_gps = tb_user.id_tracker");
    } else {
        $data = mysqli_query($conn, "SELECT * FROM tb_gps INNER JOIN tb_user ON tb_gps.id_gps = tb_user.id_tracker WHERE tb_user.id_user = '" . $_SESSION['id_user'] . "'");
    }

    ?>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: rgba(159, 200, 212,0.5)">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="image/map.png" alt="" width="30" height="30" class="d-inline-block align-text-top"> GPS Tracker

            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="main.php">Main</a>
                    </li>
                    <?php
                    if ($_SESSION['role'] == 'superadmin') {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="manage.php">Manage</a>
                        </li>
                    <?php } ?>
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
        <div class="row">
            <div id="map" style='width: 100vw; height: 100vh;'></div>
        </div>
    </div>

    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoiYW5kaWthZGF5dSIsImEiOiJja3FuOWhvdmswbGtmMnJwcXV3aTlqMGFqIn0.e9lqnGyCClWDmOmRqJAnFQ';
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [112.621391, -7.983908],
            zoom: 11.15
        });
        var nav = new mapboxgl.NavigationControl();
        map.addControl(nav);

        map.on('load', function() {
            // Add an image to use as a custom marker
            map.loadImage(
                'https://docs.mapbox.com/mapbox-gl-js/assets/custom_marker.png',
                function(error, image) {
                    if (error) throw error;
                    map.addImage('custom-marker', image);
                    // Add a GeoJSON source with 2 points
                    map.addSource('points', {
                        'type': 'geojson',
                        'data': {
                            'type': 'FeatureCollection',
                            'features': [
                                <?php while ($location = mysqli_fetch_assoc($data)) {
                                    $dates = date_create($location['update_at']); ?> {

                                        'type': 'Feature',
                                        'geometry': {
                                            'type': 'Point',
                                            'coordinates': [
                                                <?php echo $location['lng']; ?>, <?php echo $location['lat']; ?>
                                            ]
                                        },
                                        'properties': {
                                            'title': '<?php echo $location['nama']; ?>',
                                            'description': "<b>GPS Tracker</b><br><b>Nama: </b><?php echo $location['nama']; ?><br><b>Time: </b><?php echo date_format($dates, 'd-M-Y H:i:s'); ?>"
                                        }



                                    },
                                <?php } ?>

                            ]
                        }
                    });

                    // Add a symbol layer
                    map.addLayer({
                        'id': 'points',
                        'type': 'symbol',
                        'source': 'points',
                        'layout': {
                            'icon-image': 'custom-marker',
                            // get the title name from the source's "title" property
                            'text-field': ['get', 'title'],
                            'text-font': [
                                'Open Sans Semibold',
                                'Arial Unicode MS Bold'
                            ],
                            'text-offset': [0, 1.25],
                            'text-anchor': 'top'
                        }
                    });

                    var popup = new mapboxgl.Popup({
                        closeButton: false,
                        closeOnClick: false
                    });

                    map.on('mouseenter', 'points', function(e) {
                        map.getCanvas().style.cursor = 'pointer';

                        var coordinates = e.features[0].geometry.coordinates.slice();
                        var description = e.features[0].properties.description;

                        // Ensure that if the map is zoomed out such that multiple
                        // copies of the feature are visible, the popup appears
                        // over the copy being pointed to.
                        while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                            coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                        }

                        // Populate the popup and set its coordinates
                        // based on the feature found.

                        console.log(coordinates[0] + "," + coordinates[1]);

                        getAddress(coordinates[1], coordinates[0], description, map, coordinates, popup);

                    });

                    map.on('mouseleave', 'points', function() {
                        map.getCanvas().style.cursor = '';
                        popup.remove();
                    });
                }
            );
        });
    </script>


</body>

</html>