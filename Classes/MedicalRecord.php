<?php

  class MedicalRecord {

    private $recordID;
    private $createdBy;
    private $lastEditedBy;
    private $patientCPR;
    private $imgID;
    private $dateOfCreation;
    private $diagnosis;
    private $treatment;
    private $notes;

    function __Construct() {
        $this->recordID = null;
        $this->createdBy = null;
        $this->lastEditedBy = null;
        $this->patientCPR = null;
        $this->imgID = null;
        $this->dateOfCreation = null;
        $this->diagnosis = null;
        $this->treatment = null;
        $this->notes = null;
    }

    /**
     * Get the value of recordID
     */ 
    public function GetRecordID()
    {
        return $this->recordID;
    }

    /**
     * Set the value of recordID
     *
     * @return  self
     */ 
    public function SetRecordID($recordID)
    {
        $this->recordID = $recordID;

        return $this;
    }

    /**
     * Get the value of createdBy
     */ 
    public function GetCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set the value of createdBy
     *
     * @return  self
     */ 
    public function SetCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get the value of lastEditedBy
     */ 
    public function GetLastEditedBy()
    {
        return $this->lastEditedBy;
    }

    /**
     * Set the value of lastEditedBy
     *
     * @return  self
     */ 
    public function SetLastEditedBy($lastEditedBy)
    {
        $this->lastEditedBy = $lastEditedBy;

        return $this;
    }

    /**
     * Get the value of patientCPR
     */ 
    public function GetPatientCPR()
    {
        return $this->patientCPR;
    }

    /**
     * Set the value of patientCPR
     *
     * @return  self
     */ 
    public function SetPatientCPR($patientCPR)
    {
        $this->patientCPR = $patientCPR;

        return $this;
    }

    /**
     * Get the value of imgID
     */ 
    public function GetImgID()
    {
        return $this->imgID;
    }

    /**
     * Set the value of imgID
     *
     * @return  self
     */ 
    public function SetImgID($imgID)
    {
        $this->imgID = $imgID;

        return $this;
    }

    /**
     * Get the value of dateOfCreation
     */ 
    public function GetDateOfCreation()
    {
        return $this->dateOfCreation;
    }

    /**
     * Set the value of dateOfCreation
     *
     * @return  self
     */ 
    public function SetDateOfCreation($dateOfCreation)
    {
        $this->dateOfCreation = $dateOfCreation;

        return $this;
    }

    /**
     * Get the value of diagnosis
     */ 
    public function GetDiagnosis()
    {
        return $this->diagnosis;
    }

    /**
     * Set the value of diagnosis
     *
     * @return  self
     */ 
    public function SetDiagnosis($diagnosis)
    {
        $this->diagnosis = $diagnosis;

        return $this;
    }

    /**
     * Get the value of treatment
     */ 
    public function GetTreatment()
    {
        return $this->treatment;
    }

    /**
     * Set the value of treatment
     *
     * @return  self
     */ 
    public function SetTreatment($treatment)
    {
        $this->treatment = $treatment;

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

    function InitWithRecordID($recordID) {
        $db = Database::GetInstance();
        $data = $db->singleFetch('SELECT * FROM Medicalrecords WHERE RecordID = ' . $recordID);
        $this->initWith($data->RecordID, $data->CreatedBy, $data->LastEditedBy, $data->PatientCPR, $data->ImgID, $data->DateOfCreation, $data->Diagnosis, $data->Treatment, $data->Notes);
    }
    
    private function InitWith($recordID, $createdBy, $lastEditedBy, $patientCPR, $imgID, $dateOfCreation, $diagnosis, $treatment, $notes) {
        $this->recordID = $recordID;
        $this->createdBy = $createdBy;
        $this->lastEditedBy = $lastEditedBy;
        $this->patientCPR = $patientCPR;
        $this->imgID = $imgID;
        $this->dateOfCreation = $dateOfCreation;
        $this->diagnosis = $diagnosis;
        $this->treatment = $treatment;
        $this->notes = $notes;
    }

    function InsertMedicalRecord() {
            try {
                $db = Database::GetInstance();
                $data = $db->querySql('INSERT INTO Medicalrecords (RecordID, CreatedBy, PatientCPR, ImgID, DateOfCreation, Diagnosis, Treatment, Notes) VALUES (NULL, \'' . $this->createdBy . '\',\'' . $this->patientCPR . '\',\'' . $this->imgID  . '\',\'' . date("Y-m-d H:i:s") . '\',\'' . $this->diagnosis . '\',\'' . $this->treatment . '\',\'' . $this->notes . '\')');
                echo $data;
                return true;
            } 
            catch (Exception $e) {
                echo 'Exception: ' . $e;
                return false;
            }
    }
    
    function UpdateMedicalRecord() {
        try {
            $db = Database::GetInstance();
            $data = 'UPDATE Medicalrecords Set
                            LastEditedBy = \'' . $this->lastEditedBy . '\',
                            Diagnosis = \'' . $this->diagnosis . '\',
                            Treatment = \'' . $this->treatment . '\',
                            Notes = \'' . $this->notes . '\'
                            WHERE RecordID = ' . $this->recordID;

            $db->querySql($data);
            return true;
        }
        catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    function GetAllPatientRecords($cpr) {
        $db = Database::GetInstance();
        $data = $db->multiFetch('Select * from Medicalrecords where PatientCPR = ' . $cpr);
        return $data;
    }

    function GetAllMedicalRecords() {
        $db = Database::GetInstance();
        $data = $db->multiFetch('Select * from Medicalrecords');
        return $data;
    }

    public function isValid() {
        $errors = array();
        $check = true;

        if (empty($this->patientCPR)) {
            $errors[] = 'You must enter a patient cpr';
            $check = false;
        }

        return $check;
    }
  }

?>