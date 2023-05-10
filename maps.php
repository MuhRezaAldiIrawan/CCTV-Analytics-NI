<!DOCTYPE html>
<html> 
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Maps Jalan Toll</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/0ca54e6540.js" crossorigin="anonymous"></script>
  <link rel="icon" href="https://tolmakassar.com/apexnew/app-assets/img/Logo_MMN_JTSE.png">
  <script src="https://maps.google.com/maps/api/js?key=AIzaSyCgELFbsvJqa5gTNtLYGINwu8dJcjbVIbc" type="text/javascript"></script>
  <!-- <script src="https://maps.googleapis.com/maps/api/js?sensor=false&callback=myMap"></script> -->

  <!-- Automatic refresh page every 10 minutes -->
  
  <script>
        function autoRefresh() {
            window.location = window.location.href;
        }
        setInterval('autoRefresh()', 300000);
  </script>
  <style>
    .dropdown-menu {
      max-height: 600px;
      overflow-y: scroll;
    }
  </style>

</head> 

<body>
  
<nav class="navbar navbar-light bg-light fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand text-dark fw-semibold" href="/" style="font-size:30px;">
        <img src="https://tolmakassar.com/apexnew/app-assets/img/Logo_MMN_JTSE.png" alt="Logo" width="50" height="40" class="d-inline-block align-text-top">
          CCTV</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end text-bg-light" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
        <div class="offcanvas-header bg-light border-bottom rounded-4 border-secondary">
          <div class="dropstart">
            <button class="btn btn-light " type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-sharp fa-solid fa-bell"></i>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                0
                <span class="visually-hidden">unread messages</span>
              </span> 
            </button>
            <ul class="dropdown-menu">

              <!-- Pengkoneksian ke database untuk pembuatan notifikasi -->
              <?php
              $conn = new mysqli('192.168.0.66', 'admin', 'a1b2c3d4', 'jalan_toll');
                $query10 = $conn->query("
                SELECT * FROM data_pelanggaran ORDER BY ID DESC LIMIT 5 
                ");
  
                $result = array();
                while ($data7 = $query10 -> fetch_assoc()){
                  echo ("
                  <li>
                  <a  href='/detail_data' target='_blank' class='dropdown-item' role='button' style='height: auto; width:250px;' type='button' data-bs-placement='left' tabindex='0'  data-bs-toggle='popover' data-bs-trigger='hover' data-bs-title='Pelanggaran ".$data7['WAKTU']."'data-bs-content='".$data7['JENIS_PELANGGARAN']." di ".$data7['LOKASI']."'><span><i class='fa-sharp fa-solid fa-envelope' aria-pressed='true' ></i></span>".$data7['JENIS_PELANGGARAN']."<br><p>".$data7['LOKASI']."</p>
                ");
  
                if($data7['JENIS_PELANGGARAN'] == 'Melawan Arus') {
                  echo ("
                  <img src='/static/pelanggaran/".$data7['GAMBAR']."'
                  style='margin-left:16px;'
                  class='d-block w-100 h-75 rounded'
                  alt='...'/>
                  ");
                }
                elseif($data7['JENIS_PELANGGARAN'] == 'Over Speed') {
                  echo ("
                  <img src='/static/pelanggaran/".$data7['GAMBAR']."'
                  style='margin-left:16px;'
                  class='d-block w-100 h-75 rounded'
                  alt='...'/>
                
                  ");
                }
                
                else{
                  echo ("
                  <img src='/static/counting000/".substr($data7['project'], 11)."/person/".$data7['GAMBAR']."'
                  style='margin-left:16px;'
                  class='d-block w-100 h-75 rounded'
                  alt='...'/>
                ");
                }
                 echo ("</a>");
              echo ("</li>");
                };
               
              ?>
         
             </ul>
          </div>
          <h5 class="offcanvas-title fw-bold fs-3 " id="offcanvasDarkNavbarLabel ">CCTV</h5>
          <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas" aria-label="Close"></button> 
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link text-dark fw-semibold fs-5" aria-current="page" href="/#Counting">Counting</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark fw-semibold fs-5" href="/#pelanggaran">Pelanggaran</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark fw-semibold fs-5" href="maps" target="_blank">Peta</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-dark fw-semibold fs-5" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Data
              </a>
              <ul class="dropdown-menu dropdown-menu-secondary">
                <li><a class="dropdown-item fw-semibold" href="data_traffic" target="_blank">Counting</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item fw-semibold" href="data_pelanggaran" target="_blank">Pelanggaran</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <!--counting-->

  <h1 class="Counting" id="Counting" style="margin-top:80px"><center>Maps Data Lalu Lintas Hari Ini</center></h1>
  <center><div id="map" style="width: 1200px; height: 500px; margin-top: 10px; margin-left: 20px; margin-right: 20px;"></div></center>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" 
  integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
<script>

<?php 

$conn = new mysqli('localhost', 'root', '', 'jalan_toll');

// UNTUK JUMLAH PELANGGARAN
// Deklarasi variabel jumlah pelanggaran
// Area Off Ramp Rappokalling
$query = $conn->query("
SELECT COUNT(*) AS number_of_appearances 
    FROM data_pelanggaran
    WHERE DAY(WAKTU) = DAY(CURDATE()) and LOKASI = 'Off Ramp Rappokalling'");

$query2 = $conn->query("
SELECT COUNT(*) AS number_of_appearances 
    FROM data_pelanggaran
    WHERE DAY(WAKTU) = DAY(CURDATE()) and LOKASI = 'Off Ramp Rappokalling'");

foreach($query as $data){
  $pelanggaran_rappokalling[] = $data['number_of_appearances'];
}

// Deklarasi variabel jumlah pelanggaran
// Area Gerbang Tol Kaluku Badoa
$query7 = $conn->query("
SELECT COUNT(*) AS number_of_appearances2 
    FROM data_pelanggaran
    WHERE DAY(WAKTU) = DAY(CURDATE()) and LOKASI = 'Gerbang Tol Kaluku Badoa'");

$query8 = $conn->query("
SELECT COUNT(*) AS number_of_appearances2 
    FROM data_pelanggaran
    WHERE DAY(WAKTU) = DAY(CURDATE()) and LOKASI = 'Gerbang Tol Kaluku Badoa'");

foreach($query7 as $data2){
  $pelanggaran_kaluku_badoa[] = $data2['number_of_appearances2']; 
}

// Deklarasi variabel jumlah pelanggaran
// Area On Ramp Kaluku Badoa
$query13 = $conn->query("
SELECT COUNT(*) AS number_of_appearances3 
    FROM data_pelanggaran
    WHERE DAY(WAKTU) = DAY(CURDATE()) and LOKASI = 'On Ramp Kaluku Badoa'");

$query14 = $conn->query("
SELECT COUNT(*) AS number_of_appearances3 
    FROM data_pelanggaran
    WHERE DAY(WAKTU) = DAY(CURDATE()) and LOKASI = 'On Ramp Kaluku Badoa'");

foreach($query13 as $data8){
  $pelanggaran_rappokalling2[] = $data8['number_of_appearances3']; 
}



// UNTUK COUNTING KENDARAAN
// Deklarasi variabel jumlah kendaraan
// Area On Ramp Alauddin
$query3 = $conn->query("
SELECT SUM(TOTAL) as total
FROM on_ramp_pettarani
WHERE DAY(waktu_input) = DAY(CURRENT_DATE())");

$query4 = $conn->query("
SELECT SUM(TOTAL) as total
FROM on_ramp_pettarani
WHERE DAY(waktu_input) = DAY(CURRENT_DATE())");

foreach($query3 as $data3){
  $jumlah_on_ramp_pettarani[] = $data3['total'];
}

// Deklarasi variabel jumlah kendaraan
// Area On Ramp Ablam
$query5 = $conn->query("
SELECT SUM(TOTAL) as total2
FROM on_ramp_ablam
WHERE DAY(waktu_input) = DAY(CURRENT_DATE())");

$query6 = $conn->query("
SELECT SUM(TOTAL) as total2
FROM on_ramp_ablam
WHERE DAY(waktu_input) = DAY(CURRENT_DATE())");

foreach($query5 as $data4){
  $jumlah_on_ramp_ablam[] = $data4['total2'];
}

// Deklarasi variabel jumlah kendaraan
// Area Gerbang Kaluku Badoa
$query9 = $conn->query("
SELECT SUM(TOTAL) as total3
FROM grb_kalukubadoa
WHERE DAY(waktu_input) = DAY(CURRENT_DATE())");

$query10 = $conn->query("
SELECT SUM(TOTAL) as total3
FROM grb_kalukubadoa
WHERE DAY(waktu_input) = DAY(CURRENT_DATE())");

foreach($query9 as $data5){
  $jumlah_grb_kaluku_badoa[] = $data5['total3'];
}


// Deklarasi jika tidak ada data pelanggaran
if ($pelanggaran_rappokalling[] = null){
  $pelanggaran_rappokalling[] = [0];
}

if ($pelanggaran_kaluku_badoa[] = null){
  $pelanggaran_kaluku_badoa[] = [0];
}

?>

function initMap() {
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap'
    };
                    
    // Display a map on the web page
    map = new google.maps.Map(document.getElementById("map"), mapOptions);
    map.setTilt(50);

    // Add location
    var locations = [
      ['Gerbang Tol Kaluku Badoa', -5.117499135915403, 119.44175786972707],
      ['On Ramp Rappokalling', -5.129894348879903, 119.44061448951626],
      ['Off Ramp Rappokalling', -5.121935023337312, 119.44207769473527],
    ];

    var locations_counting = [
      ['On Ramp Abu Bakar Lambogo', -5.14201454396365, 119.4387834789535],
      ['On Ramp Alauddin',-5.1606939762353585, 119.43603160138542]
    ]

    var marker, i;
                        
    // Info window content untuk Pelanggaran
    var infoWindowContent = [
      ['<div class="info_content">' +
      '<h9 style="font-weight: bold; ">Gerbang Tol Kaluku Badoa</h9>' +
      '<p> Terjadi pelanggaran sebanyak <b><?php print_r($pelanggaran_kaluku_badoa[0]) ?></b> </p>' + 
      '<p> Jumlah kendaraan yang melalui <br>jalur ini adalah <b><?php print_r($jumlah_grb_kaluku_badoa[0]) ?></b> </p>'+  
      '<a href="/detail_data">Detail Pelanggaran</a>'+
      '</div>'],
      ['<div class="info_content">' +
      '<h9 style="font-weight: bold; ">On Ramp Rappokalling</h9>' +
      '<p> Terjadi pelanggaran sebanyak <b><?php print_r($pelanggaran_rappokalling[0]) ?></b> </p>' + 
      '<a href="/detail_data">Detail Pelanggaran</a>' + 
      '</div>'],
      ['<div class="info_content">' +
      '<h9 style="font-weight: bold; ">Off Ramp Rappokalling</h9>' +
      '<p> Terjadi pelanggaran sebanyak <b><?php print_r($pelanggaran_rappokalling2[0]) ?></b> </p>' + 
      '<a href="/detail_data">Detail Pelanggaran</a>' + 
      '</div>']
    ];

    // Info window content untuk Counting Kendaraan
    var infoWindowContentCounting = [
      ['<div class="info_content">' +
      '<h9 style="font-weight: bold; ">On Ramp Abu Bakar Lambogo</h9>' +
      '<p> Jumlah kendaraan yang melalui jalur <br> ini adalah <b><?php print_r($jumlah_on_ramp_ablam[0]) ?></b> </p>' + '</div>'],
      ['<div class="info_content">' +
      '<h9 style="font-weight: bold; ">On Ramp Alauddin</h9>' +
      '<p> Jumlah kendaraan yang melalui <br>jalur ini adalah <b><?php print_r($jumlah_on_ramp_pettarani[0]) ?></b> </p>' + '</div>']
    ];
        
    // Add multiple markers to map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Place each marker on the map 
    // Untuk lokasi pelanggaran
    for( i = 0; i < locations.length; i++ ) {
        var position = new google.maps.LatLng(locations[i][1], locations[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            label: locations[i][0],
            map: map,
            title: locations[i][0]
        });
    
        // Add info window to marker    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        infoWindow.setContent(infoWindowContent[i][0]);
        infoWindow.open(map, marker);

        // Center the map to fit all markers on the screen
        map.fitBounds(bounds);
    }

    // Untuk lokasi counting kendaraan
    for( j = 0; j < locations_counting.length; j++ ) {
    var position = new google.maps.LatLng(locations_counting[j][1], locations_counting[j][2]);
    bounds.extend(position);
    marker2 = new google.maps.Marker({
        position: position,
        label: locations_counting[j][0],
        map: map,
        title: locations_counting[j][0]
        });

    // Add info window to marker    
    google.maps.event.addListener(marker2, 'click', (function(marker2, j) {
    return function() {
        infoWindow.setContent(infoWindowContentCounting[j][0]);
        infoWindow.open(map, marker2);
        }
    })(marker2,j));

    // Center the map to fit all markers on the screen
    map.fitBounds(bounds);
    }

    // // Untuk lokasi counting kendaraan
    // for( i = 2; i < locations_counting.length; i++ ) {
    // var position = new google.maps.LatLng(locations_counting[i][1], locations_counting[i][2]);
    // bounds.extend(position);
    // marker2 = new google.maps.Marker({
    //     position: position,
    //     label: locations_counting[i][0],
    //     map: map,
    //     title: locations_counting[i][0]
    //     });

    // // Add info window to marker    
    // google.maps.event.addListener(marker2, 'click', (function(marker2, i) {
    // return function() {
    //     infoWindow.setContent(infoWindowContent[i+2][0]);
    //     infoWindow.open(map, marker2);
    //     }
    // })(marker2, i+2));

    // // Center the map to fit all markers on the screen
    // map.fitBounds(bounds);
    // }


    // Set zoom level
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
    this.setZoom(13);
    google.maps.event.removeListener(boundsListener);
    });

}

// Load initialize function
google.maps.event.addDomListener(window, 'load', initMap);
</script>

<script>
  const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
  const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
  const popover = new bootstrap.Popover('.popover-dismiss', {
    trigger: 'hover'
  })
</script>

</body>
</html>