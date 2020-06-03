<?php
 $keyContinente = array_search($c, array_column(json_decode(json_encode($Continentes), TRUE), 'id'));
 $keypais = null;
 $pais_id = null;
 $actualPais = null;
 if (isset($_GET["id"]) && $_GET["id"] != "new") {
  $pais_id =  $_GET["id"];
  $keypais = array_search($pais_id, array_column(json_decode(json_encode($Continentes[$keyContinente]->countries), TRUE), 'id'));
  $actualPais = $Continentes[$keyContinente]->countries[$keypais];
  if ($actualPais && isset($_GET["save"])) {
    $Continentes[$keyContinente]->countries[$keypais]->name = $_POST["name"];
    $Continentes[$keyContinente]->countries[$keypais]->description = $_POST["description"];
    $Continentes[$keyContinente]->countries[$keypais]->toUpdate = true;
    header("Location: index.php?menu=pais&c=".$c."");
    
  }

}
 if (isset($_GET["save"]) && !$actualPais) {
 
 }

if (isset($_GET["action"])) {
  
  if ($_GET["action"] == "delete") {

    if (isset($_GET["id"])) {
     $Continentes[$keyContinente]->countries[$keypais]->toDelete = true;
      
      foreach($Departamentos as $dpto){
        if ($dpto->pais_id == $pais_id) {
          $dpto->toDelete = true;
        }
      }
    }
  }
}
?>



<div class="row">

  <div class="col-10 border text-center">
    <h3>Paises de <?php echo $continente->name; ?></h3>

  </div>
  <div class="col-2 border text-center">
    <?php
    if (!isset($_GET["action"])) {

      echo '<a class="btn btn-success" href="?menu=pais&c=' . $c . '&action=new">Agregar Pais </a>';
    }
    ?>
  </div>
  <div class="col-6">

    <table class="table">
      <thead>
        <tr>
          <th scope="col">id</th>
          <th scope="col">nombre</th>
          <th scope="col">descripcion</th>
          <th scope="col">No departamentos</th>
          <th scope="col" colspan="2">acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($continente->countries as  $country) {
          $countryDepartamentos = array_filter(
            $Departamentos,
            function ($e) use ($country) {
              return $e->pais_id == $country->id;
            }
          );
        ?>
          <?php 
        
          if ($country->toDelete) { ?>

            <tr class="table-danger">
            <?php
          }else if ($country->toUpdate) {
            ?>

            <tr class="table-Primary">
            <?php
          } else {
            ?>

            <tr class="table-Default">
            <?php
          }
            ?>


            <th scope="row"><?php
                            echo $country->id ?></th>
            <td><?php
                echo $country->name ?></td>
            <td><?php
                echo $country->description ?></td>
            <td><?php
                echo count($countryDepartamentos) ?> <a href="<?php echo 'index.php?menu=departamento&d=' . $country->id ?>">Ver departamentos </a>
            </td>
            <td>
              <?php

              if( !$country->toDelete && !$country->toUpdate){
                echo '<a class="btn btn-success" href="?menu=pais&c=' . $c . '&action=edit&id=' . $country->id . '">Editar </a>';

              }
             
              ?>
            </td>
            <td>
              <?php
              if( !$country->toDelete  && !$country->toUpdate){
              echo '<a class="btn btn-danger" href="?menu=pais&c=' . $c . '&action=delete&id=' . $country->id . '">Eliminar </a>';
              }else {
              $sms=   $country->toDelete?  "A Eliminar" :  "A Actualizar";
                echo $sms;
              }
              ?>
            </td>

            </tr>
          <?php

        }
          ?>


      </tbody>
    </table>
  </div>
  <?php

  if (isset($_GET["action"])) {

    if ($_GET["action"] == "new" || $_GET["action"] == "edit") {
      $id =  $_GET["id"] ? $_GET["id"] : 'new';
  ?>
      <div class="col-6">
        <form action="<?php echo 'index.php?menu=pais&c='.$c.'&action='.$_GET["action"].'&id='.$id.'&save=true'; ?>" method="POST">
          <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" name="name" aria-describedby="nameHelp" placeholder="Digita un nombre"  value="<?php if($actualPais) { echo $actualPais->name;} ?>" >
            <small id="nameHelp" class="form-text text-muted">El nombre debe ser unico en el continente</small>
          </div>
          <div class="form-group">
            <label for="description">Descripcion</label>
            <input type="text" class="form-control" name="description" placeholder="descripcion" value="<?php if($actualPais) { echo $actualPais->description;} ?>">
          </div>

          <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
      </div>
    <?php
    }
    
  }
  ?>

</div>