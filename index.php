<?php
//!Nunca debe haber html cuando se refireciona va arriba de todo 
//? para que nadie entre 
include "inc/funciones/sesiones.php";
require "inc/funciones/funciones.php";
require "inc/funciones/conexion.php";
include "inc/templates/header.php";
include "inc/templates/barrra.php";
//? obtener id del url este esta disponible en algnos momentos y en algunos no

$id_proyecto = "";
if (isset($_GET["id_proyecto"])) {
    $id_proyecto = $_GET["id_proyecto"];
}
?>

<body>
    <div class="contenedor">
        <?php
        include "inc/templates/sidebar.php";
        ?>

        <main class="contenido-principal">

            <?php $proyecto = obtenerNombreProyecto($id_proyecto);
            //recuerda que si no jhay o metemos valores vacios tendremsos problemas meter condicionales 
            if ($proyecto) : ?>
                <h1>
                    <?php foreach ($proyecto as $nombre) : ?>
                        <span><?php echo $nombre["nombre"] ?></span>
                    <?php endforeach; ?>

                </h1>


                <form action="#" class="agregar-tarea">
                    <div class="campo">
                        <label for="tarea">Tarea:</label>
                        <input type="text" placeholder="Nombre Tarea" class="nombre-tarea">
                    </div>
                    <div class="campo enviar">
                        <input type="hidden" id="id_proyecto" value="<?php echo $id_proyecto ?>">
                        <input type="submit" class="boton nueva-tarea" value="Agregar">
                    </div>
                </form>

            <?php

            else :
                //si no hay proyectos 
                echo "<p>Selecciona un proyecto :D</p>";

            endif;

            ?>



            <h2>Listado de tareas:</h2>

            <div class="listado-pendientes">
                <ul>
                    <?php
                    //obtener la tereas dle poroeycto actual 

                    $tareas = obtenerTareasProyecto($id_proyecto);
                    //! Tareas de momento contiene todo el conteneido de la conulta del selec, pero veremos recien estos resultados cuando iteremos con un for each sus valores, arreglos asociativos 
                    //num rows reporta el numero de registros que contiene la consulta 
                    if ($tareas->num_rows > 0) {
                        //hay tareas 
                        foreach ($tareas as $tarea) : ?>
                            <li id="tarea:<?php echo $tarea['id'] ?>" class="tarea">
                                <p><?php echo $tarea['nombre'] ?></p>
                                <div class="acciones">
                                    <i class="far fa-check-circle <?php echo $tarea['estado'] === "1" ? 'completo' : ''; ?>"></i>
                                    <i class="fas fa-trash"></i>
                                </div>
                            </li>
                    <?php endforeach;
                    } else {

                        //no hay tareas en este proyecto, este aparecesa simpre y cuando no halla recorrido sobre nada y cuando se añada un nuevo elemento estoq uqeire decir que ta no esta solo por eso se somara la classe de este para eliminaro en scrip 
                        echo "<p class='lista-vacia'>No hay tareas en este proyecto  </p>";
                    }
                    ?>
                </ul>
            </div>

            <div class="avance">
                <h2>Avance del Proyecto</h2>
                <div id="barra-avance" class="barra-avance">
                    <div id="porcentaje" class="porcentaje"> </div>
                </div>
            </div>
        </main>
    </div>
    <!--.contenedor-->


    <?php

    include "inc/templates/footer.php";
    ?>