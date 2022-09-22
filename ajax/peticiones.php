<?php
    session_start();
    include("../conexion/conexionBD.php");
    include("../clases/usuarios.php");
    include("../clases/remodelacion.php");
    include("../clases/objeto.php");

    $solicitud = $_POST["peticion"];


    //Objetoss
    $users = new usuario();
    $remodelacion = new remodelacion();
    $objeto = new objeto();
    //---------------------------
    switch ($solicitud) {

        case 'guardar-Cliente':
            $datosClie = $_POST["datosCliente"];
            $users->guardarInformacion($datosClie);
            echo true;
            break;

        case 'guardar-Medidas':
            $datosMed = $_POST["datosMedidas"];
            $remodelacion->guardarMedidasAB($datosMed);
            echo true;
            break;

        case 'guardar-Objetos':
            $codObjeto = $_POST["codObjeto"];
            $objetoPared = $_POST["paredObjeto"];
            $numElement = $objeto->consultarNumElementosA();
            if ($numElement<3 || $objetoPared == "B") {
                $objeto->guardarObjetoSeleccionado($codObjeto,$objetoPared);
                echo true;
            }
            return false;

            break;

        case 'guardar-Usuario':
            
            echo $users->guardarUsuario();

            break;
        
        case 'guardar-Cotizacion':
            $asesoramiento = $_POST["resivirAsesoramiento"];
            //Guardar cotizacion
            $remodelacion->generarCodigo(6);
            $remodelacion->setMedidasParedA();
            $remodelacion->setMedidasParedB();
            $totalA = $objeto->calcTotalMedidasA();
            $remodelacion->calcularMedidasRestantesA($totalA);
            $totalB = $objeto->calcTotalMedidasB();
            $remodelacion->calcularMedidasRestantesB($totalB);
            $remodelacion->calcAreaTotalConstruccion();
            $remodelacion->calcTotalCotizacion();
            $remodelacion->setResivirAsesoramiento($asesoramiento);
            $remodelacion->initValores($_SESSION["datosCliente"]);
            $remodelacion-> consultarUsuarioCorreo($remodelacion->getCorreo());

            $remodelacion->guardarHistorialCotizacion();

            //Guardar objetos de cocina

            $objeto->setCodHistorial($remodelacion->getCodHistorial());
            $objeto->guardarObjetosArea();

            break;

        case 'consultar-Objetos-Tipo':
            $tipo = $_POST["objeto"];
            $objeto->setTipo($tipo);
            $modelos = $objeto->consultarObjetoTipo();
            echo json_encode($modelos);

            break;

        case 'consultar-Objetos':
            $paredConsultar = $_POST['pared'];
            $objetosAgregados = $objeto->consultarObjetosAgregados($paredConsultar);
            echo json_encode($objetosAgregados);

            break;

        case 'consultar-detalles-objetos':
            
            $reporte = $objeto->getterObjetos();

            echo json_encode($reporte);

            break;    
        case 'calc-Medidas-Restantes':
            $totalA = $objeto->calcTotalMedidasA();
            $totalB = $objeto->calcTotalMedidasB();

            $remodelacion->calcularMedidasRestantesA($totalA);
            $remodelacion->calcularMedidasRestantesB($totalB);

            $medidas = array(
                "medidaA"=>$remodelacion->getMedidasRestantesParedA(),
                "medidaB"=>$remodelacion->getMedidasRestantesParedB(),
            );

            echo json_encode($medidas);

            break;
        case 'calc-area-construccion':
            $totalA = $objeto->calcTotalMedidasA();
            $totalB = $objeto->calcTotalMedidasB();

            $remodelacion->calcularMedidasRestantesA($totalA);
            $remodelacion->calcularMedidasRestantesB($totalB);
            $remodelacion->calcAreaTotalConstruccion();
           
            echo json_encode($remodelacion->getTotalAreaConstruccion());

            break;
        case 'calc-Precio':
            $totalA = $objeto->calcTotalMedidasA();
            $totalB = $objeto->calcTotalMedidasB();

            $remodelacion->calcularMedidasRestantesA($totalA);
            $remodelacion->calcularMedidasRestantesB($totalB);
            $remodelacion->calcAreaTotalConstruccion();
            $remodelacion->calcTotalCotizacion();
            
            echo $remodelacion->getTotalCotizacion();
            break;
        case 'actualizar-Objetos':
            $datos =  $objeto->quitarElementos();
            echo json_encode($datos);
            break;

        case 'eliminar-Objeto':
            $codObjeto = $_POST['codElemento'];
            $eliminar = $_POST['valorEliminar'];

            $objeto->eliminarObjeto($codObjeto,$eliminar);
            echo true;

            break;
            
        case 'destructor-Sesiones':
            session_destroy();
            break;
        default:
            echo "404. Peticion No encontrada !!!";
            break;
    }
    

?>