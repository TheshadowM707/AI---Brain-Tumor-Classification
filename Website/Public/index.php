<?php

  include '../Classes/Header.php';

  if(empty($_SESSION['empID'])) {
    header('Location: ../Public/login.php');
  }

  if(isset($_POST['submit'])) {
    $cpr = $_POST['patientCPR'];

    $patient = new Patient();
    $patient->InitWithCPR($cpr);

    if($patient->GetCPR() != null & $patient->GetCPR() == $cpr) {
      $_SESSION['patientCPR'] = $cpr;
      header('Location: ../Public/mri_scans.php');
    }
    else {
      echo '
            <div class="text-center">
                <div class="alert alert-danger" role="alert"> There is no patient with this cpr </div>
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
                  <form action="" method="post" id="login-form">
                    <p><h1>Patient</h1></p>
                    <input class="form-control" type="text" placeholder="Enter Patient CPR" name="patientCPR" required>
              
                    <input type="submit" name="submit" value="Search">
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