<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class UserModel extends Model{
    
    /**
     * Funcio no utilitzada a la agencia de viatges
     * 
     */
    
    public function __construct($arr) {
        parent::__construct($arr);
        //parametres de configuració
        $this->datain=$this->config;
        //afegir en DataOut els paràmetres URI
        $this->setDataout($arr);
    }
    
     /**
     * Funcio no utilitzada a la agencia de viatges
     * 
     */
    public function edit(){
        $camp=array_pop(array_keys($this->dataout));
        $cont=  strlen(array_pop($this->dataout));
        $this->dataout=array('camp'=>$camp,'leng'=>$cont);
    }
}

