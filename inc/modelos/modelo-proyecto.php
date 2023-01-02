<?php 
$accion = $_POST["accion"];
$proyecto = $_POST["proyecto"];

if ($accion === "crear") {
 
    include "../funciones/conexion.php";

    try {
        $stmt  = $conn->prepare("INSERT INTO proyectos (nombre) VALUES (?)");
        //aqui recien ponemso el valor en los place holder
        $stmt->bind_param("s", $proyecto);
        //ejecutando la consulta 
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $respuesta = array(
                "respuesta" =>  "correcto",
                "id_insertado" => $stmt->insert_id,
                "tipo" => $accion,
                "nombre_proyecto" => $proyecto
            );
        } else {
            $respuesta = array(

                "respuesta" =>  "er",
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
