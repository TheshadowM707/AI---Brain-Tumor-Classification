<?php

  include '../Classes/Header.php';

  $cpr;

  if (!empty($_SESSION['patientCPR'])) {
    $cpr = $_SESSION['patientCPR'];
  }

  if(isset($_POST['submit'])) {
    $name = $_POST['chk'];

    foreach ($name as $chk) {
      echo $chk."<br />";
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
    
    <div class="text-center">
      <div id="alert" class="alert alert-danger" role="alert" hidden> You can only select two records </div>
    </div>
    
    <section>
      <div class="text-center">
      <button class="btn btn-dark" onclick="compare()">Compare</button>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Created By</th>
              <th scope="col">Last Edited By</th>
              <th scope="col">Image</th>
              <th scope="col">Record Date</th>
              <th scope="col">Select</th>
            </tr>
          </thead>
          <tbody>
            <?php

              $medicalRecord = new MedicalRecord();
              $row = $medicalRecord->GetAllPatientRecords($cpr);

              if(!empty($row)) {
                for($i = 0; $i < count($row); $i++) {

                  $encryption = new Encryption();

                  $createdBy = new Employee();
                  $createdBy->InitWithEmpID($row[$i]->CreatedBy);

                  $lastEditedBy = new Employee();
                  $lastEditedBy->InitWithEmpID($row[$i]->LastEditedBy);

                  $img = new MriScan();
                  $img->InitWithImgID($row[$i]->ImgID);
                  $imgFile = $encryption->Decrypt($img->getImageFile(), $encryption->getKey());
                  
                  echo '
                      <tr class="align-middle">
                        <th scope="row">'. $i .'</th>
                        <th>'. $createdBy->GetFirstName() . ' ' . $createdBy->GetLastName() .'</th>
                        <th>'. $lastEditedBy->GetFirstName() . ' ' . $lastEditedBy->GetLastName() .'</th>
                        <th> <img src="'.  $imgFile  .'" style="width: 6.25rem; height: 6.25rem;"> </th>
                        <th>'. $row[$i]->DateOfCreation .'</th>
                        <th> <input class="form-check-input" type="checkbox" value="'. $row[$i]->RecordID .'" id="chk" name="chk" onclick="return limit()"> </th>
                        <th> <a href="edit_medicalrecord.php?recordID='. $row[$i]->RecordID .'"> <button class="btn btn-dark">Edit</button> </a> </th>
                      </tr>
                  ';
                }
              }
              
            ?>
          </tbody>
        </table>
      </div>
    </section>

    <script type="text/javascript">
      function limit() {
        var a = document.getElementsByName('chk');
        var count = 0;

        for(var i = 0; i < a.length; i++) {
          if(a[i].checked == true) {
            count = count + 1;
          }

          if(count >= 3) {
            var alert = document.getElementById("alert");
            alert.removeAttribute("hidden");

            return false;
          }
        }
      }

      function compare() {
        var ids = [];

        var checkedBoxes = document.getElementsByName('chk');
        for(var i = 0; i < checkedBoxes.length; i++) {
          if(checkedBoxes[i].checked == true) {
            ids.push(checkedBoxes[i].value);
          }
        }
        
        if(ids.length == 2) {
          window.location.href = "compare_records.php?recordID="+ids[0] + "&recordID2="+ids[1];
        }
        else {
          alert("Please select two records to compare");
        }
        
      }
    </script>

    <!-- SCRIPTS -->
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>

<?php
  include '../Public/footer.php';
?>