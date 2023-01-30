<?php

  class Title {

    private $titleID;
    private $title;
    private $accessLevel;

    function __Construct() {
        $this->titleID = null;
        $this->title = null;
        $this->accessLevel = null;
    }

    /**
     * Get the value of titleID
     */ 
    public function GetTitleID()
    {
        return $this->titleID;
    }

    /**
     * Set the value of titleID
     *
     * @return  self
     */ 
    public function SetTitleID($titleID)
    {
        $this->titleID = $titleID;

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
     * Get the value of accessLevel
     */ 
    public function GetAccessLevel()
    {
        return $this->accessLevel;
    }

    /**
     * Set the value of accessLevel
     *
     * @return  self
     */ 
    public function SetAccessLevel($accessLevel)
    {
        $this->accessLevel = $accessLevel;

        return $this;
    }

    function InitWithTitleID($titleID) {
        $db = Database::GetInstance();
        $data = $db->singleFetch('SELECT * FROM Titles WHERE TitleID = ' . $titleID);
        $this->initWith($data->TitleID, $data->Title, $data->AccessLevel);
    }
    
    private function InitWith($titleID, $title, $accessLevel) {
        $this->titleID = $titleID;
        $this->title = $title;
        $this->accessLevel = $accessLevel;
    }

    function InsertTitle($title, $accessLevel) {

        if ($this->isValid()) {
            try {
                $db = Database::GetInstance();
                $data = $db->querySql('INSERT INTO Titles (TitleID, Title) VALUES (NULL, \'' . $title . '\',\'' . $accessLevel . '\')');
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
    
    function UpdateTitle() {
        if ($this->isValid()) {
            try {
                $db = Database::GetInstance();
                $data = 'UPDATE Titles Set
			        Title = \'' . $this->title . '\' 
				    WHERE TitleID = ' . $this->titleID;

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
    
    function DeleteTitle() {
        try {
            $db = Database::GetInstance();
            $data = $db->querySql('Delete from Titles where TitleID=' . $this->titleID);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    function GetAllTitles() {
        $db = Database::GetInstance();
        $data = $db->multiFetch('Select * from Titles');
        return $data;
    }

    function GetEmpAccessLevel($titleID) {
        try {
            $db = Database::GetInstance();
            $data = $db->singleFetch('Select * from Titles where TitleID=' . $titleID);
            return $data;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

    public function isValid() {
        $errors = array();
        $check = true;

        if (empty($this->title)) {
            $errors[] = 'You must enter a title';
            $check = false;
        }

        return $check;
    }
  }

?>