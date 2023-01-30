<?php
  class Login extends Employee {

    public $ok;
    public $salt;
    public $domain;

    function __construct() {
        parent::__construct();
        $this->ok = false;
        $this->salt = 'ENCRYPT';
        $this->domain = '';

        if (!$this->CheckSession())
            $this->CheckCookie();

        return $this->ok;
    }

    function CheckSession() {
      if(!empty($_SESSION['empID'])) {
        $this->ok = true;
        return true;
      }
    }

    function CheckCookie() {
      if(!empty($_COOKIE['empID'])) {
        $this->ok = true;
        return $this->check($_COOKIE['empID']);
      }
    }

    function Check($empID) {
      $this->InitWithEmpID($empID);

      if($this->GetEmpID() != null & $this->GetEmpID() == $empID) {
        $this->ok = true;

        $_SESSION['empID'] = $this->GetEmpID();
        $_SESSION['username'] = $this->GetFirstName() . " " . $this->GetLastName();
        setcookie('empID', $_SESSION['empID'], time() + 60 * 60 * 24 * 7, '/', $this->domain);
        setcookie('username', $_SESSION['username'], time() + 60 * 60 * 24 * 7, '/', $this->domain);

        return true;
      }
      else {
        $error[] = 'Error';

        return false;
      }
    }

    function Login($email, $password) {
      try{
        $this->CheckEmployee($email, $password);

        if($this->GetEmpID() != null) {
          $this->ok = true;

          $_SESSION['empID'] = $this->GetEmpID();
          $_SESSION['username'] = $this->GetFirstName() . " " . $this->GetLastName();
          setcookie('empID', $_SESSION['empID'], time() + 60 * 60 * 24 * 7, '/', $this->domain);
          setcookie('username', $_SESSION['username'], time() + 60 * 60 * 24 * 7, '/', $this->domain);

          return true;
        }
        else {
          $error[] = 'Wrong Email or Password';
        }
      }
      catch(Exception $e) {
        $error[] = $e->getMessage();

        return false;
      }
    }

    function Logout() {
      $this->ok = false;

      $_SESSION['empID'] = '';
      $_SESSION['username'] = '';
      setcookie('empID', '', time() - 3600, '/', $this->domain);
      setcookie('username', '', time() - 3600, '/', $this->domain);
      session_destroy();
    }
  }
?>