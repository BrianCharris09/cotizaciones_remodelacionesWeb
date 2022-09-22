<?php    
    class objeto extends remodelacion{
        private $codObjeto;
        private $tipo;
        private $medidas;

        public function __construct()
        {

        }

        //SETTERS
        public function setTipo($tipo){
            $this->tipo = $tipo;
        }
        //GETTERS

        public function getterObjetos(){
           $objetosResult = array();

           if (isset($_SESSION["objetosA"])) {
                $codigoA = $_SESSION["objetosA"];

                foreach ($codigoA as $value) {
                    $consultarObjeto = $this->consultarObjetoCod($value);;
                    if (count($consultarObjeto) > 0) {
                        $consultarObjeto["lugar"] = "A";
                        $objetosResult[] = $consultarObjeto;
                    }
                }
           }

           if (isset($_SESSION["objetosB"])) {
                $codigoB = $_SESSION["objetosB"];

                foreach ($codigoB as $value) {
                    $consultarObjeto = $this->consultarObjetoCod($value);;
                    if (count($consultarObjeto) > 0) {
                        $consultarObjeto["lugar"] = "B";
                        $objetosResult[] = $consultarObjeto;
                    }
                }
           }
           return $objetosResult;
        }

        //Methods
        
        /* GUARDAR */

        public function guardarObjetosArea()
        {
            global $con;

            if (isset($_SESSION["objetosA"])) {
                $codigoA = $_SESSION["objetosA"];

                foreach ($codigoA as $key => $value) {
                    
                    $script = "INSERT INTO objetosarea VALUES(
                        null,
                        ".$value.",
                        ".$this->codHistorial.",
                        'A'
                    )";

                    $result = mysqli_query($con,$script);

                }
            }

            if (isset($_SESSION["objetosB"])) {
                $codigoB = $_SESSION["objetosB"];

                foreach ($codigoB as  $value) {
                    
                    $script = "INSERT INTO objetosarea VALUES(
                        null,
                        ".$value.",
                        ".$this->codHistorial.",
                        'B'
                    )";

                    $result = mysqli_query($con,$script);

                }
            }
        }

        public function guardarObjetoSeleccionado($codObjeto,$pared)
        {
            if ($pared ==  "A") {
                if (!isset($_SESSION["objetosA"])) {
                    $_SESSION["objetosA"] = array();
                }

                $_SESSION["objetosA"][] = $codObjeto;

            } else if ($pared ==  "B") {
                if (!isset($_SESSION["objetosB"])) {
                    $_SESSION["objetosB"] = array();
                }

                $_SESSION["objetosB"][] = $codObjeto;

            }
            
        }
        
        /* CONSULTAS */
        public function consultarObjetoTipo(){
            global $con;

            $datos = array();

            $sql = "SELECT * FROM objetos WHERE tipo = '".$this->tipo."' ORDER BY medidas";

            $result = mysqli_query($con,$sql);

            while ($row = mysqli_fetch_array($result)) {
                $datos[] = array(
                    "codObjeto" => $row["codObjeto"],
                    "tipo" => $row["tipo"],
                    "medidas" => $row["medidas"],
                    "img" => $row["imagen"]
                );
            }

            return $datos;
        }

        public function consultarObjetoCod($codObjeto){
            global $con;

            $datos = array();

            $sql = "SELECT * FROM objetos WHERE codObjeto = '".$codObjeto."' ORDER BY medidas";

            $result = mysqli_query($con,$sql);

            while ($row = mysqli_fetch_array($result)) {
                $datos = array(
                    "codObjeto" => $row["codObjeto"],
                    "tipo" => $row["tipo"],
                    "medidas" => $row["medidas"],
                    "img" => $row["imagen"]
                );
            }

            return $datos;

        }

        public function consultarObjetosAgregados($pared)
        {
            $objetosAgregados = array();
            if ($pared == "A") {
                if (isset($_SESSION["objetosA"])) {
                    $codigos = $_SESSION["objetosA"];
                    foreach ($codigos as $key => $value) {
                        $consultarObjeto = $this->consultarObjetoCod($value);;
                        if (count($consultarObjeto) > 0) {
                            $objetosAgregados[] = $consultarObjeto;
                        }
                    }
                }
            }else if($pared == "B"){
                if (isset($_SESSION["objetosB"])) {
                    $codigos = $_SESSION["objetosB"];
                    foreach ($codigos as $key => $value) {
                        $consultarObjeto = $this->consultarObjetoCod($value);
                        if (count($consultarObjeto) > 0) {
                            $objetosAgregados[] = $consultarObjeto;
                        }
                    }
                }
            }

            return $objetosAgregados;
        }

        public function consultarNumElementosA()
        {
            if (isset($_SESSION["objetosA"])) {
                return count($_SESSION["objetosA"]);
            }
            return 0;
        }

        public function calcTotalMedidasA(){
            $sumaMedidas = 0;
            
            if (isset($_SESSION["objetosA"])) {
                $codigos = $_SESSION["objetosA"];
                foreach ($codigos as  $value) {
                    $consultarObjeto = $this->consultarObjetoCod($value);
                    if (count($consultarObjeto) > 0) {
                        $sumaMedidas+= intval($consultarObjeto["medidas"]);
                    }
                }
            }

            return $sumaMedidas;
        }

        public function calcTotalMedidasB(){
            $sumaMedidas = 0;
            
            if (isset($_SESSION["objetosB"])) {
                $codigos = $_SESSION["objetosB"];
                foreach ($codigos as  $value) {
                    $consultarObjeto = $this->consultarObjetoCod($value);
                    if (count($consultarObjeto) > 0) {
                        $sumaMedidas+= intval($consultarObjeto["medidas"]);
                    }
                }
            }

            return $sumaMedidas;
        }

        /* ELIMINAR */
        public function quitarElementos(){
            $objetosQuitar = array();
            if (isset($_SESSION["objetosA"])) {
                $codigos = $_SESSION["objetosA"];
                foreach ($codigos as $key => $value) {
                    $consultarObjeto = $this->consultarObjetoCod($value);;
                    if (count($consultarObjeto) > 0) {
                        $objetosQuitar[] = $consultarObjeto["tipo"];
                    }
                }
            }
            if (isset($_SESSION["objetosB"])) {
                $codigos = $_SESSION["objetosB"];
                foreach ($codigos as $key => $value) {
                    $consultarObjeto = $this->consultarObjetoCod($value);
                    if (count($consultarObjeto) > 0) {
                        $objetosQuitar[] = $consultarObjeto["tipo"];
                    }
                }
            }

            return $objetosQuitar;

        }


        public function eliminarObjeto($cod,$pared){
            if ($pared == "A") {
                $pos = -1; 
                $codigos = $_SESSION["objetosA"];
                for ($i=0; $i < count($codigos); $i++) {
                    if ($cod == $codigos[$i]) {
                        $pos = $i;
                        break;
                    }
                }

                if ($pos != -1) {
                    unset($_SESSION["objetosA"][$pos]);
                }
            }

            if ($pared == "B") {
                $pos = -1; 
                $codigos = $_SESSION["objetosB"];
                for ($i=0; $i < count($codigos); $i++) {
                    if ($cod == $codigos[$i]) {
                        $pos = $i;
                        break;
                    }
                }

                if ($pos != -1) {
                    unset($_SESSION["objetosB"][$pos]);
                }
            }
        }


    }

?>