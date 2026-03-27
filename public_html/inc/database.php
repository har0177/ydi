<?php

/**
 * Description of database
 *
 * @author Haroon
 */

// Ensure environment is loaded
if (!function_exists('env')) {
    require_once __DIR__ . '/env_loader.php';
}

class database {

    /**
     * Connection Holder
     * @var PDO Connection Object
     */
    private ?PDO $_con = null;

    private mixed $_rs = null;

    private int $_id = 0;

    public function __construct() {
        $options = array(
            PDO::ATTR_PERSISTENT => TRUE,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_EMULATE_PREPARES => false
        );
        try {
            $host = defined('DBHOST') ? DBHOST : env('DB_HOST', 'localhost');
            $dbname = defined('DBNAME') ? DBNAME : env('DB_NAME_PUBLIC', 'ydiedu_ydi');
            $username = defined('DBUNAME') ? DBUNAME : env('DB_USERNAME');
            $password = defined('DBPASS') ? DBPASS : env('DB_PASSWORD');

            $con_string = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
            $this->_con = new PDO($con_string, $username, $password, $options);
        } catch (PDOException $e) {
            if (defined('APP_DEBUG') && APP_DEBUG) {
                msgBox("error", $e->getMessage());
            } else {
                msgBox("error", "Database connection failed. Please try again later.");
                error_log("Database Error: " . $e->getMessage());
            }
            exit();
        }
    }
    
    public function __destruct() {
         try {
             $this->close();
             } catch (PDOException $e) {
            msgBox("error", $e->getMessage());
            }
    }

   

    public function query($stmt, $args = NULL){
     try {
         $this->_rs = $this->_con->prepare($stmt);
         if($args === NULL){
             $this->_rs->execute();
         }else{
             $this->_rs->execute($args);
         }
         $this->_id = $this->_rs->rowCount();
        
         } catch (PDOException $e) {
             throw $e;
        }
}

public function runQuery($stmt, $args = NULL){
  try {
         $this->_rs = $this->_con->prepare($stmt);
         if($args === NULL){
             $this->_rs->execute();
         }else{
             $this->_rs->execute($args);
         }
         $this->_id = $this->_con->lastInsertId();
        
         } catch (PDOException $e) {
             throw $e;
        }
}

public function lastInsertId(){
        return $this->_con->lastInsertId();
    }
    
public function queryValue($stmt, $field = NULL, $args = NULL){
    $output = FALSE;
    $field = (is_array($field))? $field : array($field);
    try{
        $this->query($stmt, $args);
        if($this->rowCount() > 0){
            $r = $this->fetchObject();
            foreach ($field as $value) {
                $output[$value] = $r->$value;
            }
        }
    }  catch (PDOException $e){
        throw $e;
    }
    return (object) $output;
}

public function fetchObject(){
    return  $this->_rs->fetch(PDO::FETCH_OBJ);
}

public function fetchNum(){
    return  $this->_rs->fetch(PDO::FETCH_NUM);
}

public function fetchASSC(){
    return  $this->_rs->fetch(PDO::FETCH_ASSOC);
}


public function rowCount(){
    return $this->_id;
}

public function insertId(){
    return $this->_id;
}
public function close(){
     try {
         $this->_con = NULL;
         $this->_rs = NULL;
         } catch (PDOException $e) {
             throw $e;
        }
}
}