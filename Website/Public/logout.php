<?php

  session_start();

  include '../Classes/Header.php';

  $lgnObject = new Login();
  $lgnObject->logout();

  header('Location: ../Public/login.php');

?>