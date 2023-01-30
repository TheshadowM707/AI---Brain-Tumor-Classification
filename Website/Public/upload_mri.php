<?php
  include '../Classes/Header.php';

  $ok = true;
  $targetDir = "../img/";
  $file = $targetDir . basename($_FILES["fileToUpload"]["name"]);
  $fileType = strtolower(pathinfo($file,PATHINFO_EXTENSION));

  if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    $error = '';

    if($check == true) {
      $ok = true;
    }
    else {
      $error = 'The file you selected is not an image.';
      $ok = false;
    }

    if(file_exists($file)) {
      $error = "This file already exists.";
      $ok = false;
    }

    if($ok) {
      if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file)) {

        $ecryption = new Encryption();
        $encFile = $ecryption->Encrypt($file, $ecryption->getKey());

        $mriScan = new MriScan();
        $mriScan->setPatientCPR($_POST["patientCpr"]);
        $mriScan->setImageFile($encFile);
        $mriScan->InsertMRI();

        echo '
          <div class="text-center">
              <div class="alert alert-success" role="alert"> The file '. htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])) .' has been uploaded successfully. </div>
          </div>
        ';
      }
      else {
        echo "Error, your file was not uploaded.";
      }
    }
    else {
      echo '
            <div class="text-center">
                <div class="alert alert-danger" role="alert"> '. $error .' </div>
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
    <section>
      <div class="container">
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6">
            <div class="text-center">
              <form action="" method="post" id="login-form" enctype="multipart/form-data">
                <p><h1>Upload Mri Scan</h1></p>
                <input class="form-control" type="text" placeholder="Patient Cpr" name="patientCpr" required>
          
                <input class="form-control" id="fileToUpload" type="file" name="fileToUpload" required>
          
                <input class="btn btn-dark btn-lg me-2" type="submit" name="submit" value="Upload">
              </form>
            </div>
          </div>
          <div class="col-md-3"></div>
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
?>