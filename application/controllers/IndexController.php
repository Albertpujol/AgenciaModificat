<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IndexController
 *
 * @author toni
 */

class IndexController extends ControllerBase{
    protected $model;
    protected $view;
    private $conf;
    
    /**
     * rep con a paràmetre un array associatiu que 
     * permet passar els paràmetres de la URI
     * @param array $arr
     */
    public function __construct($arr) {
        parent::__construct($arr);
       //carregar la configuració
        $this->conf=$this->config;
        $this->model= new IndexModel($arr);
        $this->view=new View();
        
        
       
    }
    public function index(){
               
        $this->view->setProp($this->model->getDataout());
        //afegir configuració per ruta publica, enllaços, css ,js...
        $this->view->addProp(array('APP_W'=>$this->conf->APP_W));
        $this->view->setTemplate(APP.'/public/tpl/index.php');
        $this->view->render();
        
        
    }
    public function a(){
        $this->model->a();
        $this->view->setProp($this->model->getDataout());
        $this->view->addProp($this->conf->getData());
        $this->view->setTemplate(APP.'/public/tpl/index.php');
        $this->view->render();
    }
    public function suma(){
        $this->model->suma();
        $sum=$this->model->getDataout();
        $this->view->setProp($this->model->getDataout());
        $this->view->addProp($this->conf->getData());
        $this->view->setTemplate(APP.'/public/tpl/index.php');
        $this->view->render();
    }
    
     /**
     * Funció Login per poder iniciar sessió amb un usuari previament registrat 
     * @param string $email: L'utilitzem per a agafar el email que introdueix el usuari per formulari
     * @param string $password: L'utilitzem per a agafar el password que introdueix el usuari per formulari
     * @param string $user: Variable que retorna true o false depenent de si les dades son correctes a la base de dades
     */
    public function login() {

       if(isset($_POST['email']))
        {
            
            $email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);
            $password = /*md5(*/filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);
            $user = $this->model->login($email,$password);
            if($user == true)
            {
                session::set("usuari", $email);
                //session::set("usuari",$email);
                $this->Redirect('index');
            }else{
                $this->Redirect('register');
               
            }
            
        }
        
    }
    
     /**
     * Funció register per poder registrar un usuari de la agencia a la base de dades 
     * 
     * @param string $email: L'utilitzem per a agafar el email que introdueix el usuari per formulari
     * @param string $password: L'utilitzem per a agafar el password que introdueix el usuari per formulari
     * @param string $pass_conf: L'utilitzem per a agafar per segon cop el password que introdueix el usuari per formulari
     * @param string $nom: L'utilitzem per a agafar el nom que introdueix el usuari per formulari
     * @param string $cognoms: L'utilitzem per a agafar els cognoms que introdueix el usuari per formulari
     * @param string $registre:Es crida a la funcio register del model 
     */
    public function register(){

        $this->view->setTemplate(APP.'/public/tpl/register.html');
        
        $this->view->render();
         
        try{
        
            //Falta comprovar que el email no existeixi a la base de dades

            $email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);
            $password = /*md5(*/filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);
            $pass_conf = /*md5(*/filter_input(INPUT_POST,'pass_conf',FILTER_SANITIZE_STRING);
            
            if($password == $pass_conf)//comprobem que els passwords son iguals
            {
                $nom = filter_input(INPUT_POST,'nom',FILTER_SANITIZE_STRING);
                $cognoms = filter_input(INPUT_POST,'cognoms',FILTER_SANITIZE_STRING);
                $registre = $this->model->register($email,$password,$pass_conf,$nom,$cognoms);
                $this->Redirect('index');
            }
          
        
            $this->Redirect('index');//L'utilitzem per a redireccionar al index
        
        }catch(PDOException $ex){
            echo $ex;
            $this->Redirect('index/register');
        }
            

    
   }
   
     /**
     * Funció view_vols que ens mostra els vols disponibles 
     * 
     * @param string $html: L'utilitzem per emmagatzemar el contingut del array despres de fer el foreach la inicialitzem aqui
     * @param string $sentencia: variable que retorna el array associatiu despres de cridar a la funcio view_vols del model
     * @param string $remplazo: Viable que s'encarrega de substituir el valor del html per el del array
     */
   public function view_vols(){ //funcio que mostra els vols disponibles 
       
       $html = "";
       $sentencia = $this->model->view_vols();
       if(isset($_SESSION["usuari"]))
       {
       foreach ($sentencia as $campo){
           $html = $html."<div>".$campo['dest']." || ".$campo['aeroport']." || ".$campo['codi_aeri']." || ".$campo['dataVol']." </div>"."<form method='POST' action=".APP_W.'/reservas/comprobar_reservas'."><input type='hidden' name='id' value=".$campo['id']."><select name='opcio'><option value=1>1</option><option value=2>2</option><option value=3>3</option><option value=4>4</option></select><input type='submit' value='reservar'>"."</form>"
                   . "---------------------------------------------------";
           
       }
       $html = $html."<br>";
       $html = $html."<br>";
       $html = $html."<a href='".APP_W."/index'>Tornar</a>";
       
       $remplazo = array("html" => $html);
              
       
        $this->view->addProp($remplazo);
        $this->view->setTemplate(APP.'/public/tpl/vols.html');
        $this->view->render();
       }else{
       $html = "";
       $sentencia = $this->model->view_vols();
       
       foreach ($sentencia as $campo){
           $html = $html."<div>".$campo['id']." || ".$campo['dest']." || ".$campo['aeroport']." || ".$campo['codi_aeri']."</br>"
           . "---------------------------------------------------";
           
       }
       $html = $html."<br>";
       $html = $html."<br>";
       $html = $html."<a href='".APP_W."/index'>Tornar</a>";
       
       $remplazo = array("html" => $html);
              
       
        $this->view->addProp($remplazo);
        $this->view->setTemplate(APP.'/public/tpl/vols.html');
        $this->view->render();   
           
       }
       
         
   }
     /**
     * Funció view_plans que ens mostra els plans disponibles 
     * 
     * @param string $html: L'utilitzem per emmagatzemar el contingut del array despres de fer el foreach la inicialitzem aqui
     * @param string $sentencia: variable que retorna el array associatiu despres de cridar a la funcio view_plans del model
     * @param string $remplazo: Viable que s'encarrega de substituir el valor del html per el del array
     */
   
   public function view_plans(){ //funcio que mostra els plans disponibles 
       
       $html = "";
       $sentencia = $this->model->view_plans();
       
       if(isset($_SESSION["usuari"]))
       {
           
       foreach ($sentencia as $campo){
           $html = $html."<div>".$campo['descrip']."</div>"."<form method='POST' action=".APP_W.'/reservas/comprobar_reservas'."><input type='hidden' name='id' value=".$campo['id'].">Persones:<select name='opcio'><option value=1>1</option><option value=2>2</option><option value=3>3</option><option value=4>4</option></select><input type='submit' value='reservar'>"."</form>"
           . "---------------------------------------------------";
           
       }
       
       $html = $html."<br>";
       $html = $html."<br>";
       $html = $html."<h2><a href='".APP_W."/index'>Tornar</a></h2>";
     
       $remplazo = array("html" => $html);
       
       
        $this->view->addProp($remplazo);
        $this->view->setTemplate(APP.'/public/tpl/plans.html');
        $this->view->render();
       }else{
           
        foreach ($sentencia as $campo){
        $html = $html."<div>".$campo['id']." || ".$campo['descrip']."</br>"
        . "---------------------------------------------------";
           
       }
       
       $html = $html."<br>";
       $html = $html."<br>";
       $html = $html."<h2><a href='".APP_W."/index'>Tornar</a></h2>";
     
       $remplazo = array("html" => $html);
       
       
              
       
        $this->view->addProp($remplazo);
        $this->view->setTemplate(APP.'/public/tpl/plans.html');
        $this->view->render();  
           
           
       }
       
         
   }
     /**
     * Funció view_hotels que ens mostra els vols disponibles 
     * 
     * @param string $html: L'utilitzem per emmagatzemar el contingut del array despres de fer el foreach la inicialitzem aqui
     * @param string $sentencia: variable que retorna el array associatiu despres de cridar a la funcio view_hotels del model
     * @param string $remplazo: Viable que s'encarrega de substituir el valor del html per el del array
     */
   
      public function view_hotels(){ //funcio que mostra els hotels disponibles 
       
       $html = "";
       $sentencia = $this->model->view_hotels();
       
       if(isset($_SESSION["usuari"]))
       {
       foreach ($sentencia as $campo){
           $html = $html."<div>".$campo['nom']." || ".$campo['ciutat']." || ".$campo['categoria']."</div>"."<form method='POST' action=".APP_W.'/reservas/comprobar_reservas'."><input type='hidden' name='id' value=".$campo['id'].">Persones:<select name='opcio'><option value=1>1</option><option value=2>2</option><option value=3>3</option><option value=4>4</option></select><input type='submit' value='reservar'>"."</form>"
                   . "---------------------------------------------------";
           
           
       }
      
       $html = $html."<br>";
       $html = $html."<br>";
       $html = $html."<a href='".APP_W."/index'>Tornar</a>";
       $html = $html."<img src='".APP."/application/public/img/rss_news.gif'/>";
     
       $remplazo = array("html" => $html);
              
       
        $this->view->addProp($remplazo);
        $this->view->setTemplate(APP.'/public/tpl/hotels.html');
        $this->view->render();
       
       }else{
           foreach ($sentencia as $campo){
           $html = $html."<div>".$campo['nom']." || ".$campo['ciutat']." || ".$campo['categoria']."</br>"
                   . "---------------------------------------------------";
           
           
       }
      
       $html = $html."<br>";
       $html = $html."<br>";
       $html = $html."<a href='www.elperiodico.com'><img src='".APP_W."/application/public/img/rss_news.gif'/></a>";
       $html = $html."<br>";
       $html = $html."<a href='".APP_W."/index'>Tornar</a>";
     
       $remplazo = array("html" => $html);
              
       
        $this->view->addProp($remplazo);
        $this->view->setTemplate(APP.'/public/tpl/hotels.html');
        $this->view->render();
           
       }
         
   }
    
    /**
     * funció per mostrar la pagina html del formulari de registre
     */
    public function view_register(){
           
         $this->view->setTemplate(APP.'/public/tpl/register.html');
         $this->view->render();
        }
        
     /**
     * Funció per a tancar sessió
     */
    public function logout(){
         session::destroy("usuari");
         $this->Redirect('index');
        }
}
