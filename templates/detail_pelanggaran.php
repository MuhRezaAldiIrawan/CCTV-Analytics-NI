<!doctype html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <title>Data Pelanggaran Lalu Lintas</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet'>
        <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
        <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
        <link rel="icon" href="https://tolmakassar.com/apexnew/app-assets/img/Logo_MMN_JTSE.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/0ca54e6540.js"crossorigin="anonymous"></script>
        <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
        <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        
        <style>
        @media print {
        #printPageButton {
            display: none;
        }
        }
        ::-webkit-scrollbar {
            width: 8px;
        }
        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }    
        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888; 
        }
        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555; 
        }
        .card-1{
        border: none;
            border-radius: 10px;
            width: 100%;
            background-color: #fff;
        }
        .icons i {
        margin-left: 20px;
        }
        .gmd-4 {
        -webkit-box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
        -moz-box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
        -ms-box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
        -o-box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
        }
        tr > * + * {
        padding-left: 4em;
        }   
        .dropdown-menu {
            max-height: 600px;
            overflow-y: scroll;
          }
    </style>


    <!-- Pengkoneksian ke database untuk menampilkan database -->
    <?php
        $conn = new mysqli('localhost', 'root', '', 'web_mks');
        $query = $conn->query("
        SELECT * FROM data_pelanggaran ORDER BY ID DESC
        ");

        $result = array();
    ?>

</head>
<body className='snippet-body'>
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
                      $conn = new mysqli('localhost', 'root', '', 'web_mks');
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
                        <img src='/static/counting000/".substr($data7['project'], 11)."/melawan_arus/".$data7['GAMBAR']."'
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
                <a class="nav-link text-dark fw-semibold fs-5" href="/maps" target="_blank">Peta</a>
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
        <div class="container mt-5">
        <h1 class="Counting" id="Counting" style="margin-top:80px"><center>Data Pelanggaran Lalu Lintas</center></h1>
        <button type="button" class="btn btn-outline-success" onclick="exportData()">Download Data</button>
            <table id="data_pelanggaran" class="table table-borderless table-responsive card-1 p-4 gmd-4" style="margin-top: 20px;">
            <thead>
            <tr class="border-bottom">
            <th>
                <span class="ml-2">Waktu</span>
            </th>
            <th>
                <span class="ml-2">Gambar</span>
            </th>
            <th>
                <span class="ml-2">Jenis Pelanggaran</span>
            </th>
            <th>
                <span class="ml-2">Lokasi</span>
            </th>
            <th>
                <span class="ml-4">Action</span>
            </th>
            </tr>
        </thead>
        <tbody>
            <?php
                while ($data = $query -> fetch_assoc()){
                    echo ("
                        <tr class='border-bottom'>
                        <td>
                            <div class='p-2'>
                                <span class='d-block font-weight-bold'>".substr($data['WAKTU'], 0, 11)."</span>
                                <small> Pukul ".substr($data['WAKTU'], 11)."</small>
                            </div>
                        </td>
                        <td>
                            <div class='p-2 d-flex flex-row align-items-center mb-2'>
                    ");

                    if($data['JENIS_PELANGGARAN'] == 'Melawan Arus' || $data['JENIS_PELANGGARAN'] == 'Over Speed') {
                    echo ("
                    <img src='/static/pelanggaran/".$data['GAMBAR']."' width='30'
                    style='margin-left:16px;'
                    class='d-block w-50 h-100 rounded'
                    alt='...'/>
                    </li>
                    ");
                    }else{
                    echo ("
                    <img src='/static/counting000/".substr($data['project'], 11)."/person/".$data['GAMBAR']."' width='30'
                    style='margin-left:16px;'
                    class='d-block w-50 h-100 rounded'
                    alt='...'/>
                    
                    </li>");
                    };

                    $id = $data['id'];
                    $query_detail = $conn->query("SELECT * FROM data_pelanggaran WHERE id = '$id'");
                    while ($data_detail = $query_detail -> fetch_assoc()){
                        echo ("

                        </td>
                        <td>
                            <div class='p-2'>
                                <span class='font-weight-bold'>".$data['JENIS_PELANGGARAN']."</span>
                            </div>
                        </td>
                        <td>
                            <div class='p-2 d-flex flex-column'>
                                <span>".$data['LOKASI']."</span>
                            </div>
                        </td>
                        <td>

                        <!-- Modal -->
                        <div class= 'modal fade' id='modalDetail".$data['id']."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                            <div class='modal-dialog modal-lg' role='document'>
                                <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='printPageButton'>Laporan Pelanggaran</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span id='printPageButton' aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <div class='modal-body'>
                                    <center><b><h5>
                                        LAPORAN PELANGGARAN LALU LINTAS
                                    </h5></b></center>
                                    </br>
                                    Telah terjadi pelanggaran lalu lintas dengan detail sebagai berikut : 
                                    <table spacing='10' style='margin-top:20px;'>
                                        <tr>
                                            <td>Jenis Pelanggaran </td>
                                            <td>: ".$data['JENIS_PELANGGARAN']."</td> 
                                        </tr>
                                        <tr>
                                            <td>Lokasi </td>
                                            <td>: ".$data['LOKASI']." </td> 
                                        </tr>
                                        <tr>
                                            <td>Tanggal </td>
                                            <td>: ".substr($data['WAKTU'], 0, 11)."</td> 
                                        </tr>
                                        <tr>
                                            <td>Pukul </td>
                                            <td>: ".substr($data['WAKTU'], 11)." WITA</td> 
                                        </tr>
                                    </table>

                                    <br>Berikut adalah capture gambar pelanggaran yang berhasil di tangkap
                                    oleh kamera CCTV
                                    
                                    ");

                                if($data['JENIS_PELANGGARAN'] == 'Melawan Arus' || $data['JENIS_PELANGGARAN'] == 'Over Speed') {
                                    echo ("
                                    <center>
                                    <img src='/static/pelanggaran/".$data['GAMBAR']."'width='100'
                                    class='d-block w-40 h-20 rounded'
                                    style='margin-top:20px;'
                                    alt='...'/>
                                    </center>
                                    </li>
                                    
                                    ");
                                }else{
                                    echo ("
                                    <center>
                                    <img src='/static/counting000/".substr($data['project'], 11)."/person/".$data['GAMBAR']."'width='100''
                                    class='d-block w-40 h-20 rounded'
                                    style='margin-top:20px;'
                                    alt='...'/>
                                    </center>
                                    </li>");
                                        };

                                echo ("
                                </div>
                                <div class='modal-footer'>
                                    <button id='printPageButton' type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                    <button id='printPageButton' type='button' class='btn btn-primary' onclick=printDetail('modalDetail".$data['id']."')>Print</button>
                                </div>
                                </div>
                            </div>
                        </div>
                            <div class='p-2 icons'>
                            <button type='button' class='btn btn-outline-primary' data-toggle='modal' data-target='#modalDetail".$data['id']."'>Detail</button>
                            </div>
                        </td>
                        </tr>
                        
                        ");
                    };
                    
                };

                ?>
                
            </div>
            

            </tbody>
            </table>
     </div>
    <!-- <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js'></script> -->
    <script type='text/javascript' src='#'></script>
    <script type='text/javascript' src='#'></script>
    <script type='text/javascript' src='#'></script>
    <script type='text/javascript'>'#'</script>
    <script>
        function printDetail(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
    <script>
    function exportData(){
        /* Get the HTML data using Element by Id */
        var table = document.getElementById("data_pelanggaran");
    
        /* Declaring array variable */
        var rows =[];
    
        //iterate through rows of table
        for(var i=0,row; row = table.rows[i];i++){
            //rows would be accessed using the "row" variable assigned in the for loop
            //Get each cell value/column from the row
            column1 = row.cells[0].innerText;
            column2 = row.cells[2].innerText;
            column3 = row.cells[3].innerText;
    
        /* add a new records in the array */
            rows.push(
                [
                    column1,
                    column2,
                    column3,
                ]
            );
    
            }
            csvContent = "data:text/csv;charset=utf-8,";
            /* add the column delimiter as semicolon(;) and each row splitted by new line character (\n) */
            rows.forEach(function(rowArray){
                row = rowArray.join(";");
                csvContent += row + "\r\n";
            });
    
            /* create a hidden <a> DOM node and set its download attribute */
            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "Data Pelanggaran.csv");
            document.body.appendChild(link);
            link.click();
        }
    </script>

    </body>
</html>