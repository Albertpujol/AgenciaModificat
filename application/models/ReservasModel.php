<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class ReservasModel extends Model{
    
    
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
            * Funcio que s'utilitzarà per obtenir el id del usuari, el qual el email sigui igual que el que es passa per parametres
            * 
            * @param string $consulta: conté la sentencia que volem executar per obtenir la informació del id
            * @param string $consulta_sql:Conté el prepare de la consulta en el qual s'especifica la base de dades
            * amb el bindParam podem afegir el parametre (?) de la consulta que es una variable que en aquest cas es pasa
            * per parametres a la funció i l'executem
            * @param string $res: Es recorre la sentencia
            * @param string @filas: Mirem si la sentencia se selecció retorna algún registre i si es igual a 1 retorna el resultat de la mateixa
            * i quina serà la vista que mostrara la informació
            */
    
       function seleccionar_iduser($usuari){
       
       try{
           
           $consulta= "SELECT id FROM usuaris WHERE email=?;";
           $consulta_sql = $this->db->prepare($consulta);
           $consulta_sql->bindParam(1,$usuari);
           $consulta_sql->execute();
           $res = $consulta_sql->fetchAll(PDO::FETCH_ASSOC);
         
           $Filas= $consulta_sql->RowCount();
       
            if($Filas == 1)
            {
               return $res;
            }
       } catch (Exception $ex) {

       }
       
   }
   
            /** 
            * Funcio que s'utilitzarà per comprobar si un usuari ha fet alguna reserva
            * 
            * @param string $consulta: conté la sentencia que volem executar per obtenir la informació del id
            * @param string $consulta_sql:Conté el prepare de la consulta en el qual s'especifica la base de dades
            * amb el bindParam podem afegir el parametre (?) de la consulta que es una variable que en aquest cas es pasa
            * per parametres a la funció i l'executem
            * @param string $res: Es recorre la sentencia
            * @param string @filas: Mirem si la sentencia se selecció retorna algún registre i si es igual a 1 retorna el resultat de la mateixa
            * i quina serà la vista que mostrara la informació
            * @param string $consulta2: Sentencia per comprobar que un usuari no tingui reserves pendents, seleccionara el id de la reserva si no esta pendent
            */
          function seleccionar_reservas($id_usuari){
       
       try{
           
           $consulta= "SELECT id FROM reserves WHERE idusuari=?;";//sentencia per comprobar si el usuari no ha fet alguna reserva
           $consulta_sql = $this->db->prepare($consulta);
           $consulta_sql->bindParam(1,$id_usuari);
           $consulta_sql->execute();
           $res = $consulta_sql->fetchAll(PDO::FETCH_ASSOC);
         
           $Filas= $consulta_sql->RowCount();
           
           
           $consulta2= "SELECT id FROM reserves WHERE idusuari=? AND status!='pendent';";//sentencia per comprobar que si el usuari ha fet alguna reserva no estigui pendent de pagar
           $consulta_sql2 = $this->db->prepare($consulta2);
           $consulta_sql2->bindParam(1,$id_usuari);
           $consulta_sql2->execute();
           $res2 = $consulta_sql2->fetchAll(PDO::FETCH_ASSOC);
           
           $Filas2 = $consulta_sql2->RowCount();
                   
            if($Filas == 0 || $Filas2 == 1)
            {
               return true;
            }else{
               return false;
            }
       } catch (Exception $ex) {

       }
       
   }
   
            /** 
            * Funcio que s'utilitzarà per comprobar si un usuari ha fet alguna reserva
            * 
            * @param string $consulta: conté la sentencia que volem executar per obtenir la informació del id
            * @param string $consulta_sql:Conté el prepare de la consulta en el qual s'especifica la base de dades
            * amb el bindParam podem afegir el parametre (?) de la consulta que es una variable que en aquest cas es pasa
            * per parametres a la funció i l'executem
            * @param string $res: Es recorre la sentencia
            * @param string @filas: Mirem si la sentencia se selecció retorna algún registre i si es igual a 1 retorna el resultat de la mateixa
            * i quina serà la vista que mostrara la informació
            * @param string $consulta2: Sentencia per comprobar que un usuari no tingui reserves pendents, seleccionara el id de la reserva si no esta pendent
            */
      public function fer_reserva($id_usuari,$id_servei,$preu_final){
          
          try{//fem aquesta consulta per obtenir el preu del servei en questio
           
           $consulta1= "SELECT preu FROM serveis WHERE id=?;";//sentencia per comprobar si el usuari no ha fet alguna reserva
           $consulta_sql1 = $this->db->prepare($consulta1);
           $consulta_sql1->bindParam(1,$id_servei);
           $consulta_sql1->execute();
           $res1 = $consulta_sql1->fetchAll(PDO::FETCH_ASSOC);
          } catch (Exception $ex) {

       } 
            
       try{//fem la inserció de la consulta
           $data_avui = date("Y-m-d H:i:s");
           $status = "pendent";
           $consulta= "INSERT INTO reserves (data,idusuari,status,preu) VALUES (?,?,?,?);";
           $consulta_sql = $this->db->prepare($consulta);
           $consulta_sql->bindParam(1,$data_avui);
           $consulta_sql->bindParam(2,$id_usuari);
           $consulta_sql->bindParam(3,$status);
           $consulta_sql->bindParam(4,$preu_final);
           $consulta_sql->execute();
           $consulta_sql->fetch(PDO::FETCH_ASSOC);
 
       } catch (Exception $ex) {

       }
   }
   
   public function serveis_reservats($id_servei,$id_usuari,$places,$preu_final){
       
           try{//fem aquesta consulta per obtenir el preu del servei en questio
           
           $consulta1= "SELECT id FROM reserves WHERE idusuari=?;";//sentencia per comprobar si el usuari no ha fet alguna reserva
           $consulta_sql1 = $this->db->prepare($consulta1);
           $consulta_sql1->bindParam(1,$id_usuari);
           $consulta_sql1->execute();
           $res1 = $consulta_sql1->fetchAll(PDO::FETCH_ASSOC);
          } catch (Exception $ex) {

       } 
       $html="";
        foreach ($res1 as $campo){//obtenim el id del usuari
        $html = $html.$campo['id'];   
        }
        $id_reserva = $html;
        
             /** 
            * A continuació a aquest try probarem la inserció de un servei reservat amb tots els seus parametres
            * 
            * @param string $data_avui: conté una funció de php per calcular el dia en el que estem avui 
            * @param string $consulta: conté la consulta del insert que volem realitzar
            * @param string $consulta_sql:Conté el prepare de la consulta en el qual s'especifica la base de dades
            * amb el bindParam podem afegir els diversos parametres (?) del insert en forma de variables que es passen
            * per parametres a la funció i l'executem
            */
       try{//fem la inserció de la consulta
           $data_avui = date("Y-m-d H:i:s");
           
           
           $consulta= "INSERT INTO serveis_reservats (idservei,idreserva,dataRes,places,preu_servei) VALUES (?,?,?,?,?);";
           $consulta_sql = $this->db->prepare($consulta);
           $consulta_sql->bindParam(1,$id_servei);
           $consulta_sql->bindParam(2,$id_reserva);
           $consulta_sql->bindParam(3,$data_avui);
           $consulta_sql->bindParam(4,$places);
           $consulta_sql->bindParam(5,$preu_final);
           $consulta_sql->execute();
           $consulta_sql->fetch(PDO::FETCH_ASSOC);
 
       } catch (Exception $ex) {

       }
   }
   
   public function calcular_preu($id_servei){
           try{//fem aquesta consulta per obtenir el preu del servei en questio
           
           $consulta1= "SELECT preu FROM serveis WHERE id=?;";//sentencia per comprobar si el usuari no ha fet alguna reserva
           $consulta_sql1 = $this->db->prepare($consulta1);
           $consulta_sql1->bindParam(1,$id_servei);
           $consulta_sql1->execute();
           $res1 = $consulta_sql1->fetchAll(PDO::FETCH_ASSOC);
           $Filas2 = $consulta_sql1->RowCount();
           if($Filas2 == 1)
            {
               return $res1;
               return true;
            }else{
               return false;
            }
          } catch (Exception $ex) {

       } 
   }
   
   public function seleccionar_status($id_usuari){
           try{//fem aquesta consulta per obtenir el preu del servei en questio
           
           $consulta1= "SELECT status,id FROM reserves WHERE idusuari=?;";//sentencia per comprobar si el usuari no ha fet alguna reserva
           $consulta_sql1 = $this->db->prepare($consulta1);
           $consulta_sql1->bindParam(1,$id_usuari);
           $consulta_sql1->execute();
           $res1 = $consulta_sql1->fetchAll(PDO::FETCH_ASSOC);
           $Filas= $consulta_sql1->RowCount();
       
            if($Filas == 1)
            {
               return $res1;
            }else{
                print_r("No tens cap reserva cursada");
            }
          } catch (Exception $ex) {

       } 
   }
   
   
   public function seleccionar_serveisres($id_servei){
           
           try{//fem aquesta consulta per obtenir el preu del servei en questio
           
           $consulta1= "SELECT * FROM serveis_reservats WHERE idreserva=?;";//sentencia per comprobar si el usuari no ha fet alguna reserva
           $consulta_sql1 = $this->db->prepare($consulta1);
           $consulta_sql1->bindParam(1,$id_servei);
           $consulta_sql1->execute();
           $res1 = $consulta_sql1->fetchAll(PDO::FETCH_ASSOC);
           $Filas= $consulta_sql1->RowCount();
       
            if($Filas == 1)
            {
               return $res1;
            }
          } catch (Exception $ex) {

       } 
       
   }
   
   public function seleccionar_dades($id_reserva){
       
           try{//fem aquesta consulta per obtenir el preu del servei en questio
           
           $consulta1= "SELECT preu_servei FROM serveis_reservats WHERE idreserva=?;";//sentencia per comprobar si el usuari no ha fet alguna reserva
           $consulta_sql1 = $this->db->prepare($consulta1);
           $consulta_sql1->bindParam(1,$id_reserva);
           $consulta_sql1->execute();
           $res1 = $consulta_sql1->fetchAll(PDO::FETCH_ASSOC);
           $Filas= $consulta_sql1->RowCount();
       
            if($Filas == 1)
            {
               return true;
               
            }else{
                print_r("no s'ha pugut fer el pagament correctament");
            }
          } catch (Exception $ex) {

       } 
       
   }
   
   public function insert_pagar($id_reserva,$metode,$preu){
           
           try{//fem la inserció de la consulta
           $data_avui = date("Y-m-d H:i:s");
           

           $consulta= "INSERT INTO pagaments (idreserva,pagament_quant,pagament_data,tipus) VALUES (?,?,?,?);";
           $consulta_sql = $this->db->prepare($consulta);
           $consulta_sql->bindParam(1,$id_reserva);
           $consulta_sql->bindParam(2,$preu);
           $consulta_sql->bindParam(3,$data_avui);
           $consulta_sql->bindParam(4,$metode);
           $consulta_sql->execute();
           $Filas= $consulta_sql->RowCount();
           
           if($Filas == 1)
           {
               return true;
           }else{
               return false;
           }

 
       } catch (Exception $ex) {

       }
   }
   
   public function pagar_reserva($id_reserva){
       try{//fem aquesta consulta per obtenir el preu del servei en questio
           
           $consulta1= "UPDATE reserves SET status='abonat' WHERE id=?;";//sentencia per comprobar si el usuari no ha fet alguna reserva
           $consulta_sql1 = $this->db->prepare($consulta1);
           $consulta_sql1->bindParam(1,$id_reserva);
           $consulta_sql1->execute();
           $res1 = $consulta_sql1->fetchAll(PDO::FETCH_ASSOC);
           $Filas= $consulta_sql1->RowCount();
       
            if($Filas == 1)
            {
               return true;
            }else{
               return false;
            }
          } catch (Exception $ex) {

       } 
       }
    
       
}