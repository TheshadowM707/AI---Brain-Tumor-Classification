<?php

  session_start();

  ini_set('show_errors', 'On');
  ini_set('display_errors', 1);
  error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

  function __autoload($className){
    include_once  $className.'.php';
  }

  if(empty($_SESSION['empID']) && basename($_SERVER['PHP_SELF']) != 'login.php') {
    header('Location: ../Public/login.php');
  }
?>

<!DOCTYPE html>
<html>
    <head>
     <title> Al - Salmaniya Hospital </title>

     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=Edge">
     <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

     <link rel="stylesheet" href="../css/style.css">
     <link rel="stylesheet" href="../css/bootstrap.css">
     <link rel="stylesheet" href="../css/bootstrap.min.css">
     
    </head>

    <body id="top">
     <main>
      <header class="p-3 text-bg-dark">
        <div class="container">
          <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
              <img class="bi me-2" src="../img/pngwing.com.png" width="40" height="50">
              <span class="fs-4 me-4">Al - Salmaniya Hospital</span>
            </a>

            <?php
              if(!empty($_SESSION['empID']) && !empty($_SESSION['patientCPR'])) {
                echo '<ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="../Public/mri_scans.php" class="nav-link px-2 text-white">Patient Mris</a></li>
                <li><a href="../Public/patient_medicalrecords.php" class="nav-link px-2 text-white">Patient Medical Records</a></li>
                <li><a href="../Public/patient_info.php" class="nav-link px-2 text-white">Patien Info</a></li>
                <li><a href="../Public/upload_mri.php" class="nav-link px-2 text-white">Upload Mri Scan</a></li>
              </ul>
  
              <div class="text-end">
                <a href="../Public/change_patient.php"><button type="button" class="btn btn-outline-light me-2">Change Patient</button></a>
                <a href="../Public/logout.php"><button type="button" class="btn btn-outline-light me-2">Logout</button></a>
              </div>';
              }
            ?>
      
            
          </div>
        </div>
      </header>
     </main>
     
     <!-- SCRIPTS -->
     <script src="../js/jquery.js"></script>
     <script src="../js/bootstrap.js"></script>
     <script src="../js/bootstrap.min.js"></script>
    </body>
</html>