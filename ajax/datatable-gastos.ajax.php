<?php

require_once "../controladores/gastos.controlador.php";
require_once "../modelos/gastos.modelo.php";

class TablaGastos{

 	/*=============================================
 	 MOSTRAR LA TABLA DE GASTOS
  	=============================================*/ 

	public function mostrarTablaGastos(){

		$item = null;
    	$valor = null;
    	$orden = "id";

  		$gastos = ControladorGastos::ctrMostrarGastos($item, $valor, $orden);	

  		if(count($gastos) == 0){

  			echo '{"data": []}';

		  	return;
  		}

  		$datosJson = '{
		  "data": [';

		  for($i = 0; $i < count($gastos); $i++){

		  	/*=============================================
 	 		TRAEMOS LAS ACCIONES
  			=============================================*/ 

  			if(isset($_GET["perfilOculto"]) && $_GET["perfilOculto"] == "Especial"){

  				//$botones =  "<div class='btn-group'><button class='btn btn-warning btnEditarProducto' idProducto='".$productos[$i]["id"]."' data-toggle='modal' data-target='#modalEditarProducto'><i class='fa fa-pencil'></i></button></div>"; 
				//  $botones ="";
  			}else{

  			$botones =  "<div class='btn-group'><button class='btn btn-warning btnEditarGasto' idGasto='".$gastos[$i]["id"]."' data-toggle='modal' data-target='#modalEditarGasto'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarGasto' idgasto='".$gastos[$i]["id"]."' vendedor='".$gastos[$i]["vendedor"]."' valor='".$gastos[$i]["valor"]."' descripcion='".$gastos[$i]["descripcion"]."'><i class='fa fa-times'></i></button></div>"; 
// 
  			}

		//  Cambie el id del vendedor por el nombre 
		  	$datosJson .='[
			      "'.($i+1).'",
			      "'.$gastos[$i]["vendedor"].'",
			      "'.$gastos[$i]["valor"].'",
				  "'.$gastos[$i]["descripcion"].'",
			      "'.$gastos[$i]["fecha"].'",
				  "'.$botones.'"
			    ],';

		  }

		  $datosJson = substr($datosJson, 0, -1);

		 $datosJson .=   '] 

		 }';
		
		echo $datosJson;


	}

}

/*=============================================
ACTIVAR TABLA DE GASTOS
=============================================*/ 
$activarGastos= new TablaGastos();
$activarGastos -> mostrarTablaGastos();





