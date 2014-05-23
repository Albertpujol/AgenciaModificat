<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IndexModel
 *
 * @author toni
 */
class IndexModel extends Model{
    
        /**
        * Funcio construct que utilitzem per indicarli la configuració que s'aplicarà
        * S'utilitza el addDataout per afegir al DataOut els paràmetres de URI
        */
    public function __construct($arr) {
        parent::__construct($arr);
        //parametres de configuració
        $this->datain=$this->config;
        //afegir en DataOut els paràmetres URI
        $this->addDataout($arr);
    }
    
    
    
      /** 
      * funció que utilitzem per fer el login comrpovant el email y password (En el model fem totes les gestions amb la base de dades)
      * 
      * @param string $consulta: s'utilitza per seleccionar tots els camps d'un usuari amb la condicio de coincidir amb el email y password introduits
      * @param string $consulta_sql:fem el prepare de la consulta amb la base de dades
      * a continuació amb el bindParam introduim els camps dels parametres de la consulta amb (?)
      * @param string $res: guardem el resultat de la consulta
      * @param string $Filas: Guardem si ha retornat algun registre la consulta o be no hi ha hagut registres
     */
    
    public function login($email,$password)
   {
        try{
        $consulta= "SELECT nom,cognoms,email,password,idrol FROM usuaris WHERE email = ? AND password = ? ";
        $consulta_sql = $this->db->prepare($consulta);
        $consulta_sql->bindParam(1,$email);
        $consulta_sql->bindParam(2,$password);
        $consulta_sql->execute();
        $res=$consulta_sql->fetch(PDO::FETCH_ASSOC);

        
       $Filas= $consulta_sql->RowCount();
       
            if($Filas == 1)
            {
                //session::set('logged',true);
                //session::set('user', new Usuari($res['nom'],$res['cognoms'],$res['email'],$res['idrol']));
                return true;
                
            }else{
                //session::set('logged',false);
                return false;
            }

        
          } catch (Exception $ex) {
              print "Error:".$ex->getMessage();
         }
   }
   
      /** 
      * funció que utilitzem per poder registrar un nou usuari en el nostre projecte de la agencia
      * 
      * @param string $consulta: s'utilitza per insertar a la base de dades a la taula usuarus tots els camps del mateix
      * @param string $consulta_sql:fem el prepare de la consulta amb la base de dades
      * a continuació amb el bindParam introduim els camps dels parametres de la consulta amb (?)
      * @param string $res: guardem el resultat de la consulta
     */
   public function register($email,$password,$nom,$cognoms){
       try{
           
           $consulta= "INSERT INTO usuaris (nom,cognoms,email,password,idrol) VALUES (?,?,?,?,1);";
           $consulta_sql = $this->db->prepare($consulta);
           $consulta_sql->bindParam(1,$nom);
           $consulta_sql->bindParam(2,$cognoms);
           $consulta_sql->bindParam(3,$email);
           $consulta_sql->bindParam(4,$password);
           $consulta_sql->execute();
           $consulta_sql->fetch(PDO::FETCH_ASSOC);
 
       } catch (Exception $ex) {

       }
   }
   
      /** 
      * funció que utilitzem per fer seleccionar tots els vols que tenim
      * 
      * @param string $consulta: s'utilitza per seleccionar tots els camps de la taula vols
      * @param string $consulta_sql:fem el prepare de la consulta amb la base de dades
      * @param string $res: guardem el resultat de la consulta
      * @param string $Filas: Guardem si ha retornat algun registre la consulta o be no hi ha hagut registres
     */
   function view_vols(){
       
       try{
           
           $consulta= "SELECT * FROM vols;";
           $consulta_sql = $this->db->prepare($consulta);
           $consulta_sql->execute();
           $res = $consulta_sql->fetchAll(PDO::FETCH_ASSOC);
         
           $Filas= $consulta_sql->RowCount();
       
            if($Filas >= 1)
            {
               return $res;
            }
       } catch (Exception $ex) {

       }
       
   }
   
      /** 
      * funció que utilitzem per fer seleccionar tots els plans que tenim
      * 
      * @param string $consulta: s'utilitza per seleccionar tots els camps de la taula plans
      * @param string $consulta_sql:fem el prepare de la consulta amb la base de dades
      * @param string $res: guardem el resultat de la consulta
      * @param string $Filas: Guardem si ha retornat algun registre la consulta o be no hi ha hagut registres
     */
      function view_plans(){
       
       try{
           
           $consulta= "SELECT * FROM plans;";
           $consulta_sql = $this->db->prepare($consulta);
           $consulta_sql->execute();
           $res = $consulta_sql->fetchAll(PDO::FETCH_ASSOC);
         
           $Filas= $consulta_sql->RowCount();
       
            if($Filas >= 1)
            {
               return $res;
            }
       } catch (Exception $ex) {

       }
       
   }
   
      /** 
      * funció que utilitzem per fer seleccionar tots els hotels que tenim
      * 
      * @param string $consulta: s'utilitza per seleccionar tots els camps de la taula hotels
      * @param string $consulta_sql:fem el prepare de la consulta amb la base de dades
      * @param string $res: guardem el resultat de la consulta
      * @param string $Filas: Guardem si ha retornat algun registre la consulta o be no hi ha hagut registres
     */
      function view_hotels(){
       
       try{
           
           $consulta= "SELECT * FROM hotels;";
           $consulta_sql = $this->db->prepare($consulta);
           $consulta_sql->execute();
           $res = $consulta_sql->fetchAll(PDO::FETCH_ASSOC);
         
           $Filas= $consulta_sql->RowCount();
       
            if($Filas >= 1)
            {
               return $res;
            }
       } catch (Exception $ex) {

       }
       
   }
   
    
    /**
     * Exemple de funció
     */
    public function a(){
        //cap al controlador
        $this->addDataout(array('a'=>1));
                if($this->datain){
            $result=  array_merge($this->dataout,  $this->datain);
        $this->dataout=  $result;}
       
    }
    /**
     * suma paràmetres
     */
    public function suma(){
       // $arreglo_var=  array_keys($this->dataout);
        $arreglo_val= array_values($this->dataout);
        
        $this->dataout=array('suma'=>array_sum($arreglo_val));
    }
    /**
     * Selecciona usuaris
     */
    public function users(){
        $sql="SELEC * FROM USERS";
        $this->prepara($sql);
        $this->exec($array);
        
    }
    
}
