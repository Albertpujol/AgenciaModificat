<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IndexView
 *
 * @author toni
 */
class IndexView extends View{
    
    /**
     * Funcio per a carregar la vista de index.php
     */
    public function __construct() {
        parent::__construct();
        
        $this->loadTemplate(APP.'/public/tpl/index.php');
        print_r($this->template);
          
           
    }
    
    //put your code here
}
