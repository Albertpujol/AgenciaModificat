<?php

class Session
{
    public static function init()
    {
        session_start();
    }
    
    public static function destroy($key = false)
    {
        if($key){
            if(is_array($key)){
                for($i = 0; $i < count($key); $i++){
                    if(isset($_SESSION[$key[$i]])){
                        unset($_SESSION[$key[$i]]);
                    }
                }
            }
            else{
                if(isset($_SESSION[$key])){
                    unset($_SESSION[$key]);
                }
            }
        }
        else{
            session_destroy();
        }
    }
    
    public static function set($clave, $valor)
    {
        if(!empty($clave)){
        $_SESSION[$clave] = $valor;}
    }
    
    public static function get($clave)
    {
        if(isset($_SESSION[$clave])){
        return $_SESSION[$clave];}
    }
}