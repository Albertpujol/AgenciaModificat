<?php

/**
 * Description of View
 *
 * @author toni
 */
class View  {
    /**
     *
     * @template plantilla en html
     * @properties propietats substituïbles al template i
     *  els seus valors en array associatiu.
     */
    protected $template;
    protected $properties;
    
    public function __construct() {
        $this->properties=array();
        
    }
   
    /**
     * Estableix la plantilla
     * @param file $file
     */
    public function setTemplate($file){
        $this->template=  file_get_contents($file);
    }
    /**
     * Remplaçar propietats
     * en layout
     */
    public function setProp($arr){
        $this->properties=$arr;
    }
    /**
     * per afegir array de propietats a substituir
     * @param array $arr
     */
    public function addProp($arr){
        if ($arr || $this->properties){
            if ($this->properties==null){
                $this->properties=$arr;
            }
            else{
            $this->properties= array_merge($this->properties,$arr);
            }
        }
    }
    public function getTemplate(){
        return $this->template;
    }
    /**
     * Substitueix en la plantilla els valors dinàmics passats
     * a través de l'array de propietats
     */
    private function transform(){
        $html=  $this->template;
        if ($this->properties){
        foreach ($this->properties as $clau => $valor) {
            $html=str_replace('{'.$clau.'}',$valor, $html);
        }
        $this->template=$html;
        }
    }
    
    public  function render(){
        //comencem sortida
        ob_start();
        $this->transform();
        
        //print($this->template);
        // la funció eval permet utilitzar expressions
        // del tipus <?= $valor; dintre de la plantilla
        eval('?>'.$this->template.'<?');
        
        
    }
            
}
