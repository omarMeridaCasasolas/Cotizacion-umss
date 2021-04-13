<?php 
    class Conexion {
        protected $connexion_bd;
        public function Conexion(){
            try {
                $this->connexion_bd = new PDO("pgsql:host=165.232.139.233;port=5432;dbname=SAPCotizacionesTIS","postgres","");
                //Lo mas importante
                $this->connexion_bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $this->connexion_bd;
            } catch(Exception $e){
                echo $e->getMessage()."<br>";
                echo "Error en la linea ".$e->getLine();
            }
        }
    }