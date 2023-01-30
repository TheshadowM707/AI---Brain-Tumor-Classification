<?php

  class Department {

    private $depID;
    private $depName;

    function __Construct() {
        $this->depID = null;
        $this->depName = null;
    }

    /**
     * Get the value of depID
     */ 
    public function GetDepID()
    {
        return $this->depID;
    }

    /**
     * Set the value of depID
     *
     * @return  self
     */ 
    public function SetDepID($depID)
    {
        $this->depID = $depID;

        return $this;
    }

    /**
     * Get the value of depName
     */ 
    public function GetDepName()
    {
        return $this->depName;
    }

    /**
     * Set the value of depName
     *
     * @return  self
     */ 
    public function SetDepName($depName)
    {
        $this->depName = $depName;

        return $this;
    }

    function InitWithDepID($depID) {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM Departments WHERE DepID = ' . $depID);
        $this->initWith($data->DepID, $data->DepName);
    }
    
    private function InitWith($depID, $depName) {
        $this->depID = $depID;
        $this->depName = $depName;
    }

    function InsertDepartment() {

        if ($this->isValid()) {
            try {
                $db = Database::getInstance();
                $data = $db->querySql('INSERT INTO Departments (DepID, DepName) VALUES (NULL, \'' . $this->depName . '\')');
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
    
    function UpdateDepartment() {
        if ($this->isValid()) {
            try {
                $db = Database::getInstance();
                $data = 'UPDATE Departments set
			        DepName = \'' . $this->depName . '\' 
				    WHERE DepID = ' . $this->depID;

                $db->querySql($data);
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
    
    function DeleteDepartment() {
        try {
            $db = Database::getInstance();
            $data = $db->querySql('Delete from Departments where DepID=' . $this->depID);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    function GetAllDepartments() {
        $db = Database::getInstance();
        $data = $db->multiFetch('Select * from Departments');
        return $data;
    }

    public function isValid() {
        $errors = array();
        $check = true;

        if (empty($this->depName)) {
            $errors[] = 'You must enter a department name';
            $check = false;
        }

        return $check;
    }
  }

?>