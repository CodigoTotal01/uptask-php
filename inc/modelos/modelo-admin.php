<?php
//? permite converit un arrerglo a json, formato de transporte entre medio se comunican good 
//! cuando se usa prepare statement no se necesita limpiar las entradas 

$accion = $_POST["accion"];
$usuario = $_POST["usuario"];
$password = $_POST["password"];

if ($accion === "crear") {
    //? codigo para crear administradotes 

    //! hashear Password
    $opciones = array(
        //mayor el costo mas seguridad pero pobre servidor
        "cost" => 12
    );


    $hash_password = password_hash($password, PASSWORD_BCRYPT, $opciones);

    //?importar cneeccion con la base de datos 
    include "../funciones/conexion.php";

    try {
        //realizar la ocnsulta con la base de datos 

        //?prepare statemne previene inyecciones 
        $stmt  = $conn->prepare("INSERT INTO usuarios (usuario, password) VALUES (?,?)");
        //aqui recien ponemso el valor en los place holder
        $stmt->bind_param("ss", $usuario, $hash_password);
        //ejecutando la consulta 
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            //validar si se a modificado la tabla de neustra base de datos 
            //!Respuesta personalizada
            $respuesta = array(
                //!-1 error , erroor_list, 1 es good  -->  $stmt->affected_rows  
                "respuesta" =>  "correcto",
                //*Devuelve el id autogenerado que se utilizó en la última consulta
                "id_insertado" => $stmt->insert_id,
                "tipo" => $accion
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

    //cerar el statemen
    $stmt->close();
    //cerrar la coneeccion 
    $conn->close();

    //* Mostrando respuesta del hasheo 


    echo (json_encode($respuesta)); //! die es como echo xd , texto plano es muy malo 
}

if ($accion === "login") {
    //? codigo paraloguear administradotes 
       //?importar cneeccion con la base de datos 
       include "../funciones/conexion.php";

       try {
//selecionar el administrador de la base de datos 
$stmt= $conn->prepare("SELECT usuario, id, password FROM usuarios WHERE usuario= ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
   
//* Logear al usuario
//bind_result, nos retorna nuestros valores que obtengamos de ala consulta (nos da el RESULTADO DE LA CONSULTA )
$stmt->bind_result($nombre_usuario, $id_usuario, $pass_usuario); //* le asigana el resultado a las variables 
// Recupera una fila de resultados 
$stmt->fetch();


//!no afectrtd roe ya que solo estamos seleccionando 
if($nombre_usuario){
    if(password_verify($password, $pass_usuario)){
        //! El hash no se peude psasr a texto palano ap ara ello tiene una funcion especial 


        //?inicaiar la secion, arranca en cero, es decir no tiene informacion

        session_start();
        $_SESSION["nombre"] = $usuario;
        $_SESSION["id"] = $id_usuario;
        $_SESSION["login"] = true;
        // todo: si es correcto good 
        $respuesta = array(
            "nombre" =>$nombre_usuario,
            "respuesta" =>"correcto",
            //*Me cague
            "tipo" => $accion

        
        );
    }else{
        $respuesta = array(
            "respuesta" => "Paswprd Icorrecto 🔎"
        );
    }
   
   

   
}else{
    $respuesta = array(
        "error" => "Usurio no encontrado 🔎"
    );
}

//cerar el statemen
    $stmt->close();
    //cerrar la coneeccion 
    $conn->close();

   

    } catch (\Throwable $th) {
        // Tomar laexepcion 
        $respuesta = array(
            "pass" => $th->getMessage()
        );
    }

    echo (json_encode($respuesta)); 

}
