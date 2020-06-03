<?php 
class Country {
    public $id;
    public $name;
    public $description;
    
    public $country_id;
}
class Continente {
    public $id;
    public $name;
    public $description;
    public $countries = [];
   
    function __construct($id = null, $name = null, $description = null) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        
    }
    function addCountry(Country $country) {
        array_push($countries, $country);
        
    }
}

$america = new Continente();
$america->id = 1;
$america->nomre = 1;
$america->coutries = [new country(1, 'colombia') , new country(1, 'colombia') ];
if (isset($_POST["agregarpais"]))
{
    $nuevoPais = new Country();
    $nuevoPais->id = 2;
    $nuevoPais->name = "argentina";
    $america->addCountry($nuevoPais);
}


$estearchivo = $_SERVER['PHP_SELF'];
$continentes = [ 

    new Continente (1,  "América" ,  "la descripcion que quieras"),
 
    new Continente (2, "Asia"  ,"la descripcion que quieras"),
 
    new Continente ( 3,   "Oceanía" ,  "la descripcion que quieras"),
 
    new Continente ( 4,  "Europa"  ,  "la descripcion que quieras"),
 
    new Continente ( 5,  "África" , "la descripcion que quieras"),
 ];


?>

<html lang="ES">
	<head>
		<title>Ejemplo Array y objets</title>
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
        <div class="container-fluid">	
            <div class="row mb-5">
                <div class="col-12"><h1>Objetos y Arrays</h1></div>
                <a class="btn btn-primary ml-3" href="<?php echo $estearchivo;?>?action=new">Nuevo Cliente</a>
            </div>	
            <div class="row">
            <div class="col-12">
                <select> 
                <?php
                foreach ($continentes as  $continente) { ?>
                <option value="<?php echo $continente->id; ?> "> <?php echo $continente->name; ?>  </option>
                <?php
                } ?>
                </select>
            </div>
            </div>
            <div class="row">
                <div class="col-6 border"> <h3>Listado de Continentes</h3>
                    <table border="0" style=" color: white; font-weight: bold; background: black; width: 100%; border-radius: 10px; text-align: center;">


                                    <tr>
                                        <th>ID</th>
                                        <th>NOMBRE</th>
                                        <th>DESCRIPCION</th>
                                        <th>PAISES</th>
                                        <th>VER PAISES</th>
                                        <th>AGREGAR PAIS</th>
                                    </tr>

                                    <?php 
                                    foreach ($continentes as  $continente) {
                                      
                                    ?>

                                                    <tr>
                                                        <td><?php echo $continente->id; ?></td>
                                                        <td><?php echo $continente->name; ?></td>
                                                        <td><?php echo $continente->description; ?></td>
                                                        <td><?php echo count($continente->countries); ?></td>
                                                        <td> 
                                                            <form name="borrar" method="post">
                                                                <button name="btn_ver_paises" value="<?php echo $indice; ?>" class="btn fa fa-trash-o" style=" color: white; font-weight: bold; background: black; width: 100%;">
                                                                   
                                                                </button>
                                                            </form>
                                                        </td>
                                                        <td>
                                                            <form name="actualizar" method="post" action="<?php echo $estearchivo;?>">
                                                                <button name="btn_add_country" value="<?php echo $indice; ?>" class="btn fa fa-plus" style=" color: white; font-weight: bold; background: black; width: 100%;">
                                                                    <!--podemos tambien enviar el registro para no consultarlo en un input hidden -->
                                                                    <input type="hidden" name="valor" value="<?php echo $valor; ?>" />
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                        <?php
                                                
                                            }
                                    ?>

                                </table></div>
                                <?php if(isset($_GET['action']) and $_GET['action'] == 'new') { ?>
                    <div class="col-6">
                        <div class="card shadow mb-4">
							<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
								<h6 class="m-0 font-weight-bold text-primary">Agregar Cliente</h6>
							</div>

							<div class="card-body">

								<div class="chart-area" style="height: 100%">


									<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
										<input type="text" name="id_cliente" required class="form-control" placeholder="identificacion" onkeypress='return validaNumericos(event)'/>
										<input type="text" name="nombre1" required class="form-control" placeholder="nombre"/>
										<button name="btn_guardar" class="btn btn-lg" style=" color: white; font-weight: bold; background: black; width: 100%;">GUARDAR</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                    <?php } ?>
                    <?php if(isset($_POST['btn_actualizar']) ) { 
                        //aqui debemos consultar el registro con el indice y mostrarlo en los input y realizar el debido proceso
                        //esto es una forma de muchas como se puede hacer
                        

                        //o podemos recibir el valor enviado
                        $valor_recibido = $_POST["valor"];
                        // y mostrarlo en los input
                    ?>
                    <div class="col-6">
                        
                        <div class="card shadow mb-4">
							<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
								<h6 class="m-0 font-weight-bold text-primary"><?php 
                        
                        echo "Editando Cliente Con Indice  ".$_POST['btn_actualizar'];?></h6>
							</div>

							<div class="card-body">

								<div class="chart-area" style="height: 100%">


									<form method="post" action="<?php echo $estearchivo; ?>">
										<input type="text" name="id_cliente" required class="form-control" placeholder="identificacion" onkeypress='return validaNumericos(event)'/>
										<input type="text" name="nombre1" required class="form-control" placeholder="nombre"/>
										<button name="btn_editar" class="btn btn-lg" style=" color: white; font-weight: bold; background: black; width: 100%;">GUARDAR</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                    <?php } ?>
            </div>
        </div>
    </body>
</html>