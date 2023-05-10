<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Data Pelanggaran</title>
    <!-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/nucleo-icons.css">
    <link rel="stylesheet" href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/nucleo-svg.css">
    <link rel="stylesheet" href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/soft-ui-dashboard.min.css?v=1.0.2">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <link rel="stylesheet" href="./assets/css/loopple/loopple.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/0ca54e6540.js" crossorigin="anonymous"></script>
    <link rel="icon" href="https://tolmakassar.com/apexnew/app-assets/img/Logo_MMN_JTSE.png">
    
    <style>
      .chartjs-table, th, td{

        border-collapse : collapse;
        border: 1px solid #67748E;
        padding: 10px;
        margin-left:20px;
        font-size:12px;
      }

      .chartjs-thead {
        font-weight : bold; 
      }
      .dropdown-menu {
        max-height: 600px;
        overflow-y: scroll;
      }
      .chartjs-body {
        text-align : center;
      }
    </style>

    <!-- Automatic refresh page every 10 minutes -->
    <script>
        function autoRefresh() {
            window.location = window.location.href;
        }
        setInterval('autoRefresh()', 60000);
    </script>

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
                5
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
                <a class='dropdown-item' role='button' style='height: auto; width:250px;' type='button' data-bs-placement='left' tabindex='0'  data-bs-toggle='popover' data-bs-trigger='hover' data-bs-title='Pelanggaran ".$data7['WAKTU']."'data-bs-content='".$data7['JENIS_PELANGGARAN']." di ".$data7['LOKASI']."'><span><i class='fa-sharp fa-solid fa-envelope' aria-pressed='true' ></i></span>".$data7['JENIS_PELANGGARAN']."<br><p>".$data7['LOKASI']."</p>
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

            <div class="container-fluid" style="margin-bottom:20px;">
                <div class="row align-items-center justify-content-lg-between" style="margin-top:100px">
                    <div class="col-lg-6">
                        <ul class="nav nav-footer justify-content-center justify-content-lg-start">
                            <li class="nav-item">
                                <b><a href="javascript:;" style="color:black; text-decoration: none;"><h7 class="font-weight-bolder mb-0">Data Pelanggaran Lalu Lintas</h6></a></b>
                            </li>
                            <li class="nav-item" style="margin-left:15px">
                                <a href="data_traffic" style="color:black; text-decoration: none;"><h7>Data Traffic Lalu Lintas</h6></a>
                            </li>
                        </ul>
                    </div><br>
                    <div class="col-lg-5"></div>
                    <div class="col-lg-1">
                    <button onclick=refreshPage() type="button" class="btn btn-warning float-right ml-2">Refresh</button>
                    </div>
                </div>
            </div>
    
          <div class="main-content" id="panel">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Data Bulanan Pelanggaran</h6>
                    <!-- <p class="text-sm">
                        <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
                        <span class="font-weight-bold">4% more</span> in 2021
                    </p> -->
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="chart-line" class="chart-canvas chartjs-render-monitor" height="375" width="1035" style="display: block; height: 300px; width: 828px; box-sizing: border-box;"></canvas>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Data Bulanan Pelanggaran</h6>
                    <!-- <p class="text-sm">
                        <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
                        <span class="font-weight-bold">4% more</span> in 2021
                    </p> -->
                </div>
                <div class="card-body p-3">
                    <div class="chart1">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="chart-line4" class="chart-canvas chartjs-render-monitor" height="375" width="1035" style="display: block; height: 300px; width: 828px; box-sizing: border-box;"></canvas>
                    </div>
                </div>
            </div>

            <div class="row removable">
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Jumlah Pelanggaran Kemarin</h6>
                            <!-- <p class="text-sm">
                                <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
                                <span class="font-weight-bold">4% more</span> in 2021
                            </p> -->
                        </div>
                        <div class="card-body p-3">
                            <div class="chart2">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <canvas id="chart-line1" class="chart-canvas chartjs-render-monitor" height="600" width="1582" style="display: block; height: 300px; width: 791px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Jumlah Pelanggaran Hari Ini</h6>
                            <!-- <p class="text-sm">
                                <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
                                <span class="font-weight-bold">4% more</span> in 2021
                            </p> -->
                        </div>
                        <div class="card-body p-3">
                            <div class="chart3">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <canvas id="chart-line2" class="chart-canvas chartjs-render-monitor" height="600" width="1582" style="display: block; height: 300px; width: 791px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer pt-3 pb-4">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6 mb-lg-0 mb-4">
                        <div class="copyright text-center text-sm text-muted text-lg-start">
                            © 2021,
                            made with
                            <a href="https://www.creative-tim.com/product/soft-ui-dashboard" class="font-weight-bold text-capitalize" target="_blank"> Soft UI Dashboard</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                            <li class="nav-item">
                                <a href="javascript:;" class="nav-link text-muted" target="_blank">Creative Tim</a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:;" class="nav-link text-muted" target="_blank">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:;" class="nav-link text-muted" target="_blank">Blog</a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:;" class="nav-link pe-0 text-muted" target="_blank">License</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src="https://demos.creative-tim.com/soft-ui-dashboard/assets/js/core/popper.min.js"></script>
    <!-- <script src="https://demos.creative-tim.com/soft-ui-dashboard/assets/js/core/bootstrap.min.js"></script> -->
    <script src="https://demos.creative-tim.com/soft-ui-dashboard/assets/js/plugins/chartjs.min.js"></script>
    <script src="https://demos.creative-tim.com/soft-ui-dashboard/assets/js/plugins/Chart.extension.js"></script>
    <script src="https://demos.creative-tim.com/soft-ui-dashboard/assets/js/soft-ui-dashboard.min.js?v=1.0.2"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    
    <script>
    function refreshPage(){
    window.location.reload();
    }
    </script>

    <?php 

    $jam = null;
    $jumlah = null;

    $jam_yesterday = null;
    $jumlah_yesterday = null;

    $day_bulanan = null;
    $jumlah_bulanan = null;

    // koneksi ke database
    $conn = new mysqli('192.168.0.66', 'admin', 'a1b2c3d4', 'jalan_toll');
    $query = $conn->query("
    SELECT
        HOUR(WAKTU) AS hour,
        COUNT(*) AS number_of_appearances
      FROM data_pelanggaran
    WHERE DAY(WAKTU) = DAY(CURDATE()) AND MONTH(waktu) = month(now())
    GROUP BY HOUR(WAKTU)
    ");

    foreach($query as $data)
    {
        $jam[] = $data['hour'];
        $jumlah[] = $data['number_of_appearances'];

    }

    $query = $conn->query("
    SELECT 
      DAY(WAKTU) AS day, 
      HOUR(WAKTU) AS hour2, 
      COUNT(*) AS number_of_appearances2
	    FROM data_pelanggaran
    WHERE DAY(WAKTU) = DAY(CURDATE()) - 1 AND MONTH(waktu) = month(now())
    GROUP BY HOUR(WAKTU)
    ");

    foreach($query as $datadua)
    {
        $jam_yesterday[] = $datadua['hour2'];
        $jumlah_yesterday[] = $datadua['number_of_appearances2'];
    }

    $query = $conn->query("
    SELECT DAY(WAKTU) AS day, 
      COUNT(*) AS number_of_appearances3
	    FROM data_pelanggaran
    WHERE MONTH(WAKTU) = MONTH(CURDATE())
    GROUP BY DAY(WAKTU)
    ");

    foreach($query as $datatiga)
    {
        $day_bulanan[] = $datatiga['day'];
        $jumlah_bulanan[] = $datatiga['number_of_appearances3'];
    }
    
    ?>
    <script>
           if (document.querySelector("#chart-line")) {
           	var ctx2 = document.getElementById("chart-line").getContext("2d");
           	var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);
           	gradientStroke1.addColorStop(1, "rgba(203,12,159,0.2)");
           	gradientStroke1.addColorStop(0.2, "rgba(72,72,176,0.0)");
           	gradientStroke1.addColorStop(0, "rgba(203,12,159,0)");
           	var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);
           	gradientStroke2.addColorStop(1, "rgba(20,23,39,0.2)");
           	gradientStroke2.addColorStop(0.2, "rgba(72,72,176,0.0)");
           	gradientStroke2.addColorStop(0, "rgba(20,23,39,0)");
            const data = {
                labels: <?php echo json_encode($jam_yesterday) ?>,
                datasets: [{
                    label: "Hari ini",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#3A416F",
                    borderWidth: 3,
                    backgroundColor: gradientStroke2,
                    fill: true,
                    data: <?php echo json_encode($jumlah_yesterday) ?>,
                    maxBarThickness: 6
                  },{
                    label: "Kemarin",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#cb0c9f",
                    borderWidth: 3,
                    backgroundColor: gradientStroke1,
                    fill: true,
                    data: <?php echo json_encode($jumlah) ?>,
                    maxBarThickness: 6
                  },
                ],
              }
           	new Chart(ctx2, {
              type: "line",
              data,
              options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                  legend: {
                    display: false,
                  }
                },
                interaction: {
                  intersect: false,
                  mode: 'index',
                },
                scales: {
                  y: {
                    grid: {
                      drawBorder: false,
                      display: true,
                      drawOnChartArea: true,
                      drawTicks: false,
                      borderDash: [5, 5]
                    },
                    ticks: {
                      display: true,
                      padding: 10,
                      color: '#b2b9bf',
                      font: {
                        size: 11,
                        family: "Open Sans",
                        style: 'normal',
                        lineHeight: 2
                      },
                    }
                  },
                  x: {
                    grid: {
                      drawBorder: false,
                      display: false,
                      drawOnChartArea: false,
                      drawTicks: false,
                      borderDash: [5, 5]
                    },
                    ticks: {
                      display: true,
                      color: '#b2b9bf',
                      padding: 20,
                      font: {
                        size: 11,
                        family: "Open Sans",
                        style: 'normal',
                        lineHeight: 2
                      },
                    }
                  },
                },
              },
            });
            function createTable(){
              console.log('triggered');
              const chart = document.querySelector('.chart');
              const tableDiv = document.createElement('DIV');
              tableDiv.setAttribute('id', 'tableDiv'); //menambahkan ID

              const table = document.createElement('TABLE');
              table.classList.add('chartjs-table');

              // add table head (thead)
              const thead = table.createTHead();
              thead.classList.add('chartjs-thead');

              thead.insertRow(0);
              console.log(data.labels)
              for(let i = 0; i < data.labels.length; i++) {
                thead.rows[0].insertCell(i).innerText = data.labels[i];
                
              };
              thead.rows[0].insertCell(0).innerText = 'Tanggal'

              // add table body
              const tbody = table.createTBody();
              thead.classList.add('chartjs-tbody');
              console.log(data.datasets)
              data.datasets.map((dataset,index) => {
                tbody.insertRow(index);
                for(let i = 0; i < data.datasets[0].data.length; i++){
                  tbody.rows[index].insertCell(i).innerText = dataset.data[i];
                };
                tbody.rows[index].insertCell(0).innerText = dataset.label;
              })

              
              // append
              chart.appendChild(tableDiv);
              tableDiv.appendChild(table);
              }

              createTable();

           };

           if (document.querySelector("#chart-line4")) {
           	var ctx2 = document.getElementById("chart-line4").getContext("2d");
           	var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);
           	gradientStroke1.addColorStop(1, "rgba(203,12,159,0.2)");
           	gradientStroke1.addColorStop(0.2, "rgba(72,72,176,0.0)");
           	gradientStroke1.addColorStop(0, "rgba(203,12,159,0)");
           	var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);
           	gradientStroke2.addColorStop(1, "rgba(20,23,39,0.2)");
           	gradientStroke2.addColorStop(0.2, "rgba(72,72,176,0.0)");
           	gradientStroke2.addColorStop(0, "rgba(20,23,39,0)");
            const data = {
                labels: <?php echo json_encode($day_bulanan) ?>,
                datasets: [{
                    label: "Pelanggaran",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#cb0c9f",
                    borderWidth: 3,
                    backgroundColor: gradientStroke1,
                    fill: true,
                    data: <?php echo json_encode($jumlah_bulanan) ?>,
                    maxBarThickness: 6
        
                  },
                ],
              }
           	new Chart(ctx2, {
              type: "line",
              data,
              options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                  legend: {
                    display: false,
                  }
                },
                interaction: {
                  intersect: false,
                  mode: 'index',
                },
                scales: {
                  y: {
                    grid: {
                      drawBorder: false,
                      display: true,
                      drawOnChartArea: true,
                      drawTicks: false,
                      borderDash: [5, 5]
                    },
                    ticks: {
                      display: true,
                      padding: 10,
                      color: '#b2b9bf',
                      font: {
                        size: 11,
                        family: "Open Sans",
                        style: 'normal',
                        lineHeight: 2
                      },
                    }
                  },
                  x: {
                    grid: {
                      drawBorder: false,
                      display: false,
                      drawOnChartArea: false,
                      drawTicks: false,
                      borderDash: [5, 5]
                    },
                    ticks: {
                      display: true,
                      color: '#b2b9bf',
                      padding: 20,
                      font: {
                        size: 11,
                        family: "Open Sans",
                        style: 'normal',
                        lineHeight: 2
                      },
                    }
                  },
                },
              },
            });
            function createTable(){
              console.log('triggered');
              const chart = document.querySelector('.chart1');
              const tableDiv = document.createElement('DIV');
              tableDiv.setAttribute('id', 'tableDiv'); //menambahkan ID

              const table = document.createElement('TABLE');
              table.classList.add('chartjs-table');

              // add table head (thead)
              const thead = table.createTHead();
              thead.classList.add('chartjs-thead');

              thead.insertRow(0);
              console.log(data.labels)
              for(let i = 0; i < data.labels.length; i++) {
                thead.rows[0].insertCell(i).innerText = data.labels[i];
                
              };
              thead.rows[0].insertCell(0).innerText = 'Tanggal'

              // add table body
              const tbody = table.createTBody();
              thead.classList.add('chartjs-tbody');
              console.log(data.datasets)
              data.datasets.map((dataset,index) => {
                tbody.insertRow(index);
                for(let i = 0; i < data.datasets[0].data.length; i++){
                  tbody.rows[index].insertCell(i).innerText = dataset.data[i];
                };
                tbody.rows[index].insertCell(0).innerText = dataset.label;
              })

              
              // append
              chart.appendChild(tableDiv);
              tableDiv.appendChild(table);
              }

              createTable();
           };

           if (document.querySelector("#chart-line1")) {
           	var ctx2 = document.getElementById("chart-line1").getContext("2d");
           	var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);
           	gradientStroke1.addColorStop(1, "rgba(203,12,159,0.2)");
           	gradientStroke1.addColorStop(0.2, "rgba(72,72,176,0.0)");
           	gradientStroke1.addColorStop(0, "rgba(203,12,159,0)");
           	var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);
           	gradientStroke2.addColorStop(1, "rgba(20,23,39,0.2)");
           	gradientStroke2.addColorStop(0.2, "rgba(72,72,176,0.0)");
           	gradientStroke2.addColorStop(0, "rgba(20,23,39,0)");
            const data = {
                labels: <?php echo json_encode($jam) ?>,
                datasets: [{
                    label: "Pelanggaran",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#cb0c9f",
                    borderWidth: 3,
                    backgroundColor: gradientStroke1,
                    fill: true,
                    data: <?php echo json_encode($jumlah) ?>,
                    maxBarThickness: 6
        
                  },
                ],
              }
           	new Chart(ctx2, {
              type: "line",
              data,
              options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                  legend: {
                    display: false,
                  }
                },
                interaction: {
                  intersect: false,
                  mode: 'index',
                },
                scales: {
                  y: {
                    grid: {
                      drawBorder: false,
                      display: true,
                      drawOnChartArea: true,
                      drawTicks: false,
                      borderDash: [5, 5]
                    },
                    ticks: {
                      display: true,
                      padding: 10,
                      color: '#b2b9bf',
                      font: {
                        size: 11,
                        family: "Open Sans",
                        style: 'normal',
                        lineHeight: 2
                      },
                    }
                  },
                  x: {
                    grid: {
                      drawBorder: false,
                      display: false,
                      drawOnChartArea: false,
                      drawTicks: false,
                      borderDash: [5, 5]
                    },
                    ticks: {
                      display: true,
                      color: '#b2b9bf',
                      padding: 20,
                      font: {
                        size: 11,
                        family: "Open Sans",
                        style: 'normal',
                        lineHeight: 2
                      },
                    }
                  },
                },
              },
            });
            function createTable(){
              console.log('triggered');
              const chart = document.querySelector('.chart2');
              const tableDiv = document.createElement('DIV');
              tableDiv.setAttribute('id', 'tableDiv'); //menambahkan ID

              const table = document.createElement('TABLE');
              table.classList.add('chartjs-table');

              // add table head (thead)
              const thead = table.createTHead();
              thead.classList.add('chartjs-thead');

              thead.insertRow(0);
              console.log(data.labels)
              for(let i = 0; i < data.labels.length; i++) {
                thead.rows[0].insertCell(i).innerText = data.labels[i];
                
              };
              thead.rows[0].insertCell(0).innerText = 'Jam'

              // add table body
              const tbody = table.createTBody();
              thead.classList.add('chartjs-tbody');
              console.log(data.datasets)
              data.datasets.map((dataset,index) => {
                tbody.insertRow(index);
                for(let i = 0; i < data.datasets[0].data.length; i++){
                  tbody.rows[index].insertCell(i).innerText = dataset.data[i];
                };
                tbody.rows[index].insertCell(0).innerText = dataset.label;
              })

              
              // append
              chart.appendChild(tableDiv);
              tableDiv.appendChild(table);
              }

              createTable();
           };

           if (document.querySelector("#chart-line2")) {
           	var ctx2 = document.getElementById("chart-line2").getContext("2d");
           	var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);
           	gradientStroke1.addColorStop(1, "rgba(203,12,159,0.2)");
           	gradientStroke1.addColorStop(0.2, "rgba(72,72,176,0.0)");
           	gradientStroke1.addColorStop(0, "rgba(203,12,159,0)");
           	var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);
           	gradientStroke2.addColorStop(1, "rgba(20,23,39,0.2)");
           	gradientStroke2.addColorStop(0.2, "rgba(72,72,176,0.0)");
           	gradientStroke2.addColorStop(0, "rgba(20,23,39,0)");
            const data = {
                labels: <?php echo json_encode($jam_yesterday) ?>,
                datasets: [{
                    label: "Pelanggaran",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#3A416F",
                    borderWidth: 3,
                    backgroundColor: gradientStroke2,
                    fill: true,
                    data: <?php echo json_encode($jumlah_yesterday) ?>,
                    maxBarThickness: 6
        
                  },
                ],
              }
           	new Chart(ctx2, {
              type: "line",
              data,
              options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                  legend: {
                    display: false,
                  }
                },
                interaction: {
                  intersect: false,
                  mode: 'index',
                },
                scales: {
                  y: {
                    grid: {
                      drawBorder: false,
                      display: true,
                      drawOnChartArea: true,
                      drawTicks: false,
                      borderDash: [5, 5]
                    },
                    ticks: {
                      display: true,
                      padding: 10,
                      color: '#3A416F',
                      font: {
                        size: 11,
                        family: "Open Sans",
                        style: 'normal',
                        lineHeight: 2
                      },
                    }
                  },
                  x: {
                    grid: {
                      drawBorder: false,
                      display: false,
                      drawOnChartArea: false,
                      drawTicks: false,
                      borderDash: [5, 5]
                    },
                    ticks: {
                      display: true,
                      color: '#3A416F',
                      padding: 20,
                      font: {
                        size: 11,
                        family: "Open Sans",
                        style: 'normal',
                        lineHeight: 2
                      },
                    }
                  },
                },
              },
            });
            function createTable(){
              console.log('triggered');
              const chart = document.querySelector('.chart3');
              const tableDiv = document.createElement('DIV');
              tableDiv.setAttribute('id', 'tableDiv'); //menambahkan ID

              const table = document.createElement('TABLE');
              table.classList.add('chartjs-table');

              // add table head (thead)
              const thead = table.createTHead();
              thead.classList.add('chartjs-thead');

              thead.insertRow(0);
              console.log(data.labels)
              for(let i = 0; i < data.labels.length; i++) {
                thead.rows[0].insertCell(i).innerText = data.labels[i];
                
              };
              thead.rows[0].insertCell(0).innerText = 'Jam'

              // add table body
              const tbody = table.createTBody();
              thead.classList.add('chartjs-tbody');
              console.log(data.datasets)
              data.datasets.map((dataset,index) => {
                tbody.insertRow(index);
                for(let i = 0; i < data.datasets[0].data.length; i++){
                  tbody.rows[index].insertCell(i).innerText = dataset.data[i];
                };
                tbody.rows[index].insertCell(0).innerText = dataset.label;
              })

              
              // append
              chart.appendChild(tableDiv);
              tableDiv.appendChild(table);
              }

              createTable();
           };
    </script>
    <script src="./assets/js/loopple/loopple.js"></script>

    <script>
      const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
      const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
      const popover = new bootstrap.Popover('.popover-dismiss', {
        trigger: 'hover'
      })
    </script>

</body>
</html>