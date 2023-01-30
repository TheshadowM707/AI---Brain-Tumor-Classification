<?php

  include '../Classes/Header.php';

  if(isset($_SESSION['locked'])) {
    $difference = time() - $_SESSION["locked"];
    if($difference > 300) {
      unset($_SESSION['locked']);
      unset($_SESSION['attempt']);
      unset($_SESSION['msg']);
    }
  }

  if (isset($_POST['submit'])) {

    $lgnObj = new Login();
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if ($lgnObj->login($email, $password)) {
      $employee = new Employee();
      $employee->InitWithEmpID($_SESSION['empID']);

      $title = new Title();
      $accessLevel = $title->GetEmpAccessLevel($employee->GetTitle());

      if($accessLevel->AccessLevel > 1) {
        header('Location: ../Public/index.php');
      }
      else {
        echo '
            <div class="text-center">
                <div class="alert alert-danger" role="alert"> Your Access Level is Low </div>
            </div>
        ';
      }
      
    }
    else {

      if(!isset($_SESSION['attempt'])) {
        $_SESSION['attempt'] = 0;
      }

      $_SESSION['attempt'] += 1;

      if($_SESSION['attempt'] > 2) {
        $_SESSION['msg'] = "disabled";
        $_SESSION['locked'] = time();
        echo '
            <div class="text-center">
                <div class="alert alert-danger" role="alert"> Invalid email or password </div>
            </div>
        ';
      }
      else {
        echo '
            <div class="text-center">
                <div class="alert alert-danger" role="alert"> Invalid email or password </div>
            </div>
        ';
      }
      
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
                <p><h1>Login</h1></p>
                <input class="form-control" type="text" placeholder="Enter Email" name="email" <?php if(isset($_SESSION['msg'])){ echo $_SESSION['msg'];}?> required>
          
                <input class="form-control" type="password" placeholder="Enter Password" name="password" <?php if(isset($_SESSION['msg'])){ echo $_SESSION['msg'];}?> required>
          
                <input class="btn btn-dark btn-lg me-2" type="submit" name="submit" value="Login">
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