<?php

  class Employee {

    private $empID;
    private $firstName;
    private $lastName;
    private $address;
    private $phoneNumber;
    private $email;
    private $password;
    private $salary;
    private $title;
    private $department;

    function __Construct() {
      $this->empID = null;
      $this->firstName = null;
      $this->lastName = null;
      $this->address = null;
      $this->phoneNumber = null;
      $this->email = null;
      $this->password = null;
      $this->salary = null;
      $this->title = null;
      $this->department = null;
    }

    /**
     * Get the value of empID
     */ 
    public function GetEmpID()
    {
        return $this->empID;
    }

    /**
     * Set the value of empID
     *
     * @return  self
     */ 
    public function SetEmpID($empID)
    {
        $this->empID = $empID;

        return $this;
    }

    /**
     * Get the value of firstName
     */ 
    public function GetFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     *
     * @return  self
     */ 
    public function SetFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of lastName
     */ 
    public function GetLastName()
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     * @return  self
     */ 
    public function SetLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get the value of address
     */ 
    public function GetAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */ 
    public function SetAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of phoneNumber
     */ 
    public function GetPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set the value of phoneNumber
     *
     * @return  self
     */ 
    public function SetPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function GetEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function SetEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function GetPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function SetPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of salary
     */ 
    public function GetSalary()
    {
        return $this->salary;
    }

    /**
     * Set the value of salary
     *
     * @return  self
     */ 
    public function SetSalary($salary)
    {
        $this->salary = $salary;

        return $this;
    }

    /**
     * Get the value of title
     */ 
    public function GetTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function SetTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of department
     */ 
    public function GetDepartment()
    {
        return $this->department;
    }

    /**
     * Set the value of department
     *
     * @return  self
     */ 
    public function SetDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    function InitWithEmpID($empID) {
        $db = Database::GetInstance();
        $data = $db->singleFetch('SELECT * FROM Employees WHERE EmpID = ' . $empID);
        $this->initWith($data->EmpID, $data->FirstName, $data->LastName, $data->PhoneNumber, $data->Email, $data->Password, $data->Salary, $data->Title, $data->Department);
    }
    
    function InitWithEmail() {

        $db = Database::GetInstance();
        $data = $db->singleFetch('SELECT * FROM Employees WHERE Email = \'' . $this->email . '\'');
        if ($data != null) {
            return false;
        }
        return true;
    }
    
    private function InitWith($empID, $firstName, $lastName, $phoneNumber, $email, $password, $salary, $title, $department) {
        $this->empID = $empID;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
        $this->password = $password;
        $this->salary = $salary;
        $this->title = $title;
        $this->department = $department;
    }

    function CheckEmployee($email, $password) {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM Employees WHERE Email = \'' . $email . '\' AND empPassword = \'' . $password . '\'');
        $this->initWith($data->EmpID, $data->FirstName, $data->LastName, $data->PhoneNumber, $data->Email, $data->Password, $data->Salary, $data->Title, $data->Department);
    }
    
    function InsertEmployee() {
            try {
                $db = Database::getInstance();
                $data = $db->querySql('INSERT INTO Employees (EmpID, FirstName, LastName, PhoneNumber, Email, empPassword, Salary, Title, Department) VALUES (NULL, \'' . $this->firstName . '\',\'' . $this->lastName . '\',\'' . $this->phoneNumber . '\',\'' . $this->email . '\',\'' . $this->password . '\',\'' . $this->salary . '\',\'' . $this->title . '\',\'' . $this->department . '\')');
                echo 'huh' . $data;
                return true;
            } 
            catch (Exception $e) {
                echo 'Exception: ' . $e;
                return false;
            }  
    }
    
    function UpdateEmployee() {
      if ($this->isValid()) {
        $db = Database::getInstance();
        $data = 'UPDATE Employees set
			              Email = \'' . $this->email . '\' ,
			              FirstName = \'' . $this->firstName . '\' ,
                    LastName = \'' . $this->lastName . '\' ,
                    PhoneNumber = \'' . $this->phoneNumber . '\' ,
			              Password = \'' . $this->password . '\'  
			              WHERE EmpID = ' . $this->empID;

        $db->querySql($data);
      }
    }
    
    function DeleteEmployee() {
        try {
            $db = Database::getInstance();
            $data = $db->querySql('Delete from Employees where EmpID =' . $this->empID);
            return true;
        } 
        catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    function GetAllEmployees() {
        $db = Database::getInstance();
        $data = $db->multiFetch('Select * from Employees');
        return $data;
    }
    
    public function isValid() {
        $errors = array();
        $check = true;

        if (empty($this->firstName)) {
            $errors[] = 'You must enter a first name';
            $check = false;
        }  
        
        if (empty($this->lastName)) {
            $errors[] = 'You must enter a last name';
            $check = false;
        }
        
        if (empty($this->address)) {
            $errors[] = 'You must enter an address';
            $check = false;
        }

        if (empty($this->phoneNumber)) {
            $errors[] = 'You must enter an phone number';
            $check = false;
        }

        if (empty($this->email)) {
            $errors[] = 'You must enter a email';
            $check = false;
        }

        if (empty($this->password)) {
          $errors[] = 'You must enter a password';
          $check = false;
        }

        if (empty($this->salary)) {
          $errors[] = 'You must enter a salary';
          $check = false;
        }

        if (empty($this->title)) {
          $errors[] = 'You must select a title';
          $check = false;
        }

        if (empty($this->department)) {
          $errors[] = 'You must select a department';
          $check = false;
        }

        return $check;
    }
  }


?>