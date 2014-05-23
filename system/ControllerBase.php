<?php


/**
 * Description of ControllerBase
 *
 * @author toni
 */
class ControllerBase {
    
    protected $model;
    protected $view;
    protected $config;
    protected $arguments=array();
    
  function __construct($arr) {
      $conf=  Config::getInstance();
      $conf->APP_W =  dirname(filter_input(INPUT_SERVER, 'SCRIPT_NAME',FILTER_SANITIZE_URL));
      $this->config=$conf;
      $this->arguments=$arr;
        /**
         * instanciem model
         */
      //  $this->model=new Model($arr);
      //  $this->view=new View()
    }
    
    
    
      public function redirect($pagina)
      {
          if( isset($pagina) )
          {
              header('location:'.APP_W.'/'.$pagina);
              
          }else{
              header('location:'.APP_W.'/'.index);
           
          }
          
          
      }
}
