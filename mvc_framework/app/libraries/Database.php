<?php

    class Database{

        private $db_HOST = DB_HOST;
        private $db_USER = DB_USER;
        private $db_PASS = DB_PASS;
        private $db_NAME = DB_NAME;
    
        private $statement;
        private $db_HANDLER;
        private $error;

        public function __construct(){
            
            $connection = 'mysql:host=' . $this-> db_HOST . ';dbname=' . $this-> db_NAME;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            try{
                $this->db_HANDLER = new PDO($connection, $this->db_USER, $this->db_PASS, $options);
            } catch(PDOException $err){
                $this->error = $err-> getMessage();
                echo $this->error;
            }

        }

        //Method to write Queries
        public function query($sql){
            $this-> statement = $this-> db_HANDLER-> prepare($sql);
        }

        //Method to Bind values
        public function bind($parameter, $value, $type=null){
            switch(is_null($type)){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }

            $this-> statement-> bindValue($parameter, $value, $type);
        }

        //Execution of prepared statement
        public function execute(){
            return $this-> statement-> execute();
        }

        //Return array results
        public function resultSet(){
            $this-> execute();
            return $this-> statement-> fetchAll(PDO::FETCH_OBJ);
        }

        //Return user credentials upon login request as single row object
        public function single(){
            $this-> execute();
            return $this-> statement-> fetch(PDO::FETCH_OBJ);
        }

        //Method to get the row count
        public function rowCnt(){
            return $this-> statement-> rowCnt();
        }
    }