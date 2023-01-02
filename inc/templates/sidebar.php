<aside class="contenedor-proyectos">
    <!-- boton nuevo AÑADIR proyecto -->
    <div class="panel crear-proyecto">
        <a href="#" class="boton">Nuevo Proyecto <i class="fas fa-plus"></i> </a>
    </div>
    <!-- CONTENIDO DE LOS PROYECTOS  -->
    <div class="panel lista-proyectos">
        <h2>Proyectos</h2>
        <ul id="proyectos">
            <?php
            //ya no necesitamso ingportar nada 

            //! LITERAL ASI DE FAIL SE OBTIENE EL CONTENIDO DE MANERA SENCILLA ATRAVES DE UNA CONSULTA CON CONN -> query y retornando el valor por una funcion 
            $proyectos = obtenerProyetos(); // y asi tenemos todas los datos de las columnas de nestra base de datos 

            foreach ($proyectos as $proyecto) {?>
               <li>
               <a href = "index.php?id_proyecto=<?php echo $proyecto["id"]?>" id ="proyecto:<?php echo $proyecto["id"]?>">
          
          <?php    echo $proyecto["nombre"]?>
            </a>
               </li>
            <?php } ?>
          
        </ul>
    </div>
</aside>