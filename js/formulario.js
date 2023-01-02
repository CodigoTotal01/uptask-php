eventListeners();
function eventListeners() {
    document.querySelector("#formulario").addEventListener("submit", validarRegistro);

}

function validarRegistro(e) {
    e.preventDefault();
    let usuario = document.querySelector("#usuario").value,
        password = document.querySelector("#password").value,
        tipo = document.querySelector("#tipo").value; //*crear 


    //validacion de espacios vacios  -> alerta bonita de suit alert -> ya lo tenmos el codigopor si te precintas 
    if (usuario == "" || password == "") {
        //validacion fallida
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Debes rellenar los campos!',

        })
    } else {
        //permite comunicar al lenguaje de java con el de php con AJAX
        //?formData, nos permite extructurar neustro llamado a ajax 

        //! DATOS QUE SE ENVIAN AL SERVIDOR 
        let datos = new FormData();
        //?agregar datos (llave y valor)
        datos.append("usuario", usuario);
        datos.append("password", password);
        datos.append("accion", tipo);
        //?Metodo para acceder a el valor de los datos atraves de la llave
        //console.log(datos.get("usuario"));
        //? 1 llamado ajax
        let xhr = new XMLHttpRequest();
        // 2 abrir coneccion tipo, a que archivo lo envio
        xhr.open("POST", "inc/modelos/modelo-admin.php", true); //? true lo hace asinrono
        //3 retorno de datos
        xhr.onload = function () {
            if (this.status === 200) {
                let respuesta = JSON.parse(xhr.responseText); //? respuesta retornada atraves del servidor del modelo admin 
               console.log(respuesta);
                //* si la respuesta es correcta
                if (respuesta.respuesta === "correcto") {
                    // Si es neuvo usuario
                    if (respuesta.tipo === "crear") {
                        swal({
                        title: "Usuario Creado", 
                        text: `${usuario} gracias por tu preferencia`,
                        type: "success"
                    });
                    } else if (respuesta.tipo=== "login"){
                        swal({
                            title: "Login Correcto", 
                            text: `Hola ${usuario} ¿Listo para otro día productivo? 🖖`,
                            type: "success"
                        }).then(resultado => {
                            //*Pomiises, arrow function, en este caso retorna true 
                    if(resultado.value){
                        window.location.href='index.php';
                    }
                });
                    }
                } else {
                    swal({
                        title: "Hubo un error", 
                        text: `No se pudo crear una nueva cuenta`,
                        type: "error"
                    });
                }
            }

            //4 enviar la peticion con el dato
        }
        xhr.send(datos);  //se enviara mediante tipo post 

    }
}

/*
Swal.fire(
        'Good job!',
        'Te has registrado correctamente 🥳!',
        'success',
      )

*/;