<?php

class ControladorGastos{

	/*=============================================
	MOSTRAR GASTOS
	=============================================*/

	static public function ctrMostrarGastos($item, $valor, $orden){

		$tabla = "gastos";

		$respuesta = ModeloGastos::mdlMostrarGastos($tabla, $item, $valor, $orden);

		return $respuesta;

	}


	/*=============================================
	CREAR GASTO
	=============================================*/

	static public function ctrCrearGasto(){

		if(isset($_POST["nuevaDescripcion"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaDescripcion"]) &&
			   preg_match('/^[0-9.]+$/', $_POST["nuevoGasto"])){
				

				$tabla = "gastos";

				$datos = array(
							   "vendedor" => $_POST["idVendedor"],
							   "valor" => $_POST["nuevoGasto"],
							   "descripcion" => $_POST["nuevaDescripcion"],
							   );

				$respuesta = ModeloGastos::mdlIngresarGasto($tabla, $datos);

				if($respuesta == "ok"){
                    
					echo'<script>

						swal({
							  type: "success",
							  title: "El gasto ha sido guardado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										window.location = "gastos";

										}
									})

						</script>';

				} else{
                    
					echo'<script>

						swal({
							  type: "error",
							  title: "No se registro el gasto, usted esta utilizando un codigo ya existente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										window.location = "gastos";

										}
									})

						</script>';
				}
			}
				else{

					echo'<script>
	
						swal({
							  type: "error",
							  title: "¡El gasto no puede ir con los campos vacíos o llevar caracteres especiales!",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
	
								window.location = "gastos";
	
								}
							})
	
					  </script>';
				}


			} 
		}

	/*=============================================
	EDITAR GASTO
	=============================================*/

	static public function ctrEditargastos(){

		if(isset($_POST["editarDescripcion"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarDescripcion"]) &&
			   preg_match('/^[0-9]+$/', $_POST["editarStockM"]) &&
			   preg_match('/^[0-9]+$/', $_POST["editarStock"]) &&
			   preg_match('/^[0-9]+$/', $_POST["editarid"]) &&
			   preg_match('/^[0-9.]+$/', $_POST["editarPrecioCompra"]) &&
			   preg_match('/^[0-9.]+$/', $_POST["editarPrecioVenta"])){

		   		/*=============================================
				VALIDAR IMAGEN
				=============================================*/

			   	$ruta = $_POST["imagenActual"];

			   	if(isset($_FILES["editarImagen"]["tmp_name"]) && !empty($_FILES["editarImagen"]["tmp_name"])){

					list($ancho, $alto) = getimagesize($_FILES["editarImagen"]["tmp_name"]);

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/

					$directorio = "vistas/img/productos/".$_POST["editarCodigo"];

					/*=============================================
					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					=============================================*/

					if(!empty($_POST["imagenActual"]) && $_POST["imagenActual"] != "vistas/img/productos/default/anonymous.png"){

						unlink($_POST["imagenActual"]);

					}else{

						mkdir($directorio, 0755);	
					
					}
					
					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if($_FILES["editarImagen"]["type"] == "image/jpeg"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/productos/".$_POST["editarCodigo"]."/".$aleatorio.".jpg";

						$origen = imagecreatefromjpeg($_FILES["editarImagen"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

					if($_FILES["editarImagen"]["type"] == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/productos/".$_POST["editarCodigo"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["editarImagen"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				}

				$tabla = "productos";

				$datos = array("id_categoria" => $_POST["editarCategoria"],
							   "codigo" => $_POST["editarCodigo"],
							   "id" => $_POST["editarid"],
							   "descripcion" => $_POST["editarDescripcion"],
							   "stock_t" => $_POST["editarStockM"],
							   "stock" => $_POST["editarStock"],
							   "precio_compra" => $_POST["editarPrecioCompra"],
							   "precio_venta" => $_POST["editarPrecioVenta"],
							   "imagen" => $ruta);

				$respuesta = ModeloProductos::mdlEditarProducto($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

						swal({
							  type: "success",
							  title: "El producto ha sido editado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										window.location = "productos";

										}
									})

						</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "productos";

							}
						})

			  	</script>';
			}
		}

	}

	/*=============================================
	BORRAR GASTO
	=============================================*/
	static public function ctrEliminarGasto(){

		if(isset($_GET["idGasto"])){

			$tabla ="gastos";
			$datos = $_GET["idGasto"];

			$respuesta = ModeloGastos::mdlEliminarGasto($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El gasto ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "gastos";

								}
							})

				</script>';

			}		
		}


	}

	/*=============================================
	MOSTRAR SUMA GASTOS
	=============================================*/

	static public function ctrMostrarSumaGastos(){

		$tabla = "gastos";

		$respuesta = ModeloGastos::mdlMostrarSumaGastos($tabla);

		return $respuesta;

	}

		/*=============================================
	SUMA TOTAL GASTOS EL DIA ACTUAL
	=============================================*/

	static public function ctrSumaTotalGastosdia(){

		$tabla = "gastos";

		$respuesta = ModeloGastos::mdlSumaTotalgastosdia($tabla);

		return $respuesta;

	}

		/*=============================================
	SUMA TOTAL GASTOS POR FECHA CAJA S FINAL
	=============================================*/

	static public function ctrRangogastosf($fechaInicial, $fechaFinal){

		$tabla = "gastos";

		$respuesta = ModeloGastos::mdlRangogastosf($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;

	}

}