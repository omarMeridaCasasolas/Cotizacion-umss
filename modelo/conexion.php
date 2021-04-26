<?php 
    class Conexion {
        protected $connexion_bd;
        public function Conexion(){
            try {
                // $this->connexion_bd = new PDO("pgsql:host=129.151.100.42;port=5432;dbname=cotizacion","omar","js77Hi1JhG76GKp");
                $this->connexion_bd = new PDO("pgsql:host=localhost;port=5434;dbname=PruebaRolesUsuario","postgres","kirium");
                //Lo mas importante
                $this->connexion_bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $this->connexion_bd;
            } catch(Exception $e){
                echo $e->getMessage()."<br>";
                echo "Error en la linea ".$e->getLine();
            }
        }
    }