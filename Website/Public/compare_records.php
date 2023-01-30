<?php

  include '../Classes/Header.php';

  if(empty($_SESSION['empID'])) {
    header('Location: ../Public/login.php');
  }

  $cpr;
  $recordID;
  $recordID2;

  if (!empty($_SESSION['patientCPR'])) {
    $cpr = $_SESSION['patientCPR'];
  }

  if (isset($_GET['recordID'])) {
    $recordID = $_GET['recordID'];
  }

  if (isset($_GET['recordID2'])) {
    $recordID2 = $_GET['recordID2'];
  }

  $encryption = new Encryption();

  $patient = new Patient();
  $patient->InitWithCPR($cpr);

  $medicalRecord = new MedicalRecord();
  $medicalRecord->InitWithRecordID($recordID);

  $medicalRecord2 = new MedicalRecord();
  $medicalRecord2->InitWithRecordID($recordID2);

  $mriScan = new MriScan();
  $mriScan->InitWithImgID($medicalRecord->GetImgID());

  $mriScan2 = new MriScan();
  $mriScan2->InitWithImgID($medicalRecord2->GetImgID());

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
        <div class="container-fluid" style="padding-top: 1.25rem;">
            <div class="text-center">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <img src=<?php echo ($mriScan->getImageFile()) ? "" . $encryption->Decrypt($mriScan->getImageFile(), $encryption->getKey()) : "https://via.placeholder.com/150";  ?> width="250" height="300">
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-12 mt-4">
                                <textarea id="diagnosis" name="diagnosis" rows="4" cols="97" placeholder="Diagnosis..." style="resize: none;" disabled><?php echo $encryption->Decrypt($medicalRecord->GetDiagnosis(), $encryption->getKey()) ?></textarea>
                            </div>
                            <div class="col-md-6 mt-4 px-0">
                                <textarea id="treatment" name="treatment" rows="4" cols="50" placeholder="Treatment..." style="resize: none;" disabled><?php echo $encryption->Decrypt($medicalRecord->GetTreatment(), $encryption->getKey()) ?></textarea>
                            </div>
                            <div class="col-md-6 mt-4 px-0">
                                <textarea id="notes" name="notes" rows="4" cols="50" placeholder="Notes..." style="resize: none;" disabled><?php echo $encryption->Decrypt($medicalRecord->GetNotes(), $encryption->getKey()) ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <img src=<?php echo ($mriScan2->getImageFile()) ? "" . $encryption->Decrypt($mriScan2->getImageFile(), $encryption->getKey()) : "https://via.placeholder.com/150";  ?> width="250" height="300">
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-12 mt-4">
                                <textarea id="diagnosis" name="diagnosis" rows="4" cols="97" placeholder="Diagnosis..." style="resize: none;" disabled><?php echo $encryption->Decrypt($medicalRecord2->GetDiagnosis(), $encryption->getKey()) ?></textarea>
                            </div>
                            <div class="col-md-6 mt-4 px-0">
                                <textarea id="treatment" name="treatment" rows="4" cols="50" placeholder="Treatment..." style="resize: none;" disabled><?php echo $encryption->Decrypt($medicalRecord2->GetTreatment(), $encryption->getKey()) ?></textarea>
                            </div>
                            <div class="col-md-6 mt-4 px-0">
                                <textarea id="notes" name="notes" rows="4" cols="50" placeholder="Notes..." style="resize: none;" disabled><?php echo $encryption->Decrypt($medicalRecord2->GetNotes(), $encryption->getKey()) ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SCRIPTS -->
        <script src="../js/jquery.js"></script>
        <script src="../js/bootstrap.js"></script>
        <script src="../js/bootstrap.min.js"></script>
    </body>
</html>

<?php
  include '../Public/footer.php';
?>