<?php
//Clase de conexion, tenemos los parametro de conexion a la db y su configuracion junto con una funcion estatica la cual podemos llamar sin instanciar

class conectar {
  
  public static  function con() 
  { 
 	 $hosti = "localhost"; //definimos el servidor
 	 $user = "root"; //definimos el usuario
     $password = ""; //definimos la contraseña
      
	 $database = "enfasis2Db"; //definimos nuestra base de datos

	 $conexion = mysqli_connect($hosti ,$user ,$password) or die("Error conectando al servidor"); //ejecutamos la conexion
	
	//configuramos la codificacion y seleccionamos la db
	 mysqli_set_charset($conexion,"utf8");
	 mysqli_select_db ($conexion, $database)or die ($database . " Base de datos no encontrada." . $user);
	return $conexion;
       
  }
	
}

//Pasamos a definir nuestros modelos, en este ejemplo trabajaremos con nuestro ids incrementables como buena practica de programacion y nuestras llaves foreneas el nombre de la tabla mas un guion bajo mas el nombre del indice ej. tabla_id 
//las propiedades del modelo concordara con los campos de la base de datos para no tener conflictos
//el nombre de la tabla asociada a ese continente estara en una propiedad static no editable
class Continent {
    //definimos el nombre de nuestra table como una constate
    const table = 'continentes';
    
    //definimos la propiedades del modelo
    public  $id;
    public  $name;
    public  $description;

    //definimos un array para guardar los paises que pertenecen al modelo
    public $countries = [];
   
    //en nuestro metodo constructor pedimos de forma opcional las propiedades del modelo y las inicializamos para crear objetos de ese modelo y trabajar mejor sus funciones

   
    function __construct($id = null, $name = null, $description = null) {
        //validamos si vienen valores en los parametros para no tener conflictos con otras inicializaciones
        if($name)  {
            $this->name = $name;
        }
        if($id)  {
            $this->id = $id;
        }
        if($description)  {
            $this->description = $description;
        }
       
        
    }

     //usaremos la constante table en las consultas para hacer referencia a nuestra tabla para solo cambiarla al iniciar la clase
    
    public static function createContinent(Continent $continent){
        
               
        $sql = "INSERT INTO . self::table. (name, description ) values ('".$continent->name."', '". $continent->description."' )";
        $res = mysqli_query(conectar::con(), $sql);
        return $res;
        
    }
    public static function all () {
        $registros = [];
        $sql="SELECT * FROM ". self::table; 
        $res = mysqli_query(conectar::con(), $sql);
        while ($obj =  mysqli_fetch_object($res, 'Continent')) {
            $obj->getPaises(); //obtengo los paises de ese continente y los asigno al array en esa funcion
            $registros[] = $obj;
         
       }
       mysqli_free_result($res);
        return $registros;
      
    }
    /* public static function find($id) {
        $sql="SELECT * FROM ".self::table. " where id='".$id."' limit 1"; 
        $res = mysqli_query(conectar::con(), $sql);
        $objet = mysql_fetch_object($res, 'Continent');
        return $objet;
    } */
    public static function delete($id) {
        $sql="DELETE  FROM ".self::table. " where id='".$id."'"; 
        $res = mysqli_query(conectar::con(), $sql);
        return $res;
    }
//definimos funciones dinamicas del modelo (cuando tenemos una instacia de un objeto)
   
    public function save () {
        $sql= "INSERT INTO . self::table. name = '".$this->name."', description  = '".$this->description."')";
        $res = mysqli_query(conectar::con(), $sql);
        return $res;
    }
    public function update () {
        $sql= "UPDATE . self::table. SET (name, description ) values ('".$this->name."','".$this->description."')";
        $res = mysqli_query(conectar::con(), $sql);
        return $res;
    }
    public function getPaises() {
        $registros = [];
        $sql="SELECT * FROM paises where continente_id = '".$this->id."'"; 
        $res = mysqli_query(conectar::con(), $sql);
        while ($obj =  mysqli_fetch_object($res, 'Country')) {
            
            $registros[] = $obj;
         
       }
       $this->countries = $registros;
       mysqli_free_result($res);
        
    }

    //funciones para trabajar en memoria

    //funcion para agregar un pais a ese objeto //debemos tener la clase pais
    function addCountry(Country $country) { //aqui es para agregar de forma temporal
        if($country->id) //validamos que el pais no tenga un 
        {
            return false;
        }
       
       array_push($countries, $country);
       return true; //retornamos un true por si queremos comprobar que se agrego
   }
   public static function find($id){
        
   }
   function removeCountry($indice){

   }

}
class Country {
   //definimos el nombre de nuestra table como una constate
   const table = 'paises';
    
   //definimos la propiedades del modelo
   public  $id;
   public  $name;
   public  $description;
    
   //propiedades que indican que accion se va a realizar,  por ejemplo si $toSave esta en true quiere decir que ese elemento se va a guardar en base de datos

    public $toSave;
    public $toUpdate;
    public $toDelete;

    function __construct($id = null, $name = null, $description = null, $toSave = null, $toUpdate = null, $toDelete = null) {
        
        if($name)  {
            $this->name = $name;
        }
        if($id)  {
            $this->id = $id;
        }
        if($description)  {
            $this->description = $description;
        }

        //parametros para configuracion de acciones, es decir saber que hacer con este modelo
        $this->toSave = $toSave;
        $this->toUpdate = $toUpdate;
        $this->toDelete = $toDelete;
        
    }

    
    public function delete () {
        $sql= "DELETE FROM ". self::table. " WHERE id = '".$this->id."'";
      
        $res = mysqli_query(conectar::con(), $sql);
        return $res;
    }
    
    public function update () {
        $sql= "UPDATE ". self::table." SET name = '".$this->name."',  description = '".$this->description."' WHERE id = '".$this->id."'";
        $res = mysqli_query(conectar::con(), $sql);
        return $res;
    }

    public static function saveStatic(Country $country, $continente_id){
        $sql = "INSERT INTO paises (name, description, continente_id ) values ('".$country->name."', '". $country->description."', '". $continente_id."' )";
        $res = mysqli_query(conectar::con(), $sql);
        return $res;
        
    }
}
class Departament {
//definimos el nombre de nuestra table como una constate
const table = 'departamentos';
    
//definimos la propiedades del modelo
public  $id;
public  $name;
public  $description;

public  $pais_id; //llave foranea para saber a que pais pertenece

//propiedades que indican que accion se va a realizar,  por ejemplo si $toSave esta en true quiere decir que ese elemento se va a guardar en base de datos

 public $toSave;
 public $toUpdate;
 public $toDelete;

 function __construct($id = null, $name = null, $description = null, $pais_id = null, $toSave = null, $toUpdate = null, $toDelete = null) {
     
     if($pais_id)  {
         $this->pais_id = $pais_id;
     }
     if($name)  {
        $this->name = $name;
    }
     if($id)  {
         $this->id = $id;
     }
     if($description)  {
         $this->description = $description;
     }

     //parametros para configuracion de acciones, es decir saber que hacer con este modelo
     $this->toSave = $toSave;
     $this->toUpdate = $toUpdate;
     $this->toDelete = $toDelete;
     
 }

 
 public static function all () {
    $registros = [];
    $sql="SELECT * FROM ". self::table; 
    $res = mysqli_query(conectar::con(), $sql);
    while ($obj =  mysqli_fetch_object($res, 'Departament')) {
       
        $registros[] = $obj;
     
   }
   mysqli_free_result($res);
    return $registros;
  
}
 public function save () {
     $sql= "INSERT INTO ". self::table." (name, description, pais_id ) values ('".$this->name."','".$this->description."', ,'".$this->pais_id."')";
     $res = mysqli_query(conectar::con(), $sql);
     return $res;
 }
 public function update () {
     $sql= "UPDATE . self::table. SET (name, description, pais_id ) values ('".$this->name."','".$this->description."','".$this->pais_id."')";
     $res = mysqli_query(conectar::con(), $sql);
     return $res;
 }

 public static function saveStatic(Departament $departament){
     $sql = "INSERT INTO paises (name, description, pais_id ) values ('".$departament->name."', '". $departament->description."', '". $departament->pais_id."' )";
     $res = mysqli_query(conectar::con(), $sql);
     return $res;
     
 }
}
?>

