<?php

class Database {
    public static $instance = null;
    public $dblink = null;

    public static function GetInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new Database ( );
        }
        return self::$instance;
    }

    function __Construct() {
        if (is_null($this->dblink)) {
            $this->connect();
        }
    }

    function Connect() {
        $this->dblink = mysqli_connect('localhost', 'Mohamed', 'Mm34131399!', 'alsalmaniya2.0') or die('CAN NOT CONNECT');
    }

    function __Destruct() {
        if (!is_null($this->dblink)) {
            $this->close($this->dblink);
        }
    }

    function Close() {
        mysqli_close($this->dblink);
    }

    function QuerySQL($sql) {
        if ($sql != null || $sql != '') {
            $sql = $this->mkSafe($sql);
            mysqli_query($this->dblink, $sql);
        }
    }

    function SingleFetch($sql) {
        $sql = $this->MkSafe($sql);
        $fet = null;
        if ($sql != null || $sql != '') {
            $res = mysqli_query($this->dblink, $sql);
            $fet = mysqli_fetch_object($res);
        }
        return $fet;
    }

    function MultiFetch($sql) {
        $sql = $this->MkSafe($sql);
        $result = null;
        $counter = 0;
        if ($sql != null || $sql != '') {
            $res = mysqli_query($this->dblink, $sql);
            while ($fet = mysqli_fetch_object($res)) {
                $result[$counter] = $fet;
                $counter++;
            }
        }
        return $result;
    }

    function MkSafe($string) {
        
        $string = trim($string);
        $string = stripslashes($string);
        $string = htmlspecialchars($string);
          
        return $string;
    }

    function GetRows($sql) {
        $rows = 0;
        if ($sql != null || $sql != '') {
            $result = mysqli_query($this->dblink, $sql);
            $rows = mysqli_num_rows($result);
        }
        return $rows;
    }
}