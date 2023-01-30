<?php

  include '../Classes/Header.php';

  if(empty($_SESSION['empID'])) {
    header('Location: ../Public/login.php');
  }

  $cpr;

  if (!empty($_SESSION['patientCPR'])) {
    $cpr = $_SESSION['patientCPR'];
  }

  $patient = new Patient();
  $patient->InitWithCPR($cpr);

  if (isset($_POST['submit'])) {

    $patient->SetFirstName($_POST["patientFName"]);
    $patient->SetLastName($_POST["patientLName"]);
    $patient->SetPhoneNumber($_POST["phoneNumber"]);
    $patient->SetNotes($_POST["notes"]);

    if($patient->UpdatePatient()) {
        echo '
            <div class="text-center">
                <div class="alert alert-success" role="alert"> The patient Info was updated successfully </div>
            </div>
        ';
    }
    else {
        echo '
            <div class="text-center">
                <div class="alert alert-danger" role="alert"> The patient Info was not updated </div>
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
                    <div class="col-md-12">
                        <p><h2>Patient Info:</h2></p>

                        <form action="" method="post">
                            <div class="row mt-4">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <label for="patientFName" style="float: left;">First Name:</label>
                                    <input class="form-control" type="text" placeholder="Enter Patient First Name" name="patientFName" value=<?php echo "" . $patient->GetFirstName() ?> disabled required>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <label for="patientLName" style="float: left;">Last Name:</label>
                                    <input class="form-control" type="text" placeholder="Enter Patient Last Name" name="patientLName" value=<?php echo "" . $patient->GetLastName() ?> disabled required>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <label for="patientLName" style="float: left;">Birthday:</label>
                                    <input class="form-control" type="text" placeholder="Enter Patient Last Name" name="patientLName" value=<?php echo "" . $patient->GetBirthdate() ?> disabled required>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <label for="phoneNumber" style="float: left;">Phone Number:</label>
                                    <input class="form-control" type="text" placeholder="Enter Patient Phone Number" name="phoneNumber" value=<?php echo "" . $patient->GetPhoneNumber() ?> required>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <label for="notes" style="float: left;">Notes:</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="8" cols="97" placeholder="Notes..." style="resize: none;"> <?php echo "" . $patient->GetNotes() ?> </textarea>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <input class="btn btn-dark btn-lg me-2" type="submit" name="submit" value="Update Patient Info">
                                </div>
                                <div class="col-md-4"></div>
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