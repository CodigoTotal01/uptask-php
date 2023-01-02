<?php 
//OPBtiene la pagina en la que se esta llamando 
//Declaración básica de tipo de devolución
function  obtenerPaginaActual(): String{
    //nombre archivo, server entre a los archivos y tre el name con basename -> Devuelve el último componente de nombre de una ruta
   //pasamos archivo actual
    $archivo = basename($_SERVER["PHP_SELF"]);
    //Remplaar una cadena de caracteres en un string con replace 
    $pagina = str_replace(".php", "", $archivo);
    
    return $pagina;
}
obtenerPaginaActual();

/*consultas */

//obtener proyectos, buena forma apara no hacer todo con ajac ya que se añade automaticamete y la lectura no se rvolvera hacer hasta acutalziar la pagina fada el efecto que todo se esta ejecutando en este momento 
function obtenerProyetos(){
include "conexion.php";
try {
    return $conn->query("SELECT id, nombre FROM proyectos"); //para realizar ocnsultas 
} catch (Exception $e) {
  echo "ERROR! -> ". $e->getMessage();
  return false;
}
}



//Obtener el nombr edel proyecto, parametros con valres por default para que no tengamos problemas por el caso en que no se lo pase y no traiga ninguna coneccion 

function obtenerNombreProyecto ($id = null){
  include "conexion.php";
  try {
      return $conn->query("SELECT  nombre FROM proyectos WHERE id={$id}"); //para realizar ocnsultas, simpre cuando se pasa valores por el parametro se pone entre llaves 
  } catch (Exception $e) {
    return false;
  }
}



//Obetener las clases del proyecto 
function obtenerTareasProyecto ($id = null){
  include "conexion.php";
  try {
      return $conn->query("SELECT id, nombre, estado FROM tareas WHERE id_proyecto={$id}"); //para realizar ocnsultas, simpre cuando se pasa valores por el parametro se pone entre llaves 
  } catch (Exception $e) {
    return false;
  }
}

 