<?php

  include '../Classes/Header.php';

  //
  $cpr;
  $imgID;

  //
  if (!empty($_SESSION['patientCPR'])) {
    $cpr = $_SESSION['patientCPR'];
  }

  if (!empty($_GET['ImgID'])) {
    $imgID = $_GET['ImgID'];
  }

  $en = new Encryption();

  //
  $patient = new Patient();
  $patient->InitWithCPR($cpr);

  $mriScan = new MriScan();
  $mriScan->InitWithImgID($imgID);
  $imgFile = $en->Decrypt($mriScan->getImageFile() ,$en->getKey());

  if(!isset($_POST['submit'])) {
    $output = exec("python ../py/diagnose.py " . $imgFile);
  }

  //
  if (isset($_POST['submit'])) {

    $encryption = new Encryption();

    $enCpr = $encryption->Encrypt($cpr ,$encryption->getKey());
    $enDiagnosis = $encryption->Encrypt($_POST['diagnosis'] ,$encryption->getKey());
    $enTreatment = $encryption->Encrypt($_POST['treatment'] ,$encryption->getKey());
    $enNotes = $encryption->Encrypt($_POST['notes'] ,$encryption->getKey());

    $medicalRecord = new MedicalRecord();
    $medicalRecord->SetCreatedBy($_SESSION['empID']);
    $medicalRecord->SetPatientCPR($cpr);
    $medicalRecord->SetImgID($imgID);
    $medicalRecord->SetDiagnosis($enDiagnosis);
    $medicalRecord->SetTreatment($enTreatment);
    $medicalRecord->SetNotes($enNotes);

    if($medicalRecord->InsertMedicalRecord()) {
        echo '
            <div class="text-center">
                <div class="alert alert-success" role="alert"> The medical record was saved successfully </div>
            </div>
        ';
    }
    else {
        echo '
            <div class="text-center">
                <div class="alert alert-danger" role="alert"> The medical record was not saved </div>
            </div>
        ';
    }
    
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
        <div class="container-fluid" style="padding-top: 1.25rem;">
            <div class="text-center">
                <div class="row">
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Patient Info:</h2>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <p>Patient Cpr: </p>
                            </div>
                            <div class="col-md-6">
                                <?php echo $patient->GetCPR()?>
                            </div>
                            <div class="col-md-6">
                                <p>Patient Name: </p>
                            </div>
                            <div class="col-md-6">
                                <?php echo $patient->GetFirstName() . ' ' . $patient->GetLastName()?>
                            </div>
                            <div class="col-md-6">
                                <p>Birthdate: </p>
                            </div>
                            <div class="col-md-6">
                                <?php echo $patient->GetBirthdate()?>
                            </div>
                            <div class="col-md-6">
                                <p>Gender: </p>
                            </div>
                            <div class="col-md-6">
                                <?php echo $patient->GetGender()?>
                            </div>
                            <div class="col-md-6">
                                <p>Phone Number: </p>
                            </div>
                            <div class="col-md-6">
                                <?php echo $patient->GetPhoneNumber()?>
                            </div>
                            <div class="col-md-6">
                                <p>Notes: </p>
                            </div>
                            <div class="col-md-6">
                                <?php echo $patient->GetNotes()?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <img src=<?php echo $imgFile;  ?> width="250" height="300">
                                </div>
                                <div class="col-md-2"></div>
                                <div class="col-md-12 mt-4">
                                    <textarea id="diagnosis" name="diagnosis" rows="4" cols="97" placeholder="Diagnosis..." style="resize: none;"><?php echo 'Brain Tumor Type: ' . $output ?></textarea>
                                </div>
                                <div class="col-md-2"></div>
                                <div class="col-md-4 mt-4 px-0">
                                    <textarea id="treatment" name="treatment" rows="4" cols="50" placeholder="Treatment..." style="resize: none;"></textarea>
                                </div>
                                <div class="col-md-4 mt-4 px-0">
                                    <textarea id="notes" name="notes" rows="4" cols="50" placeholder="Notes..." style="resize: none;"></textarea>
                                </div>
                                <div class="col-md-2"></div>
                                <div class="col-md-12 mt-4">
                                    <input class="btn btn-dark btn-lg me-2" type="submit" name="submit" value="Add To Medical Records">
                                </div>
                            </div>
                        </form>
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