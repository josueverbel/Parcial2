<div class="row">

<div class="col-12 border text-center">
  <h3>Continentes</h3>
</div>
<div class="col-12">

  <table class="table">
    <thead>
      <tr>
        <th scope="col">id</th>
        <th scope="col">nombre</th>
        <th scope="col">descripcion</th>
        <th scope="col">No Paises</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($Continentes as  $continente) {
      ?>
        <tr>
          <th scope="row"><?php
                          echo $continente->id ?></th>
          <td><?php
              echo $continente->name ?></td>
          <td><?php
              echo $continente->description ?></td>
          <td><?php
              echo count($continente->countries) ?> <a href="<?php echo 'index.php?menu=pais&c=' . $continente->id ?>">Ver mas... </a> </td>
        </tr>
      <?php

      }
      ?>


    </tbody>
  </table>
</div>
</div>