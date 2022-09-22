/* SCRIPT BACKEND */

//Formularios
/* cambiarContenedor('sect4','sect1'); */
//-- Form Section 1
$("#formDatosPer").submit(function(e){
    const nombres = $("#nombreClie").val(),
          correo= $("#correoClie").val(),
          telefono= $("#telefonoClie").val(),
          ciudad= $("#ciudadClie").val(),
          estado= $("#estadoClie").val(),
          direccion= $("#direccionClie").val()
    
    var datosCliente = {nombres,correo,telefono,ciudad,estado,direccion}
    
    $.ajax({
        url: './ajax/peticiones.php',
        type: 'POST',
        data: {peticion: "guardar-Cliente",datosCliente},
        success: function(resp){
            if (resp == true) {
                cambiarContenedor("sect2","sect1");
            }else{
                console.log("No se ha podido guardar exitosamente !!");
                console.log(resp);
            }
        }
    })
    
    e.preventDefault()
})

//-- Form Section 2
$("#formMedidasInicial").submit(function(e){
    const medidaA = $("#medidaA").val(),
          medidaB = $("#medidaB").val()

    var datosMedidas = {medidaA,medidaB}

    $.ajax({
        url: './ajax/peticiones.php',
        type: 'POST',
        data: {peticion: "guardar-Medidas",datosMedidas},
        success: function(resp){
            if (resp == true) {
                cambiarContenedor("sect3","sect2");
            }else{
                console.log("No se ha podido guardar exitosamente !!");
                console.log(resp);
            }
        }
    })

    e.preventDefault()
})

//Eventos de Elementos

$("#elementoSelect").on('change',function(){
    const valorSeleccionado = $("#elementoSelect").val();
    if (valorSeleccionado!= "select") {
        $.ajax({
            url: './ajax/peticiones.php',
            type: 'POST',
            data: {peticion: "consultar-Objetos-Tipo",objeto : valorSeleccionado},
            success: function(resp){
                try {
                    const modelos = JSON.parse(resp);
                    asignarClasesDeActivacion("active","modeloElemento");

                    if (modelos.length<=3) {
                        var template = ``;
                        var n = 1;

                        modelos.forEach(element => {
                            template+= `
                                <div class="col crd${n}">
                                    <div class="card" style="width: 15rem;">
                                        <img src="${element.img}" class="card-img-top" height="180px">
                                        <div class="card-body">
                                        <h5 class="card-title">Modelo ${n}</h5>
                                        <p class="card-text">Tamaño de ${element.medidas} pulgadas</p>
                                        <div class="text-center">
                                            <input type="radio" class="btn-check" name="options-outlined" id="modelo${n}" autocomplete="off" value="${element.codObjeto}">
                                            <label class="btn btn-outline-primary" for="modelo${n}">Seleccionado</label>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            n++;
                        });

                        $("#modelos").html(template);
                    }
                } catch (error) {
                    console.log("No ha cargado ningun modelo !");
                    console.log(resp);
                    console.log(error);
                }
            }
        })
    }else{
        asignarClasesDeActivacion("hidden","modeloElemento");
    }
})

function mostrarListaElementos() {
    var estado = document.getElementById("mostrarList").innerHTML;
    if (estado == "Mostrar Listado") {
        document.getElementById("mostrarList").innerHTML = "Ocultar Listado";

        actualizarListado();

        asignarClasesDeActivacion("active","listObjetos");
    }else if(estado == "Ocultar Listado"){
        document.getElementById("mostrarList").innerHTML = "Mostrar Listado";

        asignarClasesDeActivacion("hidden","listObjetos");
    }
}

$("#agregarObjeto").on('click',function(){
    var value = $("input[type=radio][name=options-outlined]:checked").val()
    var valorAgregar = $("#paredObjetos").html()
    if (value) {
        $.ajax({
            url: './ajax/peticiones.php',
            type: 'POST',
            data: {peticion: "guardar-Objetos",codObjeto: value, paredObjeto: valorAgregar},
            success: function(resp){
                if (resp == true) {
                    actualizarCajaDesplegable()
                    asignarClasesDeActivacion("hidden","modeloElemento");
                    actualizarListado();
                }else{
                    Swal.fire(
                        'ALERTA',
                        'no puedes agregar mas de 3 objetos a la pared A',
                        'warning'
                    )
                }
            }
        })
    }
    else {
        console.log("Nothing is selected")
    }
})

$("#siguienteElementos").on('click', function(){
    var pared = $("#paredObjetos").html()

    if (pared=="A") {
        $("#paredObjetos").html("B")
        actualizarCajaDesplegable()
        actualizarListado()
        asignarClasesDeActivacion("hidden","modeloElemento");
        $("#siguienteElementos").html(`Finalizar <i class="bi bi-arrow-bar-right"></i>`)
    }else if(pared == "B"){
        cambiarContenedor('sect4','sect3');
        detallesCotizacion()
        guardarInformacion()
    }
})

$("#anteriorElementos").on('click', function(){
    var pared = $("#paredObjetos").html()
    if (pared=="B") {
        $("#paredObjetos").html("A")
        actualizarCajaDesplegable()
        actualizarListado()
        asignarClasesDeActivacion("hidden","modeloElemento");
        $("#siguienteElementos").html(`Siguiente <i class="bi bi-arrow-bar-right"></i>`)

    }else if(pared=="A"){
        cambiarContenedor('sect2','sect3');
    }
})


$("#btncostos").on('click',function(){
    cambiarContenedor("cont-costos","cont-detalles");
    cambiarContenedor("btncostos","btndetalles");
})

$("#btndetalles").on('click',function(){
    cambiarContenedor("btndetalles","btncostos");
    cambiarContenedor("cont-detalles","cont-costos");
    consultarDetallesCotizacion()
})

$("#resetApp").on('click',function(){
    $.ajax({
        url: './ajax/peticiones.php',
        type: 'POST',
        data: {peticion: "destructor-Sesiones"},
        success: function(resp){}
    })
    window.location.reload();
})


//Funciones

function cambiarContenedor(contenedorIr,contenedorActual) {
    document.querySelector("#"+contenedorActual).classList.remove("active")
    document.querySelector("#"+contenedorActual).classList.remove("hidden")
    
    document.querySelector("#"+contenedorActual).classList.add("hidden")
    document.querySelector("#"+contenedorIr).classList.add("active")
}

function asignarClasesDeActivacion(clase,elemento) {
    
    var claseRemover = clase == "active" ? "hidden" : "active" ;

    document.querySelector("#"+elemento).classList.remove(claseRemover)
    document.querySelector("#"+elemento).classList.add(clase)
}

function consultarPeticiones() {
    $.ajax({
        url: './ajax/peticiones.php',
        type: 'POST',
        data: {peticion: "consultar-Sesion"},
        success: function(resp){
            console.log(resp);
        }
    })
}

function actualizarCajaDesplegable(){
    $.ajax({
        url: './ajax/peticiones.php',
        type: 'POST',
        data: {peticion: "actualizar-Objetos"},
        success: function(resp){
            try {
                const objetos = JSON.parse(resp)
                var objeto = ["nevera","estufa","campana","lavaplatos"];
                var template = `<option value="select" selected>Seleccione Elemento</option>`;

                objeto.forEach(element => {
                    if (!objetos.includes(element)) {
                        template += `<option value="${element}">${element.charAt(0).toUpperCase()+element.slice(1)}</option>`;
                    }
                });

                $("#elementoSelect").html(template)

            } catch (error) {
                console.log("ERROR AL ACTUALIZAR SELECT");
                console.log(resp);
            }
        }
    })
}


function actualizarListado() {
    var pared = $("#paredObjetos").html()
        
        $.ajax({
            url: './ajax/peticiones.php',
            type: 'POST',
            data: {peticion: "consultar-Objetos", pared},
            success: function(resp){
                try {
                    const listado = JSON.parse(resp);
                    var template = ``;

                    listado.forEach(element => {
                        template += `
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                    <div class="fw-bold">${element.tipo}</div>
                                    Medidas de ${element.medidas} pulgadas
                                    </div>
                                    <span class="badge bg-danger rounded-pill mouseHand2" onclick="eliminarElemento('${element.codObjeto}')">Eliminar</span>
                            </li>
                        `;
                    });

                    if (listado.length == 0) {
                        template+=`<li class="list-group-item d-flex justify-content-between align-items-start"><div class="ms-2 me-auto">No tenemos Elementos</di></li>`;
                    }

                    $("#listado").html(template)

                } catch (error) {
                    console.log(resp);
                }
            }
        })
}

function eliminarElemento(codElemento) {
    var valorEliminar = $("#paredObjetos").html()
    $.ajax({
        url: './ajax/peticiones.php',
        type: 'POST',
        data: {peticion: "eliminar-Objeto",codElemento,valorEliminar},
        success: function(resp){
            if (resp == true) {
                actualizarCajaDesplegable();
                actualizarListado();
                asignarClasesDeActivacion("hidden","modeloElemento");
            } else {
                console.log(resp);
            }
        }
    })
}


function calcMedidasRestantes(callback) {
    $.ajax({
        url: './ajax/peticiones.php',
        type: 'POST',
        data: {peticion: "calc-Medidas-Restantes"},
        success: function(resp){
            callback(resp);
        }
    })
}

function calcAreaConstruccion(callback) {
    $.ajax({
        url: './ajax/peticiones.php',
        type: 'POST',
        data: {peticion: "calc-area-construccion"},
        success: function(resp){
            callback(resp);
        }
    })
}

function calcPrecioCotizacion(callback) {
    $.ajax({
        url: './ajax/peticiones.php',
        type: 'POST',
        data: {peticion: "calc-Precio"},
        success: function(resp){
            callback(resp);
        }
    })
}

function detallesCotizacion() {
    calcMedidasRestantes(function(medidasResp){
        try {
            const meds = JSON.parse(medidasResp);
            $("#medparedA").html(meds.medidaA)
            $("#medparedB").html(meds.medidaB)
            calcAreaConstruccion(function(areaResp){
                try {
                    const area = JSON.parse(areaResp)
                    $("#totalArea").html(area)
                    calcPrecioCotizacion(function(precioResp){
                        try {
                            const precio = JSON.parse(precioResp)
                            $("#totalCotiz").html("$ "+precio+",00")
                        } catch (error) {
                            console.log(precioResp);
                        }
                    })
                } catch (error) {
                    console.log(areaResp);   
                }
            })
        } catch (error) {
            console.log(medidasResp);
        }
    })
}

function guardarInformacion() {
    Swal.fire({
        title: 'Desea realizar un cita?',
        text: "Puede realizar un agendamiento para que uno de nuestros asesores se comunique con usted mas adelante!",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Estare atento',
        cancelButtonText: 'No, gracias',
      }).then((result) => {
        var resivirAsesoramiento = false;

        if (result.isConfirmed) {

            const tiempoTranscurrido = Date.now();
            var fechaAgenda = new Date(tiempoTranscurrido);
            fechaAgenda.setDate(fechaAgenda.getDate() + 5);
            resivirAsesoramiento = true
            Swal.fire(
                'EXCELENTE',
                'Su cita ha sido agendada con exito!, lo estaran contactando aproximadamente el  '+fechaAgenda.toUTCString(),
                'success'
            )
    
        }else if (
            result.dismiss === Swal.DismissReason.cancel
        ){
            Swal.fire(
                'EXCELENTE',
                'Muchas gracias por preferirnos',
                'success'
              )
        }


        //Guardar Usuarios

        $.ajax({
            url: './ajax/peticiones.php',
            type: 'POST',
            data: {peticion: "guardar-Usuario"},
            success: function(resp){
                console.log(resp);
            }
        })

        //Guardar Historial Cotizacion

        $.ajax({
            url: './ajax/peticiones.php',
            type: 'POST',
            data: {peticion: "guardar-Cotizacion",resivirAsesoramiento},
            success: function(resp){
                console.log(resp);
            }
        })

    
    })
}

function consultarDetallesCotizacion(){
    $.ajax({
        url: './ajax/peticiones.php',
        type: 'POST',
        data: {peticion: "consultar-detalles-objetos"},
        success: function(respueta){
            try {
                var elementos = JSON.parse(respueta);
                var template = ``;
                
                elementos.forEach(element => {
                    template+= `
                        <tr>
                            <th scope="row">${element.codObjeto}</th>
                            <td>${element.tipo}</td>
                            <td>${element.medidas}"</td>
                            <td>${element.lugar}</td>
                        </tr>
                    `;
                });

                $("#detallesElementos").html(template)

            } catch (error) {
                console.log(resp);
                console.log(error);
            }
        }
    })
}