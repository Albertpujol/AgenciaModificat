<?php
    class SPDO extends PDO
    {
            private static $instance = null;

            public function __construct()
            {
                    $config = Config::getInstance();
                    try{
                        parent::__construct($config->driver.':host=' . $config->dbhost . ';dbname=' .$config->dbname,$config->dbuser, $config->dbpass);}
                    catch (PDOException $e) {
                     echo 'Connection failed: ' . $e->getMessage();}

            }

            public static function singleton()
            {
                    if( self::$instance == null )
                    {
                            self::$instance = new self();
                    }
                    return self::$instance;
            }
            
    }

