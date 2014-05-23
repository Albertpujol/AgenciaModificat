<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bootstrap
 * Inicia el sistema
 * És una classe singleton que controla el fluxe del programa
 * 
 * @author toni
 */

class Bootstrap {
    protected $controller;
    protected $action;
    protected $params;
    protected $body;
    
    static $instace;
    
    public static function getInstance(){
        if (!(self::$instace instanceof self)){
            self::$instace=new self();
        }
        return self::$instace;
        }
        

   private function __construct() {
            $request = filter_input(INPUT_SERVER,'REQUEST_URI',FILTER_DEFAULT);
            $parts=explode('/',trim($request,'/'));
            //treiem part del nom d'aplicació
            array_shift($parts);
            
            $this->controller=!empty($parts[0])?$parts[0]==="index.php"?DEF_CONTROLLER:$parts[0]:DEF_CONTROLLER;
            $this->action=!empty($parts[1])?$parts[1]:DEF_ACTION;
            // completem un array associatiu amb el paràmetres.
            if (!empty($parts[2])){
                $keys=$values=array();
                for($i=2,$cnt=count($parts);$i<$cnt;$i++){
                    if($i%2==0){
                        // si és parell és una clau
                        $keys[]=$parts[$i];
                    }
                    else{
                        //és imparell és un valor
                        $values[]=$parts[$i];
                    }
                }
               
                   $this->params=  array_combine($keys, $values);
                
            }
        }
        public function route(){
            $classe=ucfirst(strtolower($this->getController())).'Controller';
            if (class_exists($classe)){
                
                $routeCont=new ReflectionClass($classe);
                if($routeCont->hasMethod($this->getAction())){
                    $controller=$routeCont->newInstance($this->params);
                    $method=$routeCont->getMethod($this->getAction());
                    $method->invoke($controller);
                }else{
                    throw new Exception("No Action");
                }
            }else{throw new Exception("No Controller");}
        }
        
//        public function route(){
//            /**
//             * Selecció del controlador i arrencada del Controller
//             */
//            $path=APP.'controllers';
//            $classe=ucfirst(strtolower($this->getController())).'Controller';
//            $path_classe=$path.DS.$classe;
//            $file=$path_classe.'.php';
//            if(is_readable($file)){
//                require_once $file;
//                $controller = new $classe();
//                
//                if(is_callable(array($controller, $this->action))){
//                    if(isset($this->params)){
//                        call_user_func_array(array($controller, $this->action,$this->params));
//                    }
//                    else{
//                        call_user_func(array($controller, $this->action));
//                    }
//                } 
//            }
//            else{
//                $this->request_not_found("");
//            }
//        }
        function request_not_found($c) {
                header("HTTP/1.1 404 Not Found");
                die('<html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL was not found on this server.</p>'.
                        $c.'<p>Please go <a href="javascript: history.back(1)">back</a> and try again.</p><hr /><p>Powered By: <a href="http://calarroba.esy.es">Cal\'@</a></p></body></html>');
        }
        public function getController(){
            return $this->controller;
        }
        public function getAction(){
            return $this->action;
        }
        public function getParams(){
            return $this->params;
                    
        }
    
}
