<?php 
    class usuario{
        protected $idUsuario = 0;
        private $nombres;
        protected $correo;
        private $telefono;
        private $ciudad;
        private $estado;
        private $direccion;

        public function __construct()
        {
            
        }
        
        public function initValores($datos){
            $this-> nombres = $datos["nombres"];
            $this-> correo = $datos["correo"];
            $this-> telefono = $datos["telefono"];
            $this-> ciudad = $datos["ciudad"];
            $this-> estado = $datos["estado"];
            $this-> direccion = $datos["direccion"];
        }

        //Setter
        public function setCorreo($correo){
            $this->correo =  $correo;
        }

        //Getter
        public function getIdUsuario()
        {
            return $this->idUsuario;
        }

        public function getCorreo(){
            return $this->correo;
        }


        //Methods

        public function guardarInformacion($datos){
            $_SESSION["datosCliente"] = $datos;
        }

        public function guardarUsuario()
        {
            global $con;
            if (isset($_SESSION["datosCliente"])) {
                $datos = $_SESSION["datosCliente"];
                if ($datos > 0) {

                    $this->consultarUsuarioCorreo($datos["correo"]);

                    if ($this->idUsuario == 0) {

                        $this-> initValores($datos);

                        $script = "INSERT INTO usuarios VALUES (
                            null,
                            '".$this->nombres."',
                            '".$this->correo."',
                            '".$this->telefono."',
                            '".$this->ciudad."',
                            '".$this->estado."',
                            '".$this->direccion."'
                        )";
                        $result = mysqli_query($con,$script);

                    }

                }
            }
            
        }

        public function consultarUsuarioCorreo($correo)
        {
            global $con;

            $script = "SELECT * FROM usuarios WHERE correo= '$correo' ";

            $result = mysqli_query($con,$script);

            while ($row = mysqli_fetch_array($result)) {
                $this-> idUsuario = $row["idUsers"];
                $this-> nombres = $row["nombres"];
                $this-> correo = $correo;
                $this-> telefono = $row["telefono"];
                $this-> ciudad = $row["ciudad"];
                $this-> estado = $row["estado"];
                $this-> direccion = $row["direccion"];
            }

        }

    }


?>