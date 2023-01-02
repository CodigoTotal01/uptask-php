<?php
//recuerda que nos entan enviardo tanto el nombre de un proyecto y la accion
if(isset($_POST["accion"])){
$accion = $_POST["accion"];
}
if(isset($_POST["id_proyecto"])){
    $id_proyecto = (int) $_POST["id_proyecto"];
}
if(isset($_POST["tarea"])){
    $tarea = $_POST["tarea"];
}

if(isset($_POST["estado"])){
   $estado= (int) $_POST["estado"];
}

if(isset($_POST["id"])){
    $id_tarea= $_POST["id"];
 }

if ($accion === "crear") {
 
    include "../funciones/conexion.php";

    try {
        //* desde la base cada estado tendra el valor por default de 0 

        $stmt  = $conn->prepare("INSERT INTO tareas (nombre, id_proyecto) VALUES (?, ?)");
        //aqui recien ponemso el valor en los place holder
        $stmt->bind_param("si", $tarea, $id_proyecto);
        //ejecutando la consulta 
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $respuesta = array(
                "respuesta" =>  "correcto",
                "id_insertado" => $stmt->insert_id,
                "tipo" => $accion,
                "tarea" => $tarea
            );
        } else {
            $respuesta = array(

                "respuesta" =>  "error",
            );
        }
    } catch (\Throwable $th) {
        // Tomar laexepcion 
        $respuesta = array(
            "pass" => $th->getMessage()
        );
    }

    $stmt->close();
    $conn->close();


    echo (json_encode($respuesta));

}
//! la acciion ki estanis keyendo desde arriba 

if($accion === "actualizar"){
 
    include "../funciones/conexion.php";

    try {
      
            //SIN EL WHERE YA SABNERLACA GAMOS 
        $stmt  = $conn->prepare("UPDATE tareas SET estado = ? WHERE id = ?");
     
        $stmt->bind_param("ii", $estado, $id_tarea);
       
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $respuesta = array(
                "respuesta" =>  "Estado modificado",
            );
        } else {
            $respuesta = array(
                "respuesta" =>  "error",
            );
        }
    } catch (\Throwable $th) {
        // Tomar laexepcion 
        $respuesta = array(
            "pass" => $th->getMessage()
        );
    }

    $stmt->close();
    $conn->close();


    echo (json_encode($respuesta));
}


if($accion === "eliminar"){
 
    include "../funciones/conexion.php";

    try {
      
        
        $stmt  = $conn->prepare("DELETE FROM tareas WHERE id = ?");
     
        $stmt->bind_param("i", $id_tarea);
       
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $respuesta = array(
                "respuesta" =>  "Eliminar",
            );
        } else {
            $respuesta = array(
                "respuesta" =>  "error",
            );
        }
    } catch (\Throwable $th) {
        // Tomar laexepcion 
        $respuesta = array(
            "pass" => $th->getMessage()
        );
    }

    $stmt->close();
    $conn->close();


    echo (json_encode($respuesta));
}




