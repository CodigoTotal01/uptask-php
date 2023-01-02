eventListener();
const listaProyectos = document.querySelector("ul#proyectos");
function eventListener() {
    //? Cuadno el documento esta cargado 

    document.addEventListener("DOMContentLoaded", function () {
        actualizarProgreso();
    });



    // todo: boton para agregar proyecto
    document.querySelector(".crear-proyecto a ").addEventListener("click", nuevoProyecto);
    //Agregar Tarea boton 
    //!Esto arregla errorcitos que se generan caundo se va generando mas codigo si ves que no una funcion dise que no pudo dar el evento no hay pero 
    if (document.querySelector(".nueva-tarea") !== null) {
        document.querySelector(".nueva-tarea").addEventListener("click", agregarTarea);
    }




    //Botones para las acciones de las tareas con delagation La delegación de eventos consiste en escuchar los eventos en el elemento padre para capturarlo cuando ocurra en sus hijos.
    document.querySelector(".listado-pendientes").addEventListener("click", accionesTareas);
}

function nuevoProyecto(e) {
    e.preventDefault();
    //crea im input para el nombre dle neuvvo proyecto 
    let nuevoProyecto = document.createElement("li");
    nuevoProyecto.innerHTML = "<input type='text' id='nuevo-proyecto'>";
    //? Sleecciona la lu

    listaProyectos.appendChild(nuevoProyecto);



    // seleccionar el id del neuvo proyecto 
    let inputNuevoProyecto = document.querySelector("#nuevo-proyecto");

    //al precionar enter se creara el proyecto 

    inputNuevoProyecto.addEventListener("keypress", function (e) {

        //cada enter insertar, increivble el ehit es 97 y regresa el codiogo de los numeros o el key code 
        let tecla = e.which || e.keyCode;
        if (tecla === 13) {
            guardarProyectoDB(inputNuevoProyecto.value);
            //Quitamos el input al hacer enter
            listaProyectos.removeChild(nuevoProyecto);
        }

    });
}

function guardarProyectoDB(nombreProyecto) {
    //Cautro pasos ajax -> L
    let xhr = new XMLHttpRequest();

    //enviar datos por form data
    let datos = new FormData();
    datos.append("proyecto", nombreProyecto);
    datos.append("accion", "crear");
    //abrir conxion (tipo rquest, url a donde vamos a enviar la consulta  y si el llamado es asincrono)
    xhr.open("POST", "inc/modelos/modelo-proyecto.php");
    //la carga 

    xhr.onload = function () {
        //si encontro siu lugarsito 
        if (this.status === 200) {

            //Leer datos de la respeusta 
            let respuestaCrearProyecto = JSON.parse(xhr.responseText)
            let { respuesta, id_insertado, tipo, nombre_proyecto } = respuestaCrearProyecto;
            //apra saber que todo salio bien basta con ver si las variables ocntiene algo 
            if (respuesta === "correcto") {
                // "me exito"
                //consultado por el valor de crear es decir el tipo
                if (tipo === "crear") {
                    //se creo el neuvo proyecto
                    //!inyeccion en html
                    const nuevoProyecto = document.createElement("li");
                    nuevoProyecto.innerHTML = `
            <a href= "index.php?id_proyecto=${id_insertado}" id ="proyecto:${id_insertado}">
            ${nombre_proyecto}
            </a>
            `;

                    //agregar a la lsita (HTML)
                    listaProyectos.appendChild(nuevoProyecto);

                    //enviar alerta
                    swal({
                        title: "Proyecto Registrado",
                        text: `El ${nombre_proyecto} esta guardado correctamente`,
                        type: "success"
                    }).then(resultado => {
                        //*Pomiises, arrow function, en este caso retorna true 
                        if (resultado.value) {
                            window.location.href = "index.php?id_proyecto" + id_insertado;
                        }
                    });

                    //? REdireccionar a la nueva url , cuando veas que flashea usa los prom


                } else {
                    //se actualizo o elimino un proyecto

                }

            } else {
                //hubo un error
                swal({
                    title: "Hubo un error",
                    text: `Error`,
                    type: "error"
                });
            }
        }

    }

    //enviar el request 
    xhr.send(datos);
}

//Agregar neuva tarea al proyecto actual 
function agregarTarea(e) {
    e.preventDefault();
    //! LAs tareas no pueden enviarsece vacias 
    let nombreTarea = document.querySelector(".nombre-tarea").value;
    if (nombreTarea === "") {
        swal({
            title: "Hubo un error",
            text: `Una tarea no puede ir vacia`,
            type: "error"
        });
    } else {
        //No esta vacio este cambio  -î insertar a php 

        //llamada AJAX
        let xhr = new XMLHttpRequest();

        //LA mayoria de ves para enviar datos a php 
        let datos = new FormData();
        datos.append("tarea", nombreTarea);
        datos.append("accion", "crear");
        datos.append("id_proyecto", document.querySelector("#id_proyecto").value);
        //?recfuerda que tenmos un input invisible que contiene el id 

        //abrir la conecion > donde se indica como se enviaran los datos 
        xhr.open("POST", "inc/modelos/modelo-tareas.php", true);


        //ejecutandco y enviando respuesta 
        xhr.onload = function () {
            //si se a establecido coneccion, se envio los datos y se obtubo respeusta 
            if (this.status === 200) {
                let respuestaTarea = JSON.parse(xhr.responseText);
                const { respuesta, id_insertado, tipo, tarea } = respuestaTarea;

                if (respuesta === "correcto") {
                    //accion correcta 

                    //? evaluando tipo de accion 
                    if (tipo === "crear") {
                        swal({
                            title: "Tarea añadida!",
                            text: `La tarea ${tarea} se añadio correctamente :D`,
                            type: "success"
                        });



                        //!SEleccionar el parrafo con la lista vacia 
                        var parrafoListaVacia = document.querySelectorAll(".lista-vacia");
                        //! Para saber que si un elemento existe o no el qauerySelectorAll nos regresara un leng supongo que dle conteneido si este no lo tiene simplemnte asi se odra saber uque que pedo econ este 
                        if (parrafoListaVacia.length > 0) {
                            document.querySelector(".lista-vacia").remove();
                        }

                        //? Añadir a l template 
                        let nuevaTarea = document.createElement("li");
                        //*argrgando id 
                        nuevaTarea.id = "tarea: " + id_insertado;
                        //clase tarea 
                        nuevaTarea.classList.add("tarea");
                        //*contruir el  html 
                        nuevaTarea.innerHTML = `
                    <p>${tarea}</p>
                    <div class ="acciones">
                    <i class="far fa-check-circle"></i>
                    <i class="fas fa-trash"></i>
                    </div>
                    `;

                        //* Añadiendo el html al index -> es un lu 
                        const listado = document.querySelector(".listado-pendientes ul");
                        listado.appendChild(nuevaTarea);

                        actualizarProgreso();
                        //Limpiar el formulario-> eñ FORMULARIO 
                        document.querySelector(".agregar-tarea").reset();


                        //! Actualizar progreso despues de añadir una tarea 




                    }
                } else {
                    //error inesperado 
                    swal({
                        title: "Hubo un error",
                        text: `Error`,
                        type: "error"
                    });
                }

            }
        }

        //Enviar la consulta 
        xhr.send(datos);
    }



}


//cambia el estado de las tareas  o las elimina 
function accionesTareas(e) { // seleccionando la lu y sus elementos internos esto se conoce mocmo delegation que tiene un contenedor grande dodne se comparra los valores y segun lo que sdeseemos creamos un lisener distion 
    e.preventDefault(); // contancios nos ermite saber si una clase ocntiene algun elemento 
    //? Detectar id del usuario 

    //! 1 esta termionado 0 no lo esta 
    if (e.target.classList.contains("fa-check-circle")) {
        if (e.target.classList.contains("completo")) {
            //si le picamos ua uno que ya tenga la clase 
            e.target.classList.remove("completo");
            //con el target nos retorrnla e i hay que hacerle traversig para llegar a l id 
            cambiarEstadoTarea(e.target, 0);
        } else {
            //si no lo tiene 
            e.target.classList.add("completo");
            cambiarEstadoTarea(e.target, 1);

        }
    }

    if (e.target.classList.contains("fa-trash")) {
        Swal.fire({
            title: '¿Estas Seguro(a)?',
            text: "No habra vuelta atras :0!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, borrar!',
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.value) {

                let tareaEliminar = e.target.parentElement.parentElement;
                //borrar de kla base de datos 
                eliminarTareaBD(tareaEliminar);

                //borrar del html, despues de decirle que eliminar 
                tareaEliminar.remove();

                Swal(
                    'Elimandado!',
                    'La tarea se elimino!',
                    'success'
                )
            }
        })

    }
}


// completa o descompleta una tarea 
function cambiarEstadoTarea(tarea, estado) {
    //split para cortar texto de lo que quremos separrar  y nos entrega un array 
    let idTarea = tarea.parentElement.parentElement.id.split(":");

    //llamado ajaxpara envier el estado 
    let xhr = new XMLHttpRequest();
    //nformacion para enviar por ajax
    let datos = new FormData();
    datos.append("id", idTarea[1]);
    datos.append("accion", "actualizar");
    datos.append("estado", estado); //buenaso para no crear funciones distintas 
    //conexion 
    xhr.open("POST", "inc/modelos/modelo-tareas.php", true);
    //el onload de todoa la vida 

    xhr.onload = function () {
        if (this.status === 200) {

            console.log(xhr.responseText);
            actualizarProgreso();

        }
    }

    //enviar la peticion 
    xhr.send(datos);
}

//Eliminar tarea de la base de datos 
function eliminarTareaBD(tarea) {
    //split para cortar texto de lo que quremos separrar  y nos entrega un array 
    let idTarea = tarea.id.split(":");

    //llamado ajaxpara envier el estado 
    let xhr = new XMLHttpRequest();
    //nformacion para enviar por ajax
    let datos = new FormData();
    datos.append("id", idTarea[1]);
    datos.append("accion", "eliminar");

    //conexion 
    xhr.open("POST", "inc/modelos/modelo-tareas.php", true);
    //el onload de todoa la vida 

    xhr.onload = function () {
        if (this.status === 200) {

            console.log(xhr.responseText);


            //comproibar que halla tareas restante s 
            var listaTareasRestantes = document.querySelectorAll("li.tarea");
            if (listaTareasRestantes.length === 0) {

                document.querySelector(".listado-pendientes ul").innerHTML = "<p class='lista-vacia'>No hay tareas en este proyecto  </p>";
                actualizarProgreso();
            }
        }
    }

    //enviar la peticion 
    xhr.send(datos);
}

//? actualiza el avance del progreso
function actualizarProgreso() {
    const tareas = document.querySelectorAll("li.tarea");
    //obtener la s taress completadas 
    const tareasCompletadas = document.querySelectorAll("i.completo");
    //redondea hacia arrbia en un entero
    const avance = Math.round((tareasCompletadas.length / tareas.length) * 100);
    //? asignar el avance a la barra 
    const procentaje = document.querySelector("#porcentaje");
    procentaje.style.width = avance + "%";

    if(avance === 100){
        swal({
            title: "Proyecto Terminado",
            text: `Bien echo, ve por un cafe :D`,
            type: "success"
        });
    }
}