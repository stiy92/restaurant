<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Tablero de Mesas
      
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="crear-venta"><i class="fa fa-dashboard"></i> Ventas</a></li>
      
      <li class="active">Mesas</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="row">
      
    <?php

    if($_SESSION["perfil"] =="Administrador"){

      include "inicio/mesas-superiores.php";

    }

    ?>

    </div> 

   

  </section>
 
</div>
