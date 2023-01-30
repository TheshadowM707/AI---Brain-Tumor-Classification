<?php

  class Patient {

    private $cpr;
    private $firstName;
    private $lastName;
    private $birthdate;
    private $gender;
    private $phoneNumber;
    private $notes;

    function __Construct() {
      $this->cpr = null;
      $this->firstName = null;
      $this->lastName = null;
      $this->birthdate = null;
      $this->gender = null;
      $this->phoneNumber = null;
      $this->notes = null;
    }

    /**
     * Get the value of CPR
     */ 
    public function GetCPR()
    {
        return $this->cpr;
    }

    /**
     * Set the value of CPR
     *
     * @return  self
     */ 
    public function SetCPR($cpr)
    {
        $this->cpr = $cpr;

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
     * Get the value of birthdate
     */ 
    public function GetBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set the value of birthdate
     *
     * @return  self
     */ 
    public function SetBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get the value of gender
     */ 
    public function GetGender()
    {
        return $this->gender;
    }

    /**
     * Set the value of gender
     *
     * @return  self
     */ 
    public function SetGender($gender)
    {
        $this->gender = $gender;

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
     * Get the value of notes
     */ 
    public function GetNotes()
    {
        return $this->notes;
    }

    /**
     * Set the value of notes
     *
     * @return  self
     */ 
    public function SetNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    function InitWithCPR($cpr) {
        try {
            $db = Database::GetInstance();
            $data = $db->singleFetch('SELECT * FROM Patients WHERE CPR = ' . $cpr);
            $this->initWith($data->CPR, $data->FirstName, $data->LastName, $data->Birthdate, $data->Gender, $data->PhoneNumber, $data->Notes);

            return true;
        }
        catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    private function InitWith($cpr, $firstName, $lastName, $birthdate, $gender, $phoneNumber, $notes) {
        $this->cpr = $cpr;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthdate = $birthdate;
        $this->gender = $gender;
        $this->phoneNumber = $phoneNumber;
        $this->notes = $notes;
    }
    
    function InsertPatient() {
        if ($this->isValid()) {
            try {
                $db = Database::GetInstance();
                $data = $db->querySql('INSERT INTO Patients (CPR, FirstName, LastName, Birthdate, Gender, PhoneNumber, Notes) VALUES (\'' . $this->cpr . '\',\'' . $this->firstName . '\',\'' . $this->lastName . '\',\'' . $this->birthdate . '\',\'' . $this->gender . '\',\'' . $this->phoneNumber . '\',\'' . $this->notes . '\')');
                return true;
            } 
            catch (Exception $e) {
                echo 'Exception: ' . $e;
                return false;
            }
        } 
        else {
          return false;
        }      
    }
    
    function UpdatePatient() {
      if ($this->isValid()) {
        try{
            $db = Database::GetInstance();
            $data = 'UPDATE Patients Set
		    	            FirstName = \'' . $this->firstName . '\' ,
                            LastName = \'' . $this->lastName . '\' ,
                            PhoneNumber = \'' . $this->phoneNumber . '\' ,
		    	            Notes = \'' . $this->notes . '\'  
		    	            WHERE CPR = ' . $this->cpr;
    
            $db->querySql($data);

            return true;
        }
        catch(Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
        
      }
      else {
        return false;
      } 
    }
    
    function DeletePatient() {
        try {
            $db = Database::GetInstance();
            $data = $db->querySql('Delete from Patients where CPR =' . $this->cpr);
            return true;
        } 
        catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    function GetAllPatients() {
        $db = Database::GetInstance();
        $data = $db->multiFetch('Select * from Patients');
        return $data;
    }
    
    public function isValid() {
        $errors = array();
        $check = true;

        if (empty($this->cpr)) {
            $errors[] = 'You must enter the patient cpr';
            $check = false;
        }  

        if (empty($this->firstName)) {
            $errors[] = 'You must enter the patient first name';
            $check = false;
        }  
        
        if (empty($this->lastName)) {
            $errors[] = 'You must enter the patient last name';
            $check = false;
        }
        
        if (empty($this->gender)) {
            $errors[] = 'You must enter the patient';
            $check = false;
        }

        if (empty($this->phoneNumber)) {
            $errors[] = 'You must enter the patient phone number';
            $check = false;
        }

        return $check;
    }
  }


?>