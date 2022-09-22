<?php

    class remodelacion extends usuario{
        protected $codHistorial;
        private $medidasParedA;
        private $medidasParedB;
        private $medidasRestantesA;
        private $medidasRestantesB;
        private $totalAreaConstruccion;
        private $totalCotizacion;
        private $resivirAsesoramiento;

        public function __construct()
        {
            
        }

        public function initValores($datos){
            $this-> correo = $datos["correo"];
        }


        //Setter


        public function setCodHistorial($codigo){
            $this->codHistorial = $codigo;
        }

        public function setResivirAsesoramiento($asesoramiento)
        {
            $this->resivirAsesoramiento = $asesoramiento;
        }

        public function setMedidasParedA(){
            $this->medidasParedA = $this->getMedidasParedA();
        }

        public function setMedidasParedB(){
            $this->medidasParedB = $this->getMedidasParedB();
        }

        //Getter

        public function getCodHistorial(){
            return $this->codHistorial;
        }

        public function getMedidasParedA(){
            return $_SESSION["medidasArea"]["medidaA"];
        }

        public function getMedidasParedB(){
            return $_SESSION["medidasArea"]["medidaB"];
        }

        public function getMedidasRestantesParedA(){
            return $this->medidasRestantesA;;
        }
        
        public function getMedidasRestantesParedB(){
            return $this->medidasRestantesB;
        }

        public function getTotalAreaConstruccion()
        {
            return $this->totalAreaConstruccion;
        }

        public function getTotalCotizacion(){
            return $this->totalCotizacion;
        }

        public function getResivirAsesoramiento($asesoramiento)
        {
            return $this->resivirAsesoramiento;
        }



        //Methods
        
        function guardarMedidasAB($medidas){
            $_SESSION["medidasArea"] =  $medidas;
        }


        public function guardarHistorialCotizacion()
        {
            global $con;
             
            $script = "INSERT INTO historial_remodelaciones VALUES(
                ".$this->codHistorial.",
                '".$this->medidasParedA."',
                '".$this->medidasParedB."',
                '".$this->medidasRestantesA."',
                '".$this->medidasRestantesB."',
                '".$this->totalAreaConstruccion."',
                '".$this->totalCotizacion."',
                ".$this->resivirAsesoramiento.",
                '".$this->idUsuario."',
                NOW()
            )";

            $result = mysqli_query($con,$script);

        }


        public function calcularMedidasRestantesA($sumaObjetos)
        {
            $medidasRestantes = 0;
            $this->medidasParedA = $this->getMedidasParedA();
            
            $medidasRestantes = $this->medidasParedA - $sumaObjetos;

            $this->medidasRestantesA = $medidasRestantes;
        }

        public function calcularMedidasRestantesB($sumaObjetos)
        {
            $medidasRestantes = 0;
            
            $this->medidasParedB = $this->getMedidasParedB();
            /* $this->medidasParedB = 72; */
            
            $medidasRestantes = $this->medidasParedB - $sumaObjetos;

            $this->medidasRestantesB = $medidasRestantes;
        }

        public function calcAreaTotalConstruccion(){
            $areaTotal = $this->medidasRestantesA  + $this->medidasRestantesB;
            $this->totalAreaConstruccion = $areaTotal;
        }

        public function calcTotalCotizacion(){
            $this->totalCotizacion = $this->totalAreaConstruccion * 24;
        }

        public function generarCodigo($ndigitos){
            $codigo="";
            for ($i=0; $i < $ndigitos; $i++) {
                $numero=rand(0,9);
                $codigo=$codigo."$numero";
            }
            $this->codHistorial = $codigo;
        }



    }


?>