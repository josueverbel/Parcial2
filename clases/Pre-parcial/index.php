<?php
require_once('Clases.php');
/*
$tra = new trabajocontinente();
if ($tra->guardarContinente(new Continente(null, 'continente nuevo', 'esta es la descripcion')) )
{
    echo "se guardo";
}
*/

$con = Continente::all();
foreach ($con as  $continente) {
    echo $continente->name ." : ".$continente->description."<br>";
 }
/*if(Country::guardarEnDb(new Country(null, 'colombia', 'el mejor pais del mundo'), 9)) {
    echo "se guardo el pais colombia";
}*/
if (count($con) == 0) {
    echo "no hay registros que mostrar <br>";
}else {
   // echo $con[0]->name;
}


$continentes = [ 

    new Continente (1,  "América" ,  "la descripcion que quieras"),
 
    new Continente (2, "Asia"  ,"la descripcion que quieras"),
 
    new Continente ( 3,   "Oceanía" ,  "la descripcion que quieras"),
 
    new Continente ( 4,  "Europa"  ,  "la descripcion que quieras"),
 
    new Continente ( 5,  "África" , "la descripcion que quieras"),
 ];
$nuevopais = new Country(null, 'nuevo pais', 'esta es la descripcion', true);
$nuevopais->save();

$nuevopais->name = "nombre actualizado";
$nuevopais->isupdate = true;

 if(isset($guardarpaises)){
    foreach ($continentes as  $continente) {
        $paises = $continentes->countries;
        foreach ($paises as  $pais) {
            if($pais->isnew) {
                Country::guardarEnDb($pais, $continente->id);
            }

            if ($pais->toDelete) {
                Country::deletepais($pais->id);
            }
            if($pais->toUpdate) {
                Country::updatepais($pais);
            }
            
        }
        
    }
 }
 if (!isset( $_SESSION["continentes"])) {
    
    $continentesDB = Continente::all();
    
    if (count($continentesDB) == 0) {
        
       foreach ($continentes as  $continente) {
        
           Continente::guardarEnDb($continente);
       }
       $continentesDB = Continente::all();
   }
   $_SESSION["continentes"] = $continentesDB;
 }
 

?>