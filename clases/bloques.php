<?php 
	session_start();
	//declaramos el array que va a contener nuestros datos de forma local
	$miArray = array(); 

    //obtenemos nuestra ruta raiz o nombre del archivo actual para referirnos a el por get o post
    $estearchivo = $_SERVER['PHP_SELF'];

	if(!isset ($_SESSION["myArray"]) ) {
	    //si no existe la creamos con el valor inicial
	    $_SESSION["myArray"] = array(['id_cliente' => 'id_cliente', 'nombre' => 'nombre1']);
	    
	}

	$miArray = $_SESSION["myArray"];
	
	if (isset($_POST['btn_borrar']))
	{
	    //echo $_POST['btn_borrar'];
	    //echo "estamos eliminando...";
	    array_splice($miArray, $_POST['btn_borrar'], 1);
	    $_SESSION["myArray"] = $miArray;
	}

	if (isset($_POST['btn_actualizar']))
	{

	}

	if (isset($_POST['btn_guardar']))
	{
	    //aqui recibimos los valores y los podemos agregar al array local, esto les toca a ustedes
	 
	    $nuevaFila = ['id_cliente' => $_POST['id_cliente'], 'nombre' => $_POST['nombre1']];
	    array_push($miArray, $nuevaFila);
	    //luego actualizamos la variable de session

	    $_SESSION["myArray"] = $miArray;
	    unset($_POST);
	}
?>


<html lang="ES">
	<head>
		<title>Ejemplo con isset</title>
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
                <div class="col-12"><h1>Este es un ejemplo de mostrar bloques con funcion isset</h1></div>
                <a class="btn btn-primary ml-3" href="<?php echo $estearchivo;?>?action=new">Nuevo Cliente</a>
            </div>	

            <div class="row">
                <div class="col-6 border"> <h3>Listado de registros</h3>
                    <table border="0" style=" color: white; font-weight: bold; background: black; width: 100%; border-radius: 10px; text-align: center;">


                                    <tr>
                                        <th>INDICE</th>
                                        <th>IDENTIFICACION</th>
                                        <th>NOMBRE</th>
                                        <th>ELIMINAR</th>
                                        <th>EDITAR</th>
                                    </tr>

                                    <?php 
                                    foreach ($miArray as $indice => $valor) {
                                       
                                                
                                    ?>

                                                    <tr>
                                                        <td><?php echo $indice; ?></td>
                                                        <td><?php echo $valor['id_cliente']; ?></td>
                                                        <td><?php echo $valor['nombre']; ?></td>
                                                        <td> 
                                                            <form name="borrar" method="post">
                                                                <button name="btn_borrar" value="<?php echo $indice; ?>" class="btn fa fa-trash-o" style=" color: white; font-weight: bold; background: black; width: 100%;">
                                                                   
                                                                </button>
                                                            </form>
                                                        </td>
                                                        <td>
                                                            <form name="actualizar" method="post" action="<?php echo $estearchivo;?>">
                                                                <button name="btn_actualizar" value="<?php echo $indice; ?>" class="btn fa fa-pencil-square-o" style=" color: white; font-weight: bold; background: black; width: 100%;">
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