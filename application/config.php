<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * En aquest apartat definim quins serán els parametres de accés a la base de dades
 * Si es en localhost o en una web al núvol,el password de la BBDD el usuari que utilitzem per accedir
 */
    $config = Config::getInstance();
    $config->dbhost='localhost';
    $config->dbname='test';
    $config->dbuser='root';
    $config->dbpass='';
    $config->app_='';
    
           
            
    