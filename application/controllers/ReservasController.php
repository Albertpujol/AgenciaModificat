<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ReservasController extends ControllerBase{
    
    protected $model;
    protected $view;
    private $conf;
    
    /** 
     * Funcio construct que utilitzem per indicarli la configuració que s'aplicarà
     * Quin serà el model associat a aquest controlador el qual processara les dades
     * i quina serà la vista que mostrara la informació
     */
    
    public function __construct($arr) {
    parent::__construct($arr);
    //carregar la configuració
    $this->conf=$this->config;
    $this->model= new ReservasModel($arr);
    $this->view=new View();
    
    
    
    }
    
    /**
     * afegir configuració per ruta publica, enllaços, css ,js...
     */
    public function index(){
               
        $this->view->setProp($this->model->getDataout());
        //afegir configuració per ruta publica, enllaços, css ,js...
        $this->view->addProp(array('APP_W'=>$this->conf->APP_W));
        $this->view->setTemplate(APP.'/public/tpl/register.html');
        $this->view->render();
        
        
    }
    

    
     /** 
      * funció que utilitzem per comprobar si un usuari te alguna reserva pendent
      * en el cas de que no en tingui podra reservar
      * Un cop comprobat introduim registre a reserves i serveis reservats
      * 
      * @param string $usuari: s'utilitza per a guardar el email del usuari el qual esta loguejat
      * @param string $places: s'utilitza per a guardar el numero de persones que voldran el servei que es passa desde formulari
      * @param string $id_servei:s'utilitza per guardar el id del servei a reservar
      * @param string $user: es retorna en aquest variable el id dle usuari que vol fer la reserva
      * @param string $html:es retorna el resultat del bucle per recorrer el array associatiu
      * @param string $id_usuari: guardem el valor del $html
      * @param string $reservas: retorna si el usuari pot fer reserva o no
      * @param string $fer_reserva:retorna el insert que ha fet a la base de dades
      * @param string $serveis_reservats: retorna el insert a la taula serveis_reservats
     */
    
    public function comprobar_reservas(){
        //session:set('email',$email);
       if(isset($_SESSION["usuari"]))
       {
        $html="";
        $html2="";
        $usuari = $_SESSION["usuari"];
        $places = $_POST['opcio'];
        $id_servei = $_POST['id'];//id del servei que volem reservar
        $user = $this->model->seleccionar_iduser($usuari);//ens retorna el id del usuari que vol fer la reserva
        foreach ($user as $campo){//obtenim el id del usuari
        $html = $html.$campo['id'];   
        }
        $preu = $this->model->calcular_preu($id_servei);
        $preu2 = $preu;
        if($preu2 == true)
        {
        foreach($preu as $campo2){
        $html2 = $html2.$campo2['preu'];   
        }
        
        }
        
        $id_usuari = $html;//ho posem en una variable, la qual reconeguem
        $reservas = $this->model->seleccionar_reservas($id_usuari);//Ens retorna true o false depenent si el usuari te reserves pendents de pagar, o mai a fet cap
        }
        if($reservas == true)
        {
            $preu_final = $html2 * $places;
            print_r($html2);
            $fer_reserva = $this->model->fer_reserva($id_usuari,$id_servei,$preu_final);
            $serveis_reservats = $this->model->serveis_reservats($id_servei,$id_usuari,$places,$preu_final);
            print_r("Reserva realitzada correctament!!!");
            echo "</br>";
            echo "</br>";
            echo "<h2><a href='".APP_W."/index'>Tornar</a></h2>";
        }else{
            print_r("Te encara una reserva pendent de abonar!");
            echo "</br>";
            echo "</br>";
            echo "<h2><a href='".APP_W."/index'>Tornar</a></h2>";
        }
        
        
       }
       
       public function cistell(){
           
       if(isset($_SESSION["usuari"]))
       {
       $html = "";
       $html2 = "";
       $html3 ="";
       $usuari = $_SESSION["usuari"];
       $user = $this->model->seleccionar_iduser($usuari);
       foreach ($user as $campo){//obtenim el id del usuari
        $html = $html.$campo['id'];   
        }
        $id_usuari = $html;
        $html = "";
        $status = $this->model->seleccionar_status($id_usuari);
        if($status == true)
        {
       foreach ($status as $campo){//obtenim el id del usuari
        $html = $html.$campo['id'];
        $html2 = $html2.$campo['status'];   
        }
        $status2 = $html2;
        $id_reserva = $html;
       // print_r($id_servei);
       
       $serveisres = $this->model->seleccionar_serveisres($id_reserva);//ens retorna el id del usuari que vol fer la reserva
       foreach ($serveisres as $campo){//obtenim el id del usuari
       $html3 = $html3."<div>"."<table border=2 cellspacing=12 width=350><tr><td>servei</td><td>reserva</td><td>data_reserva</td><td>places</td><td>preu</td><td>status</td><tr><td>".$campo['idservei']."</td><td>".$campo['idreserva']."</td><td colspan=1> ".$campo['dataRes']."</td><td> ".$campo['places']."</td><td>".$campo['preu_servei']."€</td><td> ".$status2."</div></table>";   
       }
       //$sentencia = $this->model->view_cistell();
        }
       if($status == true)
       {
       $html3 = $html3."<form method='POST' action=".APP_W.'/reservas/pagar_reservas'."><input type='submit' value='pagar reserva'>"."<input type='hidden' name='id' value=".$id_reserva."></form>";
       }
       $html3 = $html3."<br>";
       $html3 = $html3."<br>";
       $html3 = $html3."<a href='".APP_W."/index'>Tornar</a>";
       
       $remplazo = array("html" => $html3);
              
       
        $this->view->addProp($remplazo);
        $this->view->setTemplate(APP.'/public/tpl/cistell.html');
        $this->view->render();
       }else{
           echo "No esta iniciat amb cap usuari registrat";
           
       }
        
       }
       
       public function pagar_reservas(){
           
           $html="";
           $html2="";
           $id_reserva = $_POST['id'];
           $metode = 1;
          
            $dades = $this->model->seleccionar_dades($id_reserva);
            if($dades == true)
            {
            foreach ($dades as $campo){//obtenim el id del usuari
            $html2 = $html2.$campo['preu_servei']; 
            }
            $preu = $html2;
           
           $pagar1 = $this->model->insert_pagar($id_reserva,$metode,$preu);
           
           if($pagar1 == true)
           {
               print_r("correcte");
           }else{
               
               print_r("incorrecte");
           }
           $pagar2 = $this->model->pagar_reserva($id_reserva);
           if($pagar2 == false)
           {
               $this->redirect('reservas\cistell');
           }else{
               print_r("No s'ha pogut actualitzar correctament");
           }
            }else{
                
            }
           
       }
       
    
            
    
}
    
    
