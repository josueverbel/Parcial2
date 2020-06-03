<?php
class conectar {
  
  public static  function con() 
  { 
 	 $hosti = "localhost";
 	 $user = "root";
     $password = "";
      
	 $database = "enfasis2Db";

	 $conexion = mysqli_connect($hosti ,$user ,$password) or die("Error conectando al servidor");
	
	// $res = mysqli_query("SHOW DATABASES");
	// mysqli_query("SET NAMES 'utf8'");
	 mysqli_set_charset($conexion,"utf8");
	 mysqli_select_db ($conexion, $database)or die ($database . " Base de datos no encontrada." . $user);
	return $conexion;
       
  }
	
}
class trabajocontinente {
    public function guardarContinente(Continente $continente) {
        $sql= "INSERT INTO continentes (name, description ) values ('".$continente->name."','".$continente->description."')";
       
        $res = mysqli_query(conectar::con(), $sql);
        return $res;
    }
}
class Continente {
    //no editar
    private static  $table = "continentes";

    public  $id;
    public  $name;
    public  $description;
    public $countries = [];
   
    function __construct($id = null, $name = null, $description = null) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        
    }
    function addCountry(Country $country) {
        array_push($countries, $country);
        
    }

    public static function guardarEnDb(Continente $continente){
        $sql = "INSERT INTO continentes (name, description ) values ('".$continente->name."', '". $continente->description."' )";
       
        $res = mysqli_query(conectar::con(), $sql);
        return $res;
        
    }
    public static function save () {
      
        $sql= "INSERT INTO continentes (name, 'description' ) values ('aa','adad')";
        $sql= "INSERT INTO . self::$table. (name, description ) values ('".self::$name."','".self::$description."')";
       
        $res = mysqli_query(conectar::con(), $sql);
        return $res;
    }
    public static function all () {
        $registros = [];
        $sql="SELECT * FROM ".self::$table; 
        //$sql="SELECT * FROM continentes"; 
        $res = mysqli_query(conectar::con(), $sql);
        while ($obj = mysqli_fetch_object($res, 'Continente', ['id', 'name', 'description']) ) {
           
             $registros[] = $obj;
          
        }
       
         /* while($reg=mysqli_result::fetch_assoc_array($res))
		{
           $res[0]["nombre"];
			$registros[]=$reg;
		} */
        return $registros;
      
    }

}
class Country {
    private static  $table = "paises";
    public $id;
    public $name;
    public $description;
    function __construct($id = null, $name = null, $description = null, $isnew = null, $toUpdate = null, $toDelete = null) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        //parametros para configuracion, es decir saber que hacer con este modelo
        $this->isnew = $isnew;
        $this->toUpdate = $toUpdate;
        $this->toDelete = $toDelete;
        
    }

    public $isnew;
    public $toUpdate;
    public $toDelete;

    public function save () {
        $sql= "INSERT INTO ". self::$table." (name, description ) values ('".$this->name."','".$this->description."')";
        $res = mysqli_query(conectar::con(), $sql);
        return $res;
    }
    public static function guardarEnDb(Country $country, $continente_id){
        $sql = "INSERT INTO paises (name, description, continente_id ) values ('".$country->name."', '". $country->description."', '". $continente_id."' )";
        echo $sql;
        $res = mysqli_query(conectar::con(), $sql);
        return $res;
        
    }
}
?>

