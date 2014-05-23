<?php

/**
 * Database 
 * dona accés a la base de dades
 * persistència de dades
 */
    class Database{
        //private static $db;
        private $dbh;
        
        function __construct() {
            try{
                $config=Config::getInstance();
               
                $this->dbh = new PDO( 'mysql:host='.$config->dbhost.';dbname='.
                        $config->dbname, $config->dbuser, $config->dbpass );
 
            }catch(PDOException $e){
                echo 'Connexio fallida: '. $e->getMessage()."n";
                self::$dbh = null;
                
            
            }
            
        }
        
         /**
         * Allow no body to clone the instance
         *
         * @access private
         */
        private function __clone(){}
        
        

        /**
         * Get the singleton object. Must be called at least once
         * before using any static PDO methods BUT
         * Magic methods call it for the client 
         *
         * @access public
         * @return DB
         */
        public static function  instance()
        {
            if(!self::$db)
            {
                self::$db = new DB;
            }
            return self::$db;
        }



        /**
         * Change database you are working on, it has to be 
         * on the same server and the same user can access it
         *
         * @access public
         * @param String $database
         * @return void
         */
        public static function changeDatabase($database)
        {
            self::instance()->exec('USE '.$database);
        }



        /**
         * Magic methods to call PDO methods directly through this object
         *
         * @access public
         * @param String $method
         * @param Array $args
         */
        public function __call($method, $args = array())
        {
            return call_user_func_array(array($this->dbh, $method), $args);
        }



        /**
         * Magic methods to call PDO methods statically through this class
         *
         * @access public
         * @param String $method
         * @param Array $args
         */
        public static function __callStatic($method, $args = array())
        {
            $db = self::instance();

            return call_user_func_array(array($db->dbh, $method), $args);
        }
    }
