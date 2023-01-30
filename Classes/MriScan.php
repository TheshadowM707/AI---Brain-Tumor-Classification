<?php

  class MriScan {

    private $imgID;
    private $patientCPR;
    private $imageFile;
    private $scanDate;

    function __Construct() {
        $this->imgID = null;
        $this->patientCPR = null;
        $this->imageFile = null;
        $this->scanDate = null;
    }

    /**
     * Get the value of imgID
     */ 
    public function getImgID()
    {
        return $this->imgID;
    }

    /**
     * Set the value of imgID
     *
     * @return  self
     */ 
    public function setImgID($imgID)
    {
        $this->imgID = $imgID;

        return $this;
    }

    /**
     * Get the value of patientCPR
     */ 
    public function getPatientCPR()
    {
        return $this->patientCPR;
    }

    /**
     * Set the value of patientCPR
     *
     * @return  self
     */ 
    public function setPatientCPR($patientCPR)
    {
        $this->patientCPR = $patientCPR;

        return $this;
    }

    /**
     * Get the value of imageFile
     */ 
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Set the value of imageFile
     *
     * @return  self
     */ 
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;

        return $this;
    }

    /**
     * Get the value of scanDate
     */ 
    public function getScanDate()
    {
        return $this->scanDate;
    }

    /**
     * Set the value of scanDate
     *
     * @return  self
     */ 
    public function setScanDate($scanDate)
    {
        $this->scanDate = $scanDate;

        return $this;
    }

    function InitWithImgID($imgID) {
        $db = Database::GetInstance();
        $data = $db->singleFetch('SELECT * FROM Mriscans WHERE ImgID = ' . $imgID);
        $this->initWith($data->ImgID, $data->PatientCPR, $data->ImageFile, $data->ScanDate);
    }
    
    private function InitWith($imgID, $patientCPR, $imageFile, $scanDate) {
        $this->imgID = $imgID;
        $this->patientCPR = $patientCPR;
        $this->imageFile = $imageFile;
        $this->scanDate = $scanDate;
    }

    function InsertMRI() {
        if ($this->isValid()) {
            try {
                $db = Database::GetInstance();
                $data = $db->querySql('INSERT INTO Mriscans (ImgID, PatientCPR, ImageFile, ScanDate) VALUES (NULL, \'' . $this->patientCPR . '\',\'' . $this->imageFile . '\',\'' . date("Y-m-d H:i:s") . '\')');
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
    
    function UpdateMRI() {
        if ($this->isValid()) {
            try {
                $db = Database::GetInstance();
                $data = 'UPDATE Mriscans Set
			                    PatientCPR = \'' . $this->patientCPR . '\' 
				                WHERE ImgID = ' . $this->imgID;

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
    
    function DeleteMRI() {
        try {
            $db = Database::GetInstance();
            $data = $db->querySql('Delete from Mriscans where ImgID =' . $this->imgID);
            return true;
        } 
        catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    function GetAllPatientMRI($cpr) {
        $db = Database::GetInstance();
        $data = $db->multiFetch('Select * from Mriscans where PatientCPR =' . $cpr);
        return $data;
    }
    
    function GetAllMRI() {
        $db = Database::GetInstance();
        $data = $db->multiFetch('Select * from Mriscans');
        return $data;
    }

    public function isValid() {
        $errors = array();
        $check = true;

        if (empty($this->patientCPR)) {
            $errors[] = 'You must enter a patient cpr';
            $check = false;
        }

        if (empty($this->imageFile)) {
            $errors[] = 'You must select an mri scan';
            $check = false;
        }

        return $check;
    }
  }

?>