<?php

//Este es un ejemplo de como se pudo haber desarrollado el parcial #2 segun lo explicado en las clases, trabajaremos con php y mysqli
//vamos a incluir nuestro archivo de modelos con sus respectivas funciones y la clase de conexion a la base de datos, mirar archivo clases.php
require_once('Clases.php');
//primero iniciaremos la session para no tener inconvenientes con eso
session_start();

//obtenemos nuestra ruta raiz o nombre del archivo actual para referirnos a el por get o post
$estearchivo = $_SERVER['PHP_SELF'];
//declaramos los arrays con los que vamos a trabajar y validamos la session en este caso 2 segun lo planteado para el parcial
//estos arrays son los que contendran los datos que vamos a mostrar,
$Continentes = [];
$Departamentos = [];

if (!isset($_SESSION["Continentes"])) { //si no se ha iniciado la session
  $Continentes = Continent::all(); //consultamos nuestra base de datos mediante esta funcion

  //verificamos si hay datos en la db
  if (count($Continentes) > 0) {
    $_SESSION["Continentes"] = $Continentes; //los pasamos a la variable session
  } else { //si no tenemos datos en la base de datos creamos los continetes
    $continents = [

      new Continent(1,  "América",  "la descripcion que quieras"),

      new Continent(2, "Asia", "la descripcion que quieras"),

      new Continent(3,   "Oceanía",  "la descripcion que quieras"),

      new Continent(4,  "Europa",  "la descripcion que quieras"),

      new Continent(5,  "África", "la descripcion que quieras"),
    ];
    foreach ($cont as  $continents) {
      Continent::createContinent($cont); //aqui los registramos de a uno en uno
    }

    //y volvemos a consultarlos
    $Continentes = Continent::all();
    $_SESSION["Continentes"] = $Continentes;
  }
  $Departamentos = Departament::all(); // se supone que aqui ya estan insertado los continentes, entonces miramos a ver si hay departamentos
  $_SESSION["Departamentos"] = $Departamentos;
}
if (isset($_SESSION["Continentes"])) { //si hemos iniciado session previamente

  $Continentes = $_SESSION["Continentes"];
  $Departamentos = $_SESSION["Departamentos"];
}


if (isset($_GET["guardarendb"])) {
  //Guardando paises
  foreach ($Continentes as  $continente) {
    $paises = $continente->countries;
    foreach ($paises as  $pais) {
      if ($pais->toSave) {
        Country::saveStatic($pais, $continente->id);
      }

      if ($pais->toDelete) {
       
        $pais->delete();
      }
      if ($pais->toUpdate) {
        echo $pais->name;
        echo $pais->update();
      }
    }
  }

  $Continentes = Continent::all();
  $_SESSION["Continentes"] = $Continentes;
  //header("Location: index.php");
}

?>



<html lang="ES">

<head>
  <title>Demostracion segundo parcial</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

</head>

<body>
  <?php include("pages/nav.php"); ?>
  <div class="container-fluid">



    <div class="row mb-5">
      <div class="col-10">
        <h3>Este es un ejemplo de como pudo haberse hecho el parcial #2</h3>
      </div>
      <div class="col-2"><a href="index.php?guardarendb=true" class="btn btn-primary"> Guardar en Db </a></div>
    </div>
    <?php
    if (!isset($_GET["menu"])) { //Usamos una varible get para controlar los bloques, en caso de que no exita estaremos en la vista principal
      include("pages/vistaprincipal.php");
    }
    if (isset($_GET["menu"])) { //Usamos una varible get para controlar los bloques, en caso de que  miramos que menu es y si tiene otro parametro
      if ($_GET["menu"] != "pais" && $_GET["menu"] != "departamento") //si nuestro menu es invalido
      {
        echo "el menu seleccionado no existe";
        echo "<a href='index.php'>Volver al inicio</a>";
      } else { //si nuestro menu es valido entonces procedemos a realizar las funciones respectivas
        if ($_GET["menu"] == "pais") {
          if (isset($_GET["c"])) {  //usamos otro parametro get para pasar el codigo del continente seleccionado
            $c = $_GET["c"];
            //una forma de buscar con funciones de flechas y array_filter     

            $continente = current(array_filter($Continentes, function ($e) use ($c) {
              return $e->id == $c;
            }));


            //echo "segunda busqueda " .$continente->name."<br>";

            //otra forma buscando con array_search
            $key = array_search($c, array_column(json_decode(json_encode($Continentes), TRUE), 'id'));
            $continente = $Continentes[array_search($c, array_column(json_decode(json_encode($Continentes), TRUE), 'id'))];

            // de forma directa
            $continente = $Continentes[$key];
            if ($continente) {

              include("pages/MostrarPaisesdecontinente.php");
            } else {
              echo "no se encontro el continente";
            }
    ?>

    <?php
          }
        }
        if ($_GET["menu"] == "departamento") {
          if (isset($_GET["d"])) {  //usamos otro parametro get para pasar el codigo del continente seleccionado
            $id = $_GET["d"];
            $country = null;

            foreach ($Continentes as  $continente) {
              $country = current(array_filter($continente->countries, function ($e) use ($id) {
                return $e->id == $id;
              }));
              if ($country) {
                break;
              }
              var_dump($country);
            }
            include("pages/Mostrardepartamentosdepais.php");
          }
        }
      }
    }
    ?>

  </div>
</body>

</html>