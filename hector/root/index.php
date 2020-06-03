<?php 
    session_start();
    
    $datos_interfaz = array(); 
    
    if(!isset ($_SESSION["arry-en-memoria"]) ) {
        $_SESSION["arry-en-memoria"] = array(['n-identidad' => '1047363368', 'nombre' => 'Hector','apellido' => 'Cohen','telefono' => '000000']);        
    }
    
    $datos_interfaz = $_SESSION["arry-en-memoria"];

    if (isset($_POST['delete']))
    {
        array_splice($datos_interfaz, $_POST['delete'], 1);
        $_SESSION["arry-en-memoria"] = $datos_interfaz;
    }

    if (isset($_POST['save']))
    {
        
            $Fila_plux = ['n-identidad' => $_POST['n_id'],'nombre' => $_POST['nom'], 'apellido' => $_POST['apell'],'telefono' => $_POST['n_tel']];
            array_push($datos_interfaz, $Fila_plux);
        
            $_SESSION["arry-en-memoria"] = $datos_interfaz;    
            unset($_POST);       
    }

     if(isset($_POST['boton-editar']))
    {
        echo '
            <script>
            window.onload = function() {
            $("#editar").modal("show")
            }
            </script>'
        ;
        
    }
    if(isset($_POST['bnt-guardar-2']))
    {
     $usuario_editado['n-identidad'] = $_POST['n_id'];
        $usuario_editado['nombre'] = $_POST['nom'];
        $usuario_editado['apellido'] = $_POST['apell'];
        $usuario_editado['telefono'] = $_POST['n_tel'];
        $datos_interfaz[$_POST['bnt-guardar-2']] = $usuario_editado;
        $_SESSION["arry-en-memoria"] = $datos_interfaz;    
        unset($_POST);
     }
?>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Josefin+Slab:wght@100&display=swap" rel="stylesheet"> 
        <style rel="stylesheet">


            
            img#borrar{
                height: 20px;
                width: 20px;
            }
            div#scroll_B{
                height: 290px;
                overflow: scroll;
            }
            .body{
                background-color:  #ff8a65;
                width: 100%;
                font-family: 'Josefin Slab', serif;
            }
            .btn_recarga{
                margin-left: 5%;
            }

            .table{

                background-color: #bf360c;
                border-radius: 1rem;
                border-color: transparent;
            }
            .modal-body{
                background-color: #aecccc  ;
            }
            .Ingreso_datos{
                width: 70%;
                margin-left: 14.5%;
                margin-top: 30px;   
            }




        </style>
    </head>
    <body class="body">
       <br> 
       <form action="Index.php">
            <div class="btn_recarga ">
                <p><button title="Refresh page" class="btn btn-outline-primary">Recargar</button></p>
            </div>
        </form>       
       <br>          
        <form method="POST">
            <div class="Ingreso_datos">
                <table class="table">
                    <tr>
                        <thead>
                            <th class="text text-center" colspan="4"><h2>Ingreso de Datos</h2></th colspan="4">
                        </thead>
                        <tbody>
                            <tr>
                                <th><input type="text" required class="form-control" name="n_id" placeholder="Numero de Identidad"></th>
                                <th><input type="text" required class="form-control" name="nom" placeholder="Nombre"></th>
                                <th><input type="text" required class="form-control" name="apell" placeholder="Apellido"></th>
                                <th><input type="text" required class="form-control" name="n_tel" placeholder="Numero de Telefono"></th>                      
                            </tr>
                            <tr>
                                <th class="text text-center"colspan="4">
                                
                                    <button name="save" title="Guardar" class="btn btn-dark"><img id="borrar" src="imagenes\salvar.png"></button>
                                   
                                
                                </th>
                            </tr>
                        </tbody>
                    </tr>
                </table>
            </div>
        </form>
        <div id="scroll_B" class="Ingreso_datos">
            <table class="table">
                <thead>
                    <th class="text text-center" colspan="6"><h2>Datos Ingresados</h2></th colspan="4">
                </thead>
                <tbody>
                    <tr">                    
                        <th>Indice</th>
                        <th>Numero de Identidad</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Telefono</th>
                        <th>B/E</th>
                    </tr>
                <?php
                        foreach($datos_interfaz as $indice => $_datos_)
                        {               
                ?>
                            <tr>
                                <th class="text text-center"><?php echo $indice; ?></th>
                                <th class="text text-center"><?php echo $_datos_["n-identidad"] ?></th>
                                <th class="text text-center"><?php echo $_datos_["nombre"] ?></th>
                                <th class="text text-center"><?php echo $_datos_["apellido"] ?></th>
                                <th class="text text-center"><?php echo $_datos_["telefono"] ?></th>
                                <th class="text text-center">
                                    <form method="POST">
                                        
                                        <button name="delete" title="Borrar" value="<?php echo $indice?>" class="btn btn-outline-danger"><img id="borrar" src="Imagenes/menos.png"></button>                                                          
                                        <button name="boton-editar" value="<?php echo $indice?>" class="btn btn-outline-primary"><img id="borrar" src="imagenes\boligrafo.png"></button>

                                    </form>
                                    
                                </th>
                            </tr>                            
                    <?php
                        }
                    ?>
                </tbody>
            </table>            
            </div>
        </div>
        <div class="modal fade" id="editar">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #d0aaaa">
                        <h2 class="modal-tittle">Editar Usuario</h2>
                    </div>
                    <form method="POST">
                        <?php $indice =$_POST['boton-editar'] ?>
                        <div class="modal-body">
                        <br>
                        <input value="<?php echo $datos_interfaz[$indice]['n-identidad']; ?>"  type="text" required class="form-control" name="n_id" placeholder="Numero de Identidad">
                        <br>
                        <input value="<?php echo $datos_interfaz[$indice]['nombre']; ?>" type="text" required class="form-control" name="nom" placeholder="Nombre">
                        <br>
                        <input value="<?php echo $datos_interfaz[$indice]['apellido']; ?>" type="text" required class="form-control" name="apell" placeholder="Apellido">
                        <br>
                        <input value="<?php echo $datos_interfaz[$indice]['telefono']; ?>" type="text" required class="form-control" name="n_tel" placeholder="Numero de Telefono">
                    </div>
                    <div class="modal-foother">
                       <form method="POST">
                            <button style="background-color: #c7ed85"name="bnt-guardar-2" title="Guardar" class="btn btn-outline-success container">Guardar</button>
                        <button class="btn btn-secondary container" data-dismiss="modal">Cerrar</button>                          
                       </form>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</html>