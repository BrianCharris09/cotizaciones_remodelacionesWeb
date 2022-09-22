<?php 

    session_start();
    session_destroy();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>
<body>
    
    <nav class="navbar bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
            Remodelaciones
          </a>
        </div>
    </nav>

    <div class="contenedores">
        
        <!-- Section 1 -->
        <section class="active" id="sect1">
             
            <div class="mb-4">
                <h1>DATOS PERSONALES</h1>
            </div>
            

            <form action="" id="formDatosPer">

                <div class="mb-4">
                    <label class="form-label text-start" for="nombreClie">Nombre Completo</label>
                    <input class="form-control" type="text" name="" id="nombreClie">
                </div>
                
                <div class="mb-4">
                    <label class="form-label text-start" for="correoClie">Correo Electronico</label>
                    <input class="form-control" type="email" name="" id="correoClie">
                </div>

                <div class="mb-4">
                    <label for="telefonoClie" class="form-label text-start" >Telefono</label>
                    <input class="form-control" type="number" name="" id="telefonoClie">
                </div>
                
                <div class="mb-4">
                    <label for="ciudadClie" class="form-label text-start">Ciudad</label>
                    <input class="form-control" type="text" name="" id="ciudadClie">        
                </div>
        
                <div class="mb-4">
                    <label for="estadoClie" class="form-label text-start">Estado</label>
                    <input type="text" name="" id="estadoClie"class="form-control">
                </div>
                
                <div class="mb-4">
                    <label for="direccionClie" class="form-label text-start">Direccion</label>
                    <input type="text" name="" id="direccionClie" class="form-control">
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-outline-dark">Siguiente <i class="bi bi-arrow-bar-right"></i></button>
                </div>

            </form>

        </section>

        <!-- Fin Section 1 -->

        <!-- Section 2 -->

        <!-- Section 2 -->
        <section class="hidden" id="sect2">
            <div class="mb-4">
                <h1>MEDIDAS DE AREA (COCINA)</h1>
            </div>

            <form action="" id="formMedidasInicial">
                <div class="row g-3 align-items-center mb-4">
                    <label for="medidaA" class="col-form-label">Medida de  pared A</label>
                    <div class="col-auto" style="width: 50%;">
                      <input type="number" id="medidaA" class="form-control">
                    </div>
                    <div class="col-auto">
                      <span class="form-text" style="font-size: 20px;">
                        Pulgadas
                      </span>
                    </div>
                </div>

                <div class="row g-3 align-items-center mb-4">
                    <label for="medidaB" class="col-form-label">Medida de  pared B</label>
                    <div class="col-auto" style="width: 50%;">
                      <input type="number" id="medidaB" class="form-control">
                    </div>
                    <div class="col-auto">
                      <span class="form-text" style="font-size: 20px;">
                        Pulgadas
                      </span>
                    </div>
                </div> 

                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-dark" onclick="cambiarContenedor('sect1','sect2');"><i class="bi bi-arrow-bar-left"></i> Anterior</button>
                    <button type="submit" class="btn btn-outline-dark">Siguiente <i class="bi bi-arrow-bar-right"></i></button>
                </div>
            </form>

        </section>
        <!-- Fin de Section 2 -->

        <!-- Section 3 -->
        <section class="hidden" id="sect3">
            <div class="mb-4">
                <h1>OBJETOS EN LA PARED <b id="paredObjetos">A</b></h1>
            </div>
            
            <form action="">
                
                <div class="mb-4">
                    <label for="" class="form-label text-start">Elemento en su cocina</label>
                    <select class="form-select" aria-label="Default select example" id="elementoSelect">
                        <option value="select" selected>Seleccione Elemento</option>
                        <option value="nevera">Nevera</option>
                        <option value="estufa">Estufa</option>
                        <option value="campana">Campana</option>
                        <option value="lavaplatos">Lavaplatos</option>
                    </select>
                </div>

                <div class="mb-4 hidden" id="modeloElemento">
                    
                    <label for="" class="form-label text-start">Modelo</label>

                    <div class="row row-cols-1 row-cols-md-3 mb-4" id="modelos">
                            <p>No tenemos modelos disponibles</p>
                    </div>

                    <div class="mb-2 text-center">
                        <button type="button" class="btn btn-dark mb-2" id="agregarObjeto"><i class="bi bi-clipboard-plus"></i> Agregar</button><br>
                    </div>

                </div>

                <div class="text-center mb-2">
                    <a class="mouseHand2 mb-2" href="#" id="mostrarList" onclick="mostrarListaElementos()">Mostrar Listado</a>

                    <div class="hidden text-start" id="listObjetos">
                        <ol class="list-group list-group-numbered" id="listado">
                            
                        </ol>
                    </div>

                </div>

                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-dark" id="anteriorElementos"><i class="bi bi-arrow-bar-left"></i> Anterior</button>
                    <button type="button" class="btn btn-outline-dark" id="siguienteElementos">Siguiente <i class="bi bi-arrow-bar-right"></i></button>
                </div>

            </form>

        </section>
        <!-- Fin section 3 -->

        <!-- Section 4 -->
        <section class="hidden" id="sect4">
            <div class="mb-4">
                <h1>Resultados</h1>
            </div>

            <form action="">
                <div class="text-center mb-2">
                    <p class="form-text">Construye tu cocina ideal. Descarga gratis los detalles de costos, Puedes contactar con nuestros asesores y saber más.</p>
                    <a href="#" class="btn btn-outline-dark" id="resetApp">Realizar nueva cotizacion</a>
                </div>
                
                <div class="mb-4">

                    <div class="card text-center">
                        <div class="card-header">
                          <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                              <a class="nav-link active mouseHand2" id="btncostos" aria-current="true">Costos</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link mouseHand2"  id="btndetalles">Detalles</a>
                            </li>
                          </ul>
                        </div>

                        <!-- Content Result  -->

                        <!-- Primer Contenedor -->
                        <div class="card-body text-start active" id="cont-costos">
                            
                          <h5 class="card-title">Proyecto Completado</h5>

                          <div class="text-center mb-4">
                                <img src="img/graficoResult.png" alt="" width="50%">
                          </div>
                          <div class="mb-4 resultadoscont">
                            
                            <p><a href="">Medida construccion de Pared A:</a> &nbsp; <b id="medparedA">150</b>"</p>
                            <p><a href="">Medida construccion de Pared B:</a> &nbsp; <b id="medparedB">250</b>"</p>
                            <p><a href="">Total de Area de construccion:</a> &nbsp; <b id="totalArea">250</b>"</p>
                            <p><a href="">Total Estimado de Cotizacion :</a> &nbsp; <b id="totalCotiz">150,000</b></p>

                          </div>
                          <div class="text-end">
                                <a href="#" class="btn btn-primary">Descargar Cotizacion</a>
                          </div>

                        </div>
                        
                        <!-- Segundo Contenedor -->
                        <div class="card-body hidden" id="cont-detalles">
                            <table class="table">
                                <thead>
                                  <tr>
                                    <th scope="col" style="width: 20%;">Codigo Elemento</th>
                                    <th scope="col">Elemento</th>
                                    <th scope="col">Medida</th>
                                    <th scope="col">Lugar</th>
                                  </tr>
                                </thead>
                                <tbody id="detallesElementos">
                                  
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>



            </form>
        </section>
        <!-- Fin Sectio 4 -->

    </div>
    
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<script src="js/script.js"></script>

</html>