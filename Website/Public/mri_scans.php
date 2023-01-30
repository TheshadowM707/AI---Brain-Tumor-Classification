<?php

  include '../Classes/Header.php';

  $cpr;

  if (!empty($_SESSION['patientCPR'])) {
    $cpr = $_SESSION['patientCPR'];
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

  <body id="top" data-spy="scroll" data-target=".navbar-collapse" data-offset="50">
    <section>
      <div class="container">
        <div class="row">
            <?php
              $encryption = new Encryption();

              $mriScan = new MriScan();
              $row = $mriScan->GetAllPatientMRI($cpr);

              if(!empty($row)) {
                for($i = 0; $i < count($row); $i++) {
                    echo '
                      <div class="col-md-3">
                        <div class="card mt-3" style="width: 17rem;">
                            <img class="card-img-top" src="'. $encryption->Decrypt($row[$i]->ImageFile, $encryption->getKey()) .'" style="height: 16.188rem !important;">
            
                            <div class="card-body">
                                <div class="card-title">Upload Date: '. $row[$i]->ScanDate .'</div>
            
                                <a href="../Public/diagnosis.php?ImgID='.$row[$i]->ImgID.'"><button class="btn btn-dark btn-lg me-2">Select</button></a>
                                <a href="'.$encryption->Decrypt($row[$i]->ImageFile, $encryption->getKey()).'" download><button class="btn btn-dark btn-lg me-2 mt-2">Download Image</button></a>
                            </div>
                        </div>
                      </div>
                    ';
                }
              }
              else {
                echo 'This patient does not have any mri scans...';
              }
            ?>
          
        </div>
      </div>
    </section>

    <!-- SCRIPTS -->
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>

<?php
  include '../Public/footer.php';
?>\