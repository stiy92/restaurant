<?php

$item = null;
$valor = null;
$orden = "id";
$fechaInicial = null;
$fechaFinal = null;

// VER SUMA TOTAL DE VENTAS POR DIA//////////////////////
$ventass = ControladorVentas::ctrRangoventasf($fechaInicial, $fechaFinal);
///////////////////////////////////////////////////

// VER SUMA TOTAL DE GASTOS POR DIA ////////////////////////////
$gastos = ControladorGastos::ctrRangogastosf($fechaInicial, $fechaFinal);
//////////////////////////////////////////////////////////

// VER SUMA TOTAL CREDITO POR DIA//////////////////////
$ventascre = ControladorVentas::ctrRangocreditof($fechaInicial, $fechaFinal);
///////////////////////////////////////////////////

// VER SUMA TOTAL NEQUI POR DIA//////////////////////
$ventasneq = ControladorVentas::ctrRangonequif($fechaInicial, $fechaFinal);
///////////////////////////////////////////////////

// VER SUMA TOTAL ABONADO//////////////////////
$abonadot = ControladorVentas::ctrRangocreditofabonado($fechaInicial, $fechaFinal);
///////////////////////////////////////////////////
//// VALOR FINAL/////////////////////////////////
$valor =$ventass["total"] + $ventasneq["total"] + $abonadot["total"] - $gastos["total"];
////////////////////////////////////////////////////////

?>

<!-- primera cuatro mesas -->

<!-- VENTAS EFECTIVOS POR DIA-->
<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-aqua">
    
    <div class="inner">
      
      <h3>$<?php echo number_format($ventass["total"],2); ?></h3>

      <h4 style="font-weight: bold;">Mesa #1</h4>
    
    </div>
    
    <div class="icon">
      
      <i class="fa fa-cutlery"></i>
    
    </div>
    
    <a href="ventas" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>

<!-- VENTAS EFECTIVOS POR DIA-->
<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-aqua">
    
    <div class="inner">
      
      <h3>$<?php echo number_format($ventass["total"],2); ?></h3>

      <h4 style="font-weight: bold;">Mesa #2</h4>
    
    </div>
    
    <div class="icon">
      
      <i class="fa fa-cutlery"></i>
    
    </div>
    
    <a href="ventas" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>


<!-- VENTAS EFECTIVOS POR DIA-->
<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-aqua">
    
    <div class="inner">
      
      <h3>$<?php echo number_format($ventass["total"],2); ?></h3>

      <h4 style="font-weight: bold;">Mesa #3</h4>
    
    </div>
    
    <div class="icon">
      
      <i class="fa fa-cutlery"></i>
    
    </div>
    
    <a href="ventas" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>

<!-- VENTAS EFECTIVOS POR DIA-->
<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-aqua">
    
    <div class="inner">
      
      <h3>$<?php echo number_format($ventass["total"],2); ?></h3>

      <h4 style="font-weight: bold;">Mesa #4</h4>
    
    </div>
    
    <div class="icon">
      
      <i class="fa fa-cutlery"></i>
    
    </div>
    
    <a href="ventas" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>

<!-- end -->

<!-- segundas cuatro mesas -->

<!-- VENTAS EFECTIVOS POR DIA-->
<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-aqua">
    
    <div class="inner">
      
      <h3>$<?php echo number_format($ventass["total"],2); ?></h3>

      <h4 style="font-weight: bold;">Mesa #5</h4>
    
    </div>
    
    <div class="icon">
      
      <i class="fa fa-cutlery"></i>
    
    </div>
    
    <a href="ventas" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>

<!-- VENTAS EFECTIVOS POR DIA-->
<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-aqua">
    
    <div class="inner">
      
      <h3>$<?php echo number_format($ventass["total"],2); ?></h3>

      <h4 style="font-weight: bold;">Mesa #6</h4>
    
    </div>
    
    <div class="icon">
      
      <i class="fa fa-cutlery"></i>
    
    </div>
    
    <a href="ventas" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>


 <!-- VENTAS EFECTIVOS POR DIA-->
<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-aqua">
    
    <div class="inner">
      
      <h3>$<?php echo number_format($ventass["total"],2); ?></h3>

      <h4 style="font-weight: bold;">Mesa #7</h4>
    
    </div>
    
    <div class="icon">
      
      <i class="fa fa-cutlery"></i>
    
    </div>
    
    <a href="ventas" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>

 <!-- VENTAS EFECTIVOS POR DIA-->
<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-aqua">
    
    <div class="inner">
      
      <h3>$<?php echo number_format($ventass["total"],2); ?></h3>

      <h4 style="font-weight: bold;">Mesa #8</h4>
    
    </div>
    
    <div class="icon">
      
      <i class="fa fa-cutlery"></i>
    
    </div>
    
    <a href="ventas" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>

<!-- end -->

<!-- #3 cuatro mesas -->

<!-- VENTAS EFECTIVOS POR DIA-->
<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-aqua">
    
    <div class="inner">
      
      <h3>$<?php echo number_format($ventass["total"],2); ?></h3>

      <h4 style="font-weight: bold;">Mesa #9</h4>
    
    </div>
    
    <div class="icon">
      
      <i class="fa fa-cutlery"></i>
    
    </div>
    
    <a href="ventas" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>

<!-- VENTAS EFECTIVOS POR DIA-->
<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-aqua">
    
    <div class="inner">
      
      <h3>$<?php echo number_format($ventass["total"],2); ?></h3>

      <h4 style="font-weight: bold;">Mesa #10</h4>
    
    </div>
    
    <div class="icon">
      
      <i class="fa fa-cutlery"></i>
    
    </div>
    
    <a href="ventas" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>


 <!-- VENTAS EFECTIVOS POR DIA-->
<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-aqua">
    
    <div class="inner">
      
      <h3>$<?php echo number_format($ventass["total"],2); ?></h3>

      <h4 style="font-weight: bold;">Mesa #11</h4>
    
    </div>
    
    <div class="icon">
      
      <i class="fa fa-cutlery"></i>
    
    </div>
    
    <a href="ventas" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>

 <!-- VENTAS EFECTIVOS POR DIA-->
<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-aqua">
    
    <div class="inner">
      
      <h3>$<?php echo number_format($ventass["total"],2); ?></h3>

      <h4 style="font-weight: bold;">Mesa #12</h4>
    
    </div>
    
    <div class="icon">
      
      <i class="fa fa-cutlery"></i>
    
    </div>
    
    <a href="ventas" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>

<!-- end -->

<!-- #4 cuatro mesas -->

<!-- VENTAS EFECTIVOS POR DIA-->
<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-aqua">
    
    <div class="inner">
      
      <h3>$<?php echo number_format($ventass["total"],2); ?></h3>

      <h4 style="font-weight: bold;">Mesa #13</h4>
    
    </div>
    
    <div class="icon">
      
      <i class="fa fa-cutlery"></i>
    
    </div>
    
    <a href="ventas" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>

<!-- VENTAS EFECTIVOS POR DIA-->
<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-aqua">
    
    <div class="inner">
      
      <h3>$<?php echo number_format($ventass["total"],2); ?></h3>

      <h4 style="font-weight: bold;">Mesa #14</h4>
    
    </div>
    
    <div class="icon">
      
      <i class="fa fa-cutlery"></i>
    
    </div>
    
    <a href="ventas" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>


 <!-- VENTAS EFECTIVOS POR DIA-->
<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-aqua">
    
    <div class="inner">
      
      <h3>$<?php echo number_format($ventass["total"],2); ?></h3>

      <h4 style="font-weight: bold;">Mesa #15</h4>
    
    </div>
    
    <div class="icon">
      
      <i class="fa fa-cutlery"></i>
    
    </div>
    
    <a href="ventas" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>

 <!-- VENTAS EFECTIVOS POR DIA-->
<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-aqua">
    
    <div class="inner">
      
      <h3>$<?php echo number_format($ventass["total"],2); ?></h3>

      <h4 style="font-weight: bold;">Mesa #16</h4>
    
    </div>
    
    <div class="icon">
      
      <i class="fa fa-cutlery"></i>
    
    </div>
    
    <a href="ventas" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>

<!-- end -->
