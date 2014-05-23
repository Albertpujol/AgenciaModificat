<?php
    
    /**
     * @param string $require: es equivalent a un import per poder utilitzar totes les variables del arxiu
     * Es definixen les rutes dels controladors i models
     * El arxiu index.php es el que carrega l'aplicació inicia el bootstrap,JSON i la configuració
     */
    
     require 'config.inc';
     set_include_path(get_include_path().DS.ROOT.'application/controllers');
     set_include_path(get_include_path().DS.ROOT.'application/models');
     // en config.php desem la configuració de l'aplicació
     // en constants.php desem la informació rellevant d'enllaços
     // i títols
     // Es requereix config.php per configurar l'accés a BBDD
     //require_once APP.'config.php';
     // Es requereix constants.php per definir diccionari de l'aplicació
     require_once APP.'constants.php';
    
    session::init(); //Posem aquesta comanda per a iniciar sessio
    
    abstract class Index{
        
        /**
         * Funcio run que utilitzem per a que carregui tota la aplicació
         */
        static function run(){
            try{
                $conf=Config::getInstance();
                $conf->JSON();
                $front= Bootstrap::getInstance();
                $front->route();
            } catch(Exception $e){
            echo $e->getMessage();
            }
        }
    }
    Index::run();

