<script src="js/sweetalert2.all.min.js"></script>
<?php 
//retorna el nombre del cdocuemnto
$actual = obtenerPaginaActual();
//*operator triple equals too

if($actual === "crear-cuenta" || $actual === "login"){
    //ponemos la funcion escribiendo 
echo  '<script src="js/formulario.js"></script>';
}else{
    //En el index, es decir para personas logueadas 
    echo "<script src=js/scripts.js></script>";
}
?>





</body>

</html>