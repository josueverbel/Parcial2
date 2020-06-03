<div class="row">

  <div class="col-10 border text-center">
    <h3>Departamentos de <?php echo $country->name; ?></h3>
    
  </div>
  <div class="col-2 border text-center">
  <?php
    if (!isset($_POST["action"])) {
      ?>
        <button class="btn btn-success">Agregar Departamento </button>
      <?php
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
          
        </tr>
      </thead>
      <tbody>
        <?php
         $countryDepartamentos = array_filter(
          $Departamentos,
          function ($e) use ($country) {
            return $e->pais_id == $country->id;
          }
        );
        foreach ($countryDepartamentos as  $departamento) {
         
        ?>
           <?php 
        
        if ($departamento->toDelete) { ?>

          <tr class="table-danger">
          <?php
        } else {
          ?>

          <tr class="table-info">
          <?php
        }
          ?>
            <th scope="row"><?php
                            echo $departamento->id ?></th>
            <td><?php
                echo $departamento->name ?></td>
            <td><?php
                echo $departamento->description ?></td>
            
        <?php

        }
        ?>


      </tbody>
    </table>
  </div>
  <?php
  if (isset($_POST["action"])) {
  ?>
    <div class="col-6">

    </div>
  <?php
  }
  ?>

</div>