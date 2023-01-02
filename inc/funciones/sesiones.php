<?php
//Funciones que nos diran si se an logueado correctamente (porque se pueden emter deferente  isin necesidad de loguearse )
function usuario_autenticado(){
    if(!revisar_usuario()){
        //redireccionamos si no se a logueado
        header("Location:login.php");
        exit();
    }
}

//Simple, le enviamos esta gfuncon y reitbara un valor eso dira que exste esta barible pero si retornal null supongoal obtneerlo la funcion de arriba mandada a allmar y se da cuenta que no existe cagaste te redirecciona
function revisar_usuario(){
return isset($_SESSION["nombre"]); // retorna el valor -> null si no existe 
}

session_start(); //! asi se inicia una sesion (sin necesidad de iniciar a gada rato )
usuario_autenticado();
// formas de rediriguirse, no seas weubon no uses url, cookies no se recomienda aunque se guarde en la pc, y el mas usado es Sesion y esta se almacena en el servidor 
