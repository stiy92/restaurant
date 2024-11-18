<?php

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class ControladorVentas{

	/*=============================================
	MOSTRAR VENTAS
	=============================================*/

	static public function ctrMostrarVentas($item, $valor){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);
 
		return $respuesta;

	}

	/*=============================================
	MOSTRAR ULTIMO CODIGO
	=============================================*/

	static public function ctrMostrarCodigo(){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlMostrarCodigo($tabla);
 
		return $respuesta;

	}


	/*=============================================
	CREAR VENTA
	=============================================*/

	static public function ctrCrearVenta(){
		
		if(isset($_POST["nuevaVenta"]))
		{

			$valor = $_POST["seleccionarCliente"];
			$metodo =$_POST["nuevoMetodoPago"];
			$idmesa = $_POST["seleccionarMesa"];
			$itemmesa= "id";
		          //	echo $valor;
                     
		                                    /*=============================================
	                                            IMPRIMIR COTIZACIÓN
	                                        =============================================*/
			                     if($valor=="42" || $metodo=="Cotizacion")
								 {
                     
			         	                     if($_POST["listaProductos"] == "")			
					                          {
				                  	                     echo'<script>
                                       
				                                             swal({
				                  	                            type: "error",
				                  	                            title: "La cotización no se ha ejecuta si no hay productos",
				                  	                            showConfirmButton: true,
				                  	                            confirmButtonText: "Cerrar"
				                  	                            }).then(function(result){
				                  				                          if (result.value) {
                          
				                  				                          window.location = "ventas";
                                            
				                  				                          }
				                  			                          })
                                            
				                                             </script>';
                     
				                                                 return;
			                                  }
                     
			                           $listaProductos = json_decode($_POST["listaProductos"], true);
                     
			                           $totalProductosComprados = array();
                     
			                         foreach ($listaProductos as $key => $value) 
			                         {
                                         
			                                            array_push($totalProductosComprados, $value["cantidad"]);
                                         				
			                                            $tablaProductos = "productos";
                                         
			                                             $item = "id";
			                                             $valor = $value["id"];
			                                             $orden = "id";
                                         
			                                             $traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);
                                         
				                                         $item1a = "ventas";
				                                         $valor1a = $value["cantidad"] + $traerProducto["ventas"];
                                         
			                                            // $nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);
                                         
				                                         $item1b = "stock";
				                                         $valor1b = $value["stock"];
                                         
		                                                //$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);
                     
			                         }
                     
			                           $tablaClientes = "clientes";
                           
			                           $item = "id";
			                           $valor = $_POST["seleccionarCliente"];
                           
			                           $traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $item, $valor);
                           
			                           $item1a = "compras";
                           				
			                           $valor1a = array_sum($totalProductosComprados) + $traerCliente["compras"];
                           
		                               //	$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valor);
                           
			                           $item1b = "ultima_compra";
                           
			                           date_default_timezone_set('America/Bogota');
                           
			                           $fecha = date('Y-m-d');
			                           $hora = date('H:i:s');
			                           $valor1b = $fecha.' '.$hora;
                                       
			                           // codigo de la venta real para asignarla a la factura
                           
			                           $tabla = "ventas";
                           
		                               $traercodigo = ModeloVentas::mdlMostrarCodigo($tabla);
                           			
                      
		                                //$fechaCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1b, $valor1b, $valor);
                     
                                        //UNICA COPIA DE COTIZACION
                        				
				                        $impresora = "POS-80C";
                        
				                        $conector = new WindowsPrintConnector($impresora);
                        
				                        $printer = new Printer($conector);
                        
				                        $printer -> text(date("Y-m-d H:i:s")."\n" ."Cotización");//Fecha de la factura
                        
				                        //$printer -> setJustification(Printer::JUSTIFY_CENTER);
                        
				                        $printer -> feed(1); //Alimentamos el papel 1 vez
                        
										$printer -> text("TRADICION MALL GASTRONOMICO"."\n");//Nombre de la empresa
                  
										$printer -> text("NIT: 1.130.670.324-7"."\n");//Nit de la empresa
						
										$printer -> text("Dirección: Calle 2 Crr 5-25 - zona centro"."\n");//Dirección de la empresa
						
										$printer -> text("Teléfono: 323 488 5888"."\n");//Teléfono de la empresa
                        
				                        $printer -> text("FACTURA N.".$traercodigo["max_codigo"]."\n");//Número de factura
                        
				                        $printer -> feed(1); //Alimentamos el papel 1 vez
                        
				                        $printer -> text("Cliente: ".$traerCliente["nombre"]."\n");//Nombre del cliente
                        
				                        $printer -> text("Nit Cliente: ".$traerCliente["documento"]."\n");//Nit del cliente
                        
				                        $tablaVendedor = "usuarios";
				                        $item = "id";
				                        $valor = $_POST["idVendedor"];
                        
				                        $traerVendedor = ModeloUsuarios::mdlMostrarUsuarios($tablaVendedor, $item, $valor);
                        
				                        $printer -> text("Vendedor: ".$traerVendedor["nombre"]."\n");//Nombre del vendedor
                        
				                        $printer -> feed(1); //Alimentamos el papel 1 vez*/
                        
				                        foreach ($listaProductos as $key => $value) {
                        
					                        $printer->setJustification(Printer::JUSTIFY_LEFT);
                        
					                        $printer->text($value["descripcion"]."\n");//Nombre del producto
                        
					                        $printer->setJustification(Printer::JUSTIFY_RIGHT);
                        
					                        $printer->text("$ ".number_format($value["precio"],2)." Und x ".$value["cantidad"]." = $ ".number_format($value["total"],2)."\n");
                        
				                        }
                        
				                        $printer -> feed(1); //Alimentamos el papel 1 vez*/			
                        				
				                        $printer->text("NETO: $ ".number_format($_POST["nuevoPrecioNeto"],2)."\n"); //ahora va el neto
                        
				                        $printer->text("IMPUESTO: $ ".number_format($_POST["nuevoPrecioImpuesto"],2)."\n"); //ahora va el impuesto
										
										// Verificar si el descuento es mayor que cero
                                        if ($_POST["nuevodescuento"] > 0) {$printer->text("DESCUENTO: $ ".number_format($_POST["nuevoPrecioDescuento"],2)."\n");}

										$printer->text("--------\n");
                        
				                        $printer->text("TOTAL: $ ".number_format($_POST["totalVenta"],2)."\n"); //ahora va el total
                        
				                        $printer -> feed(1); //Alimentamos el papel 1 vez*/	
                        
				                        $printer->text("Muchas gracias por preferirnos"); //Podemos poner también un pie de página
                        
				                        $printer -> feed(3); //Alimentamos el papel 3 veces*/
                        
				                        $printer -> cut(); //Cortamos el papel, si la impresora tiene la opción
                        
				                        $printer -> pulse(); //Por medio de la impresora mandamos un pulso, es útil cuando hay cajón moneder
                        
				                        $printer -> close();
                        	
				                        echo'<script>
                        
				                        localStorage.removeItem("rango");
                        
				                        swal({
					                          type: "success",
					                          title: "La Cotizacion ha sido ejecutada correctamente",
					                          showConfirmButton: true,
					                          confirmButtonText: "Cerrar"
					                          }).then(function(result){
								                        if (result.value) {
                        
								                        window.location = "ventas";
                        
								                        }
							                        })
                        
				                        </script>';
			                     }

			elseif($valor!="42" || $metodo!="Cotizacion"){


			                    /*=============================================
			                    TRAER DATOS PARA LA VENTA REAL
                    			=============================================*/

			                       if($_POST["listaProductos"] == ""){
                       
					                       echo'<script>
                       
				                       swal({
					                         type: "error",
					                         title: "La venta no se ejecuta si no hay productos",
					                         showConfirmButton: true,
					                         confirmButtonText: "Cerrar"
					                         }).then(function(result){
								                       if (result.value) {
                       
								                       window.location = "ventas";
                       
								                       }
							                       })
                       
				                       </script>';
                       
				                       return;
                       			}


			
			                  $listaProductos = json_decode($_POST["listaProductos"], true);
                  
			                  $totalProductosComprados = array();
                  
			                    foreach ($listaProductos as $key => $value) {
                    
			                       array_push($totalProductosComprados, $value["cantidad"]);
                    				
			                       $tablaProductos = "productos";
                    
			                        $item = "id";
			                        $valor = $value["id"];
			                        $orden = "id";
                    
			                        $traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);
                    
				                    $item1a = "ventas";
				                    $valor1a = $value["cantidad"] + $traerProducto["ventas"];
                    
			                        $nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);
                    
				                    $item1b = "stock";
				                    $valor1b = $value["stock"];
                    
				                    $nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);
                    
			                    }
                  
			                  $tablaClientes = "clientes";
                  
			                  $item = "id";
			                  $valor = $_POST["seleccionarCliente"];

							  $traermesa = ControladorMesas::ctrMostrarMesas($itemmesa, $idmesa);
                  
			                  $traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $item, $valor);
                  
			                  $item1a = "compras";
                  				
			                  $valor1a = array_sum($totalProductosComprados) + $traerCliente["compras"];
                  
			                  $comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valor);
                  
			                  $item1b = "ultima_compra";
                  
			                  date_default_timezone_set('America/Bogota');
                  
			                  $fecha = date('Y-m-d');
			                  $hora = date('H:i:s');
			                  $valor1b = $fecha.' '.$hora;
                  
			                  $fechaCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1b, $valor1b, $valor);
                  
			                  /*=============================================
			                  GUARDAR LA COMPRA
			                  =============================================*/	
                  
			                  $tabla = "ventas";
                  
			                  $datos = array("id_vendedor"=>$_POST["idVendedor"],
						                     "id_cliente"=>$_POST["seleccionarCliente"],
						                     "codigo"=>$_POST["nuevaVenta"],
						                     "productos"=>$_POST["listaProductos"],
						                     "impuesto"=>$_POST["nuevoPrecioImpuesto"],
						                     "neto"=>$_POST["nuevoPrecioNeto"],
						                     "total"=>$_POST["totalVenta"],
						                     "metodo_pago"=>$_POST["listaMetodoPago"],
						                     "descuento"=>$_POST["nuevodescuento"],
											"idmesa"=>$_POST["seleccionarMesa"]);
                  
			                  $respuesta = ModeloVentas::mdlIngresarVenta($tabla, $datos);
                  
			                  // codigo de la venta real para asignarla a la factura
                  
			                  $tabla = "ventas";
                  
		                      $traercodigo = ModeloVentas::mdlMostrarCodigo($tabla);
                  
			                  $lastcodigo1 = $traercodigo["max_codigo"];
                  
			                  if($respuesta == "ok"){

								if($metodo=="Pendiente"){
									$cventa= $_POST["nuevaVenta"];
									// Cambiar el estado de la mesa a 1 (ocupado) y asignar codigo de venta
									ControladorMesas::ctrCambiarEstadoMesa($idmesa, 1, $cventa);
								 }

								if($metodo!="Pendiente"){
                  
                                   /*=============================================
			                       PRIMERA COPIA PARA EL CLIENTE
			                       =============================================*/
                  
				                  $impresora = "POS-80C";
                  
				                  $conector = new WindowsPrintConnector($impresora);
                  
				                  $printer = new Printer($conector);
                  
				                  $printer -> text(date("Y-m-d H:i:s")."\n");//Fecha de la factura
                  
				                  //$printer -> setJustification(Printer::JUSTIFY_CENTER);
                  
				                  $printer -> feed(1); //Alimentamos el papel 1 vez
                  
				                  $printer -> text("TRADICION MALL GASTRONOMICO"."\n");//Nombre de la empresa
                  
								  $printer -> text("NIT: 1.130.670.324-7"."\n");//Nit de la empresa
						
								  $printer -> text("Dirección: Calle 2 Crr 5-25 - zona centro"."\n");//Dirección de la empresa
						
								  $printer -> text("Teléfono: 323 488 5888"."\n");//Teléfono de la empresa
                  
				                  $printer -> text("FACTURA N.".$lastcodigo1."\n");//Número de factura
                  
				                  $printer -> feed(1); //Alimentamos el papel 1 vez
                  
				                  $printer -> text("Cliente: ".$traerCliente["nombre"]."\n");//Nombre del cliente
                  
				                  $printer -> text("Nit Cliente: ".$traerCliente["documento"]."\n");//Nit del cliente
                  
				                  $tablaVendedor = "usuarios";
				                  $item = "id";
				                  $valor = $_POST["idVendedor"];
                  
				                  $traerVendedor = ModeloUsuarios::mdlMostrarUsuarios($tablaVendedor, $item, $valor);
                  
				                  $printer -> text("Vendedor: ".$traerVendedor["nombre"]."\n");//Nombre del vendedor
                  
				                  $printer -> feed(1); //Alimentamos el papel 1 vez*/
                  
				                  foreach ($listaProductos as $key => $value) {
                  
					                  $printer->setJustification(Printer::JUSTIFY_LEFT);
                  
					                  $printer->text($value["descripcion"]."\n");//Nombre del producto
                  
					                  $printer->setJustification(Printer::JUSTIFY_RIGHT);
                  
					                  $printer->text("$ ".number_format($value["precio"],2)." Und x ".$value["cantidad"]." = $ ".number_format($value["total"],2)."\n");
                  
				                  }
                  
				                  $printer -> feed(1); //Alimentamos el papel 1 vez*/			
                  				
				                  $printer->text("NETO: $ ".number_format($_POST["nuevoPrecioNeto"],2)."\n"); //ahora va el neto
                  
				                  $printer->text("IMPUESTO: $ ".number_format($_POST["nuevoPrecioImpuesto"],2)."\n"); //ahora va el impuesto
                                  
								  // Verificar si el descuento es mayor que cero
								  //if ($_POST["nuevodescuento"] > 0) {$printer->text("DESCUENTO: $ ".number_format($_POST["nuevoPrecioDescuento"],2)."\n");}
				                  $totalwithoutd=$_POST["nuevodescuento"]+$_POST["totalVenta"];

								  $printer->text("--------\n");
                  
				                  $printer->text("TOTAL: $ ".number_format($totalwithoutd,2)."\n"); //ahora va el total
                  
				                  $printer -> feed(1); //Alimentamos el papel 1 vez*/	
                  
				                  $printer->text("Muchas gracias por su compra"); //Podemos poner también un pie de página
                  
				                  $printer -> feed(3); //Alimentamos el papel 3 veces*/
                  
				                  $printer -> cut(); //Cortamos el papel, si la impresora tiene la opción
                  
				                  $printer -> pulse(); //Por medio de la impresora mandamos un pulso, es útil cuando hay cajón moneder
                  
				                  $printer -> close();
                  
				                           /*=============================================
			                                SEGUNDA COPIA PARA EL ALMACEN CON DESCUENTO
			                                =============================================*/
                  				
				                  $impresora = "POS-80C";
                  
				                  $conector = new WindowsPrintConnector($impresora);
                  
				                  $printer = new Printer($conector);
                  
				                  $printer -> text(date("Y-m-d H:i:s")."\n");//Fecha de la factura
                  
				                  //$printer -> setJustification(Printer::JUSTIFY_CENTER);
                  
				                  $printer -> feed(1); //Alimentamos el papel 1 vez
                  
				                  $printer -> text("TRADICION MALL GASTRONOMICO"."\n");//Nombre de la empresa
                  
				                  $printer -> text("NIT: 1.130.670.324-7"."\n");//Nit de la empresa
                  
				                  $printer -> text("Dirección: Calle 2 Crr 5-25 - zona centro"."\n");//Dirección de la empresa
                  
				                  $printer -> text("Teléfono: 323 488 5888"."\n");//Teléfono de la empresa
                  
				                  $printer -> text("FACTURA N.".$lastcodigo1."\n");//Número de factura
                  
				                  $printer -> feed(1); //Alimentamos el papel 1 vez

								  // Condición para imprimir el mensaje de descuento si existe

								  $tablaVendedor = "usuarios";
				                  $item = "id";
				                  $valor = $_POST["idVendedor"];
                  
				                  $traerVendedor = ModeloUsuarios::mdlMostrarUsuarios($tablaVendedor, $item, $valor);

								  if ($_POST["nuevodescuento"] > 0) {
                  
				                       $printer -> text("Cliente: ".$traerCliente["nombre"]             ."******************************\n");//Nombre del cliente
                       
				                       $printer -> text("Nit Cliente: ".$traerCliente["documento"]       ."* ¡DESCUENTO APLICADO! (*.*)*\n");//Nit del cliente
                       
								       $printer -> text("Vendedor: ".$traerVendedor["nombre"]            ."******************************\n");//Nombre del vendedor
     								  
								  } else {

                                      // Imprimir normalmente sin el mensaje de descuento
                                      $printer->text("Cliente: ".$traerCliente["nombre"]."\n");

                                      $printer->text("Nit Cliente: ".$traerCliente["documento"]."\n");

                                      $printer->text("Vendedor: ".$traerVendedor["nombre"]."\n");
                                 }
                  
				                  $printer -> feed(1); //Alimentamos el papel 1 vez*/
                  
				                  foreach ($listaProductos as $key => $value) {
                  
					                  $printer->setJustification(Printer::JUSTIFY_LEFT);
                  
					                  $printer->text($value["descripcion"]."\n");//Nombre del producto
                  
					                  $printer->setJustification(Printer::JUSTIFY_RIGHT);
                  
					                  $printer->text("$ ".number_format($value["precio"],2)." Und x ".$value["cantidad"]." = $ ".number_format($value["total"],2)."\n");
                  
				                  }
                  
				                  $printer -> feed(1); //Alimentamos el papel 1 vez*/			
                  				
				                  $printer->text("NETO: $ ".number_format($_POST["nuevoPrecioNeto"],2)."\n"); //ahora va el neto
                  
				                  $printer->text("IMPUESTO: $ ".number_format($_POST["nuevoPrecioImpuesto"],2)."\n"); //ahora va el impuesto
                                 
								  // Verificar si el descuento es mayor que cero
				                  if ($_POST["nuevodescuento"] > 0) {$printer->text("DESCUENTO: $ ".number_format($_POST["nuevodescuento"],2)."\n");}
				                  
								  $printer->text("--------\n");
                  
				                  $printer->text("TOTAL: $ ".number_format($_POST["totalVenta"],2)."\n"); //ahora va el total
                  
				                  $printer -> feed(1); //Alimentamos el papel 1 vez*/	
                  
				                  $printer->text("Muchas gracias por su compra"); //Podemos poner también un pie de página
                  
				                  $printer -> feed(3); //Alimentamos el papel 3 veces*/
                  
				                  $printer -> cut(); //Cortamos el papel, si la impresora tiene la opción
                  
				                  $printer -> pulse(); //Por medio de la impresora mandamos un pulso, es útil cuando hay cajón moneder
                  
				                  $printer -> close();

								           /*=============================================
			                                TERCERA COPIA PARA EL CHEF
			                                =============================================*/

									//UNICA COPIA PARA EL CHEF
									$nombreMesa = ($traermesa && isset($traermesa["nombre"])) ? $traermesa["nombre"] : "0";
                        				
									$impresora = "POS-80C";
                        
									$conector = new WindowsPrintConnector($impresora);
					
									$printer = new Printer($conector);
					
									$printer -> text(date("Y-m-d H:i:s")."\n" ."PEDIDO"."* ¡CHEF! (*.*)*\n");//Fecha de la factura
					
									//$printer -> setJustification(Printer::JUSTIFY_CENTER);
					
									$printer -> feed(1); //Alimentamos el papel 1 vez

									$printer -> text("FACTURA N.".$traercodigo["max_codigo"]."\n");//Número de factura
					
									$printer -> feed(1); //Alimentamos el papel 1 vez

									$printer -> text("MESA N." . $nombreMesa . "\n");//Número de factura
					
									$printer -> text("Cliente: ".$traerCliente["nombre"]."\n");//Nombre del cliente
					
									$tablaVendedor = "usuarios";
									$item = "id";
									$valor = $_POST["idVendedor"];
					
									$traerVendedor = ModeloUsuarios::mdlMostrarUsuarios($tablaVendedor, $item, $valor);
					
									$printer -> text("ATENDIDO POR: ".$traerVendedor["nombre"]."\n");//Nombre del vendedor
					
									$printer -> feed(1); //Alimentamos el papel 1 vez*/
					
									foreach ($listaProductos as $key => $value) {
					
										$printer->setJustification(Printer::JUSTIFY_LEFT);
					
										$printer->text($value["descripcion"]."\n");//Nombre del producto
					
										$printer->setJustification(Printer::JUSTIFY_RIGHT);
					
										$printer->text("$ ".number_format($value["precio"],2)." Und x ".$value["cantidad"]." = $ ".number_format($value["total"],2)."\n");
					
									}
				
									$printer -> feed(3); //Alimentamos el papel 3 veces*/
					
									$printer -> cut(); //Cortamos el papel, si la impresora tiene la opción
					
									$printer -> pulse(); //Por medio de la impresora mandamos un pulso, es útil cuando hay cajón moneder
					
									$printer -> close();
                  	
				                  echo'<script>
                  
				                  localStorage.removeItem("rango");
                  
				                  swal({
					                    type: "success",
					                    title: "La venta ha sido guardada correctamente",
					                    showConfirmButton: true,
					                    confirmButtonText: "Cerrar"
					                    }).then(function(result){
								                  if (result.value) {
                  
								                  window.location = "ventas";
                  
								                  }
							                  })
                  
				                  </script>';
                  
								} else {

									// imprimir ticket para el chet 

									//UNICA COPIA PARA EL CHEF
                        				
									$impresora = "POS-80C";
                        
									$conector = new WindowsPrintConnector($impresora);
					
									$printer = new Printer($conector);
					
									$printer -> text(date("Y-m-d H:i:s")."\n" ."PEDIDO"."* ¡CHEF! (*.*)*\n");//Fecha de la factura
					
									//$printer -> setJustification(Printer::JUSTIFY_CENTER);
					
									$printer -> feed(1); //Alimentamos el papel 1 vez

									$printer -> text("FACTURA N.".$traercodigo["max_codigo"]."\n");//Número de factura
					
									$printer -> feed(1); //Alimentamos el papel 1 vez

									$printer -> text("MESA N.".$traermesa["nombre"]."\n");//Número de factura
					
									$printer -> text("Cliente: ".$traerCliente["nombre"]."\n");//Nombre del cliente
					
									$tablaVendedor = "usuarios";
									$item = "id";
									$valor = $_POST["idVendedor"];
					
									$traerVendedor = ModeloUsuarios::mdlMostrarUsuarios($tablaVendedor, $item, $valor);
					
									$printer -> text("ATENDIDO POR: ".$traerVendedor["nombre"]."\n");//Nombre del vendedor
					
									$printer -> feed(1); //Alimentamos el papel 1 vez*/
					
									foreach ($listaProductos as $key => $value) {
					
										$printer->setJustification(Printer::JUSTIFY_LEFT);
					
										$printer->text($value["descripcion"]."\n");//Nombre del producto
					
										$printer->setJustification(Printer::JUSTIFY_RIGHT);
					
										$printer->text("$ ".number_format($value["precio"],2)." Und x ".$value["cantidad"]." = $ ".number_format($value["total"],2)."\n");
					
									}
				
									$printer -> feed(3); //Alimentamos el papel 3 veces*/
					
									$printer -> cut(); //Cortamos el papel, si la impresora tiene la opción
					
									$printer -> pulse(); //Por medio de la impresora mandamos un pulso, es útil cuando hay cajón moneder
					
									$printer -> close();

									echo'<script>
                  
				                  localStorage.removeItem("rango");
                  
				                  swal({
					                    type: "success",
					                    title: "La mesa fue ocupada, La venta esta pendiente de pago",
					                    showConfirmButton: true,
					                    confirmButtonText: "Cerrar"
					                    }).then(function(result){
								                  if (result.value) {
                  
								                  window.location = "ventas";
                  
								                  }
							                  })
                  
				                  </script>'; 
								}
								
							}

		  }
	    }

	}

	/*=============================================
	EDITAR VENTA
	=============================================*/

	static public function ctrEditarVenta(){

		if(isset($_POST["editarVenta"])){

			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
			=============================================*/
			$tabla = "ventas";

			$item = "codigo";
			$valor = $_POST["editarVenta"];
			$metodo =$_POST["listaMetodoPago"];
			$codigo =$_POST["editarVenta"];
			$idmesa=$_POST["seleccionarMesa"];
			$antiguamesa= $_POST["idMesaAntigua"];
			$itemmesa = "id";

			$traermesa = ControladorMesas::ctrMostrarMesas($itemmesa, $idmesa);

			$traerVenta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

			/*=============================================
			REVISAR SI VIENE PRODUCTOS EDITADOS
			=============================================*/

			if($_POST["listaProductos"] == ""){

				$listaProductos = $traerVenta["productos"];
				$cambioProducto = false;


			}else{

				$listaProductos = $_POST["listaProductos"];
				$cambioProducto = true;
			}

			if($cambioProducto){

				$productos =  json_decode($traerVenta["productos"], true);

				$totalProductosComprados = array();

				foreach ($productos as $key => $value) {

					array_push($totalProductosComprados, $value["cantidad"]);
					
					$tablaProductos = "productos";

					$item = "id";
					$valor = $value["id"];
					$orden = "id";

					$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);

					$item1a = "ventas";
					$valor1a = $traerProducto["ventas"] - $value["cantidad"];

					$nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);

					$item1b = "stock";
					$valor1b = $value["cantidad"] + $traerProducto["stock"];

					$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);

				}

				$tablaClientes = "clientes";

				$itemCliente = "id";
				$valorCliente = $_POST["seleccionarCliente"];

				$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $itemCliente, $valorCliente);

				$item1a = "compras";
				$valor1a = $traerCliente["compras"] - array_sum($totalProductosComprados);		

				$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valorCliente);

				/*=============================================
				ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
				=============================================*/

				$listaProductos_2 = json_decode($listaProductos, true);

				$totalProductosComprados_2 = array();

				foreach ($listaProductos_2 as $key => $value) {

					array_push($totalProductosComprados_2, $value["cantidad"]);
					
					$tablaProductos_2 = "productos";

					$item_2 = "id";
					$valor_2 = $value["id"];
					$orden = "id";

					$traerProducto_2 = ModeloProductos::mdlMostrarProductos($tablaProductos_2, $item_2, $valor_2, $orden);

					$item1a_2 = "ventas";
					$valor1a_2 = $value["cantidad"] + $traerProducto_2["ventas"];

					$nuevasVentas_2 = ModeloProductos::mdlActualizarProducto($tablaProductos_2, $item1a_2, $valor1a_2, $valor_2);

					$item1b_2 = "stock";
					$valor1b_2 = $value["stock"];

					$nuevoStock_2 = ModeloProductos::mdlActualizarProducto($tablaProductos_2, $item1b_2, $valor1b_2, $valor_2);

				}

				$tablaClientes_2 = "clientes";

				$item_2 = "id";
				$valor_2 = $_POST["seleccionarCliente"];

				$traerCliente_2 = ModeloClientes::mdlMostrarClientes($tablaClientes_2, $item_2, $valor_2);

				$item1a_2 = "compras";

				$valor1a_2 = array_sum($totalProductosComprados_2) + $traerCliente_2["compras"];

				$comprasCliente_2 = ModeloClientes::mdlActualizarCliente($tablaClientes_2, $item1a_2, $valor1a_2, $valor_2);

				$item1b_2 = "ultima_compra";

				date_default_timezone_set('America/Bogota');

				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$valor1b_2 = $fecha.' '.$hora;

				$fechaCliente_2 = ModeloClientes::mdlActualizarCliente($tablaClientes_2, $item1b_2, $valor1b_2, $valor_2);

			}

			/*=============================================
			GUARDAR CAMBIOS DE LA COMPRA
			=============================================*/	

			$datos = array("id_vendedor"=>$_POST["idVendedor"],
						   "id_cliente"=>$_POST["seleccionarCliente"],
						   "codigo"=>$_POST["editarVenta"],
						   "productos"=>$listaProductos,
						   "impuesto"=>$_POST["nuevoPrecioImpuesto"],
						   "neto"=>$_POST["nuevoPrecioNeto"],
						   "total"=>$_POST["totalVenta"],
						   "metodo_pago"=>$_POST["listaMetodoPago"],
						   "descuento"=>$_POST["nuevodescuento"],
						   "idmesa"=>$_POST["seleccionarMesa"]);


			$respuesta = ModeloVentas::mdlEditarVenta($tabla, $datos);
			$cventa= $codigo;
			if($respuesta == "ok"){
                 
				// Verificar si el método de pago es "Pendiente"
				if($metodo=="Pendiente"){

					// Si la mesa ha cambiado, actualizar los estados de ambas mesas
					if($idmesa!=$antiguamesa){
						
						// Asignar el estado de ocupada (1) a la nueva mesa y asignar el código de venta
						ControladorMesas::ctrCambiarEstadoMesa($idmesa, 1, $cventa);

						// Cambiar el estado de la antigua mesa a 0 (desocupada) y quitar codigo de venta
						ControladorMesas::ctrCambiarEstadoMesa($antiguamesa, 0, 0);
					 
					}else {
                          // Cambiar el estado de la mesa a 1 (ocupado) y asignar codigo de venta
					ControladorMesas::ctrCambiarEstadoMesa($idmesa, 1, $cventa);
					}

					                        /*=============================================
			                                TERCERA COPIA PARA EL CHEF
			                                =============================================*/

									//UNICA COPIA PARA EL CHEF
                        				
									$impresora = "POS-80C";
                        
									$conector = new WindowsPrintConnector($impresora);
					
									$printer = new Printer($conector);
					
									$printer -> text(date("Y-m-d H:i:s")."\n" ."PEDIDO"."* ¡CHEF! (*.*)*\n");//Fecha de la factura
					
									//$printer -> setJustification(Printer::JUSTIFY_CENTER);
					
									$printer -> feed(1); //Alimentamos el papel 1 vez

									$printer -> text("FACTURA N.".$codigo."\n");//Número de factura
					
									$printer -> feed(1); //Alimentamos el papel 1 vez

									$printer -> text("MESA N.".$traermesa["nombre"]."\n");//Número de factura

									// Información del cliente
									$traerCliente = ModeloClientes::mdlMostrarClientes("clientes", "id", $datos['id_cliente']);
					
									$printer -> text("Cliente: ".$traerCliente["nombre"]."\n");//Nombre del cliente
					
									$tablaVendedor = "usuarios";
									$item = "id";
									$valor = $_POST["idVendedor"];
					
									$traerVendedor = ModeloUsuarios::mdlMostrarUsuarios($tablaVendedor, $item, $valor);
					
									$printer -> text("ATENDIDO POR: ".$traerVendedor["nombre"]."\n");//Nombre del vendedor
					
									$printer -> feed(1); //Alimentamos el papel 1 vez*/

									$listaProductos = json_decode($datos['productos'], true); // Convierte JSON a un array asociativo
					
									foreach ($listaProductos as $key => $value) {
					
										$printer->setJustification(Printer::JUSTIFY_LEFT);
					
										$printer->text($value["descripcion"]."\n");//Nombre del producto
					
										$printer->setJustification(Printer::JUSTIFY_RIGHT);
					
										$printer->text("$ ".number_format($value["precio"],2)." Und x ".$value["cantidad"]." = $ ".number_format($value["total"],2)."\n");
					
									}
				
									$printer -> feed(3); //Alimentamos el papel 3 veces*/
					
									$printer -> cut(); //Cortamos el papel, si la impresora tiene la opción
					
									$printer -> pulse(); //Por medio de la impresora mandamos un pulso, es útil cuando hay cajón moneder
					
									$printer -> close();

                        //   mensaje al agregar otro producto y continua en pendiente
					   echo'<script>
                  
				                  localStorage.removeItem("rango");
                  
				                  swal({
					                    type: "success",
					                    title: "Mesa ocupada, La venta esta pendiente de pago",
					                    showConfirmButton: true,
					                    confirmButtonText: "Cerrar"
					                    }).then(function(result){
								                  if (result.value) {
                  
								                  window.location = "ventas";
                  
								                  }
							                  })
                  
				                  </script>';

								//   imprimir ticket para chef

					} else { // Si el método no es "Pendiente"
					
					         if($idmesa != $antiguamesa){
						
						         // Cambiar el estado de la mesa a 0 (ocupado) y asignar codigo de venta 0
						         ControladorMesas::ctrCambiarEstadoMesa($idmesa, 0, 0);

						          // Cambiar el estado de la antigua mesa a 0 (desocupada) y quitar codigo de venta
						         ControladorMesas::ctrCambiarEstadoMesa($antiguamesa, 0, 0);

					            } else {
					            	ControladorMesas::ctrCambiarEstadoMesa($idmesa, 0, 0);
					             }
                    
								 //   mensaje al agregar otro producto y finaliza

								 // Preguntar si se desea imprimir el ticket cuando el método de pago es diferente a "Pendiente"
								   
								 /*=============================================
			                       PRIMERA COPIA PARA EL CLIENTE
			                       =============================================*/
                  
								   $impresora = "POS-80C";
                  
								   $conector = new WindowsPrintConnector($impresora);
				   
								   $printer = new Printer($conector);
				   
								   $printer -> text(date("Y-m-d H:i:s")."\n");//Fecha de la factura
				   
								   //$printer -> setJustification(Printer::JUSTIFY_CENTER);
				   
								   $printer -> feed(1); //Alimentamos el papel 1 vez
				   
								   $printer -> text("TRADICION MALL GASTRONOMICO"."\n");//Nombre de la empresa
                  
				                  $printer -> text("NIT: 130.670.324-7"."\n");//Nit de la empresa
                  
				                  $printer -> text("Dirección: Calle 2 Crr 5-25 - zona centro"."\n");//Dirección de la empresa
                  
				                  $printer -> text("Teléfono: 323 488 5888"."\n");//Teléfono de la empresa
				   
								   $printer -> text("FACTURA N.".$codigo."\n");//Número de factura
				   
								   $printer -> feed(1); //Alimentamos el papel 1 vez

								    // Información del cliente
                                   $traerCliente = ModeloClientes::mdlMostrarClientes("clientes", "id", $datos['id_cliente']);
				   
								   $printer -> text("Cliente: ".$traerCliente["nombre"]."\n");//Nombre del cliente
				   
								   $printer -> text("Nit Cliente: ".$traerCliente["documento"]."\n");//Nit del cliente
				   
								   $tablaVendedor = "usuarios";
								   $item = "id";
								   $valor = $_POST["idVendedor"];
				   
								   $traerVendedor = ModeloUsuarios::mdlMostrarUsuarios($tablaVendedor, $item, $valor);
				   
								   $printer -> text("Vendedor: ".$traerVendedor["nombre"]."\n");//Nombre del vendedor
				   
								   $printer -> feed(1); //Alimentamos el papel 1 vez*/
								   
								   $listaProductos = json_decode($datos['productos'], true); // Convierte JSON a un array asociativo
				   
								   foreach ($listaProductos as $key => $value) {
				   
									   $printer->setJustification(Printer::JUSTIFY_LEFT);
				   
									   $printer->text($value["descripcion"]."\n");//Nombre del producto
				   
									   $printer->setJustification(Printer::JUSTIFY_RIGHT);
				   
									   $printer->text("$ ".number_format($value["precio"],2)." Und x ".$value["cantidad"]." = $ ".number_format($value["total"],2)."\n");
				   
								   }
				   
								   $printer -> feed(1); //Alimentamos el papel 1 vez*/			
								   
								   $printer->text("NETO: $ ".number_format($_POST["nuevoPrecioNeto"],2)."\n"); //ahora va el neto
				   
								   $printer->text("IMPUESTO: $ ".number_format($_POST["nuevoPrecioImpuesto"],2)."\n"); //ahora va el impuesto
								   
								   // Verificar si el descuento es mayor que cero
								   //if ($_POST["nuevodescuento"] > 0) {$printer->text("DESCUENTO: $ ".number_format($_POST["nuevoPrecioDescuento"],2)."\n");}
								   $totalwithoutd=$_POST["nuevodescuento"]+$_POST["totalVenta"];
 
								   $printer->text("--------\n");
				   
								   $printer->text("TOTAL: $ ".number_format($totalwithoutd,2)."\n"); //ahora va el total
				   
								   $printer -> feed(1); //Alimentamos el papel 1 vez*/	
				   
								   $printer->text("Muchas gracias por su compra"); //Podemos poner también un pie de página
				   
								   $printer -> feed(3); //Alimentamos el papel 3 veces*/
				   
								   $printer -> cut(); //Cortamos el papel, si la impresora tiene la opción
				   
								   $printer -> pulse(); //Por medio de la impresora mandamos un pulso, es útil cuando hay cajón moneder
				   
								   $printer -> close();
				   
											/*=============================================
											 SEGUNDA COPIA PARA EL ALMACEN CON DESCUENTO
											 =============================================*/
								   
								   $impresora = "POS-80C";
				   
								   $conector = new WindowsPrintConnector($impresora);
				   
								   $printer = new Printer($conector);
				   
								   $printer -> text(date("Y-m-d H:i:s")."\n");//Fecha de la factura
				   
								   //$printer -> setJustification(Printer::JUSTIFY_CENTER);
				   
								   $printer -> feed(1); //Alimentamos el papel 1 vez
				   
								   $printer -> text("TRADICION MALL GASTRONOMICO"."\n");//Nombre de la empresa
                  
				                  $printer -> text("NIT: 130.670.324-7"."\n");//Nit de la empresa
                  
				                  $printer -> text("Dirección: Calle 2 Crr 5-25 - zona centro"."\n");//Dirección de la empresa
                  
				                  $printer -> text("Teléfono: 323 488 5888"."\n");//Teléfono de la empresa
				   
								   $printer -> text("FACTURA N.".$codigo."\n");//Número de factura
				   
								   $printer -> feed(1); //Alimentamos el papel 1 vez
 
								   // Condición para imprimir el mensaje de descuento si existe

								   $traerCliente = ModeloClientes::mdlMostrarClientes("clientes", "id", $datos['id_cliente']);
 
								   $tablaVendedor = "usuarios";
								   $item = "id";
								   $valor = $_POST["idVendedor"];
				   
								   $traerVendedor = ModeloUsuarios::mdlMostrarUsuarios($tablaVendedor, $item, $valor);
 
								   if ($_POST["nuevodescuento"] > 0) {
				   
										$printer -> text("Cliente: ".$traerCliente["nombre"]             ."******************************\n");//Nombre del cliente
						
										$printer -> text("Nit Cliente: ".$traerCliente["documento"]       ."* ¡DESCUENTO APLICADO! (*.*)*\n");//Nit del cliente
						
										$printer -> text("Vendedor: ".$traerVendedor["nombre"]            ."******************************\n");//Nombre del vendedor
										
								   } else {
 
									   // Imprimir normalmente sin el mensaje de descuento
									   $printer->text("Cliente: ".$traerCliente["nombre"]."\n");
 
									   $printer->text("Nit Cliente: ".$traerCliente["documento"]."\n");
 
									   $printer->text("Vendedor: ".$traerVendedor["nombre"]."\n");
								  }
				   
								   $printer -> feed(1); //Alimentamos el papel 1 vez*/

								   $listaProductos = json_decode($datos['productos'], true); // Convierte JSON a un array asociativo
				   
								   foreach ($listaProductos as $key => $value) {
				   
									   $printer->setJustification(Printer::JUSTIFY_LEFT);
				   
									   $printer->text($value["descripcion"]."\n");//Nombre del producto
				   
									   $printer->setJustification(Printer::JUSTIFY_RIGHT);
				   
									   $printer->text("$ ".number_format($value["precio"],2)." Und x ".$value["cantidad"]." = $ ".number_format($value["total"],2)."\n");
				   
								   }
				   
								   $printer -> feed(1); //Alimentamos el papel 1 vez*/			
								   
								   $printer->text("NETO: $ ".number_format($_POST["nuevoPrecioNeto"],2)."\n"); //ahora va el neto
				   
								   $printer->text("IMPUESTO: $ ".number_format($_POST["nuevoPrecioImpuesto"],2)."\n"); //ahora va el impuesto
								  
								   // Verificar si el descuento es mayor que cero
								   if ($_POST["nuevodescuento"] > 0) {$printer->text("DESCUENTO: $ ".number_format($_POST["nuevodescuento"],2)."\n");}
								   
								   $printer->text("--------\n");
				   
								   $printer->text("TOTAL: $ ".number_format($_POST["totalVenta"],2)."\n"); //ahora va el total
				   
								   $printer -> feed(1); //Alimentamos el papel 1 vez*/	
				   
								   $printer->text("Muchas gracias por su compra"); //Podemos poner también un pie de página
				   
								   $printer -> feed(3); //Alimentamos el papel 3 veces*/
				   
								   $printer -> cut(); //Cortamos el papel, si la impresora tiene la opción
				   
								   $printer -> pulse(); //Por medio de la impresora mandamos un pulso, es útil cuando hay cajón moneder
				   
								   $printer -> close();

								 echo'<script>

				                      localStorage.removeItem("rango");
                      
				                      swal({
				                      	  type: "success",
				                      	  title: "La venta ha sido editada y finalizada correctamente",
				                      	  showConfirmButton: true,
				                      	  confirmButtonText: "Cerrar"
				                      	  }).then((result) => {
				                      				if (result.value) {
                      
				                      				window.location = "ventas";

				                      				}
				                      			})

				                      </script>';
				   }


			}

		}

	}


	/*=============================================
	ELIMINAR VENTA
	=============================================*/

	static public function ctrEliminarVenta(){

		if(isset($_GET["idEliminarVenta"])){

			$tabla = "ventas";

			$item = "id";
			$valor = $_GET["idEliminarVenta"];

			$traerVenta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

			$idmesa = $traerVenta["idmesa"];

			/*=============================================
			ACTUALIZAR FECHA ÚLTIMA COMPRA
			=============================================*/

			$tablaClientes = "clientes";

			$itemVentas = null;
			$valorVentas = null;

			$traerVentas = ModeloVentas::mdlMostrarVentas($tabla, $itemVentas, $valorVentas);

			$guardarFechas = array();

			foreach ($traerVentas as $key => $value) {
				
				if($value["id_cliente"] == $traerVenta["id_cliente"]){

					array_push($guardarFechas, $value["fecha"]);

				}

			}

			if(count($guardarFechas) > 1){

				if($traerVenta["fecha"] > $guardarFechas[count($guardarFechas)-2]){

					$item = "ultima_compra";
					$valor = $guardarFechas[count($guardarFechas)-2];
					$valorIdCliente = $traerVenta["id_cliente"];

					$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorIdCliente);

				}else{

					$item = "ultima_compra";
					$valor = $guardarFechas[count($guardarFechas)-1];
					$valorIdCliente = $traerVenta["id_cliente"];

					$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorIdCliente);

				}


			}else{

				$item = "ultima_compra";
				$valor = "0000-00-00 00:00:00";
				$valorIdCliente = $traerVenta["id_cliente"];

				$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorIdCliente);

			}

			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
			=============================================*/

			$productos =  json_decode($traerVenta["productos"], true);

			$totalProductosComprados = array();

			foreach ($productos as $key => $value) {

				array_push($totalProductosComprados, $value["cantidad"]);
				
				$tablaProductos = "productos";

				$item = "id";
				$valor = $value["id"];
				$orden = "id";

				$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);

				$item1a = "ventas";
				$valor1a = $traerProducto["ventas"] - $value["cantidad"];

				$nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);

				$item1b = "stock";
				$valor1b = $value["cantidad"] + $traerProducto["stock"];

				$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);

			}

			$tablaClientes = "clientes";

			$itemCliente = "id";
			$valorCliente = $traerVenta["id_cliente"];

			$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $itemCliente, $valorCliente);

			$item1a = "compras";
			$valor1a = $traerCliente["compras"] - array_sum($totalProductosComprados);

			$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valorCliente);

			/*=============================================
			ELIMINAR VENTA
			=============================================*/

			$respuesta = ModeloVentas::mdlEliminarVenta($tabla, $_GET["idEliminarVenta"]);

			if($respuesta == "ok"){

				// Cambiar el estado de la mesa a 0 (ocupado) y asignar codigo de venta 0
				ControladorMesas::ctrCambiarEstadoMesa($idmesa, 0, 0);

				echo'<script>

				swal({
					  type: "success",
					  title: "La venta ha sido borrada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "ventas";

								}
							})

				</script>';

			}		
		}

	}

	/*=============================================
	RANGO FECHAS MOSTRAR VENTAS TABLA
	=============================================*/	

	static public function ctrRangoFechasVentas($fechaInicial, $fechaFinal){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}

   /*=============================================
	RANGO FECHAS MOSTRAR VENTAS CREDITOS TABLA
	=============================================*/	

	static public function ctrVentasCreditos(){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlVentasCreditos($tabla);

		return $respuesta;
		
	}

		/*=============================================
	RANGO FECHAS REPORTE DE FECHAS
	=============================================*/	

	static public function ctrRangoFechasVentas2($fechaInicial, $fechaFinal){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlRangoFechasVentas2($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}

	/*=============================================
	REPORTE PRINCIPAL PARA EL GRAFICO SUMA EFECTIVO Y NEQUI
	=============================================*/	

	static public function ctrRangoF(){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlRangoF($tabla);

		return $respuesta;
		
	}

	
	/*=============================================
	REPORTE FINAL PARA EL GRAFICO SUMA EFECTIVO, CREDITO, NEQUI
	=============================================*/	

	static public function ctrRangoFF(){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlRangoFF($tabla);

		return $respuesta;
		
	}
	
    /*=============================================
	REPORTE FINAL CAJA SUPERIOR VENTAS EFECTIVOS POR FECHA
	=============================================*/	

	static public function ctrRangoventasf($fechaInicial, $fechaFinal){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlRangoventasf($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}

	  /*=============================================
	REPORTE MESAS
	=============================================*/	

	static public function ctrmesas($idmesa){

		 // Define los nombres de las tablas
		 $tablaVentas = "ventas";
		 $tablaMesas = "mesas";

		// Llama al modelo con ambas tablas
		$respuesta = ModeloVentas::mdlmesas($tablaVentas, $tablaMesas, $idmesa);

		return $respuesta;
		
	}


	/*=============================================
	REPORTE FINAL CAJA SUPERIOR VENTAS CREDITOS POR FECHA
	=============================================*/	

	static public function ctrRangocreditof($fechaInicial, $fechaFinal){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlRangocreditof($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}

	/*=============================================
	REPORTE FINAL CAJA SUPERIOR VENTAS CREDITOS POR FECHA ABONADO
	=============================================*/	

	static public function ctrRangocreditofabonado($fechaInicial, $fechaFinal){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlRangocreditofabonado($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}

	/*=============================================
	REPORTE FINAL CAJA SUPERIOR VENTAS NEQUI POR FECHA
	=============================================*/	

	static public function ctrRangonequif($fechaInicial, $fechaFinal){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlRangonequif($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}
	/*=============================================
	DESCARGAR EXCEL
	=============================================*/

	public function ctrDescargarReporte(){

		if(isset($_GET["reporte"])){

			$tabla = "ventas";

			if(isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])){

				$ventas = ModeloVentas::mdlRangoFechasVentas($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);

			}else{

				$item = null;
				$valor = null;

				$ventas = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

			}


			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/

			$Name = $_GET["reporte"].'.xls';

			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$Name.'"');
			header("Content-Transfer-Encoding: binary");
		
			echo utf8_decode("<table border='0'> 

					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>CÓDIGO</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>CLIENTE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>VENDEDOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PRODUCTOS</td>
					<td style='font-weight:bold; border:1px solid #eee;'>IMPUESTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NETO</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>METODO DE PAGO</td	
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
					</tr>");

			foreach ($ventas as $row => $item){

				$cliente = ControladorClientes::ctrMostrarClientes("id", $item["id_cliente"]);
				$vendedor = ControladorUsuarios::ctrMostrarUsuarios("id", $item["id_vendedor"]);

			 echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>".$item["codigo"]."</td> 
			 			<td style='border:1px solid #eee;'>".$cliente["nombre"]."</td>
			 			<td style='border:1px solid #eee;'>".$vendedor["nombre"]."</td>
			 			<td style='border:1px solid #eee;'>");

			 	$productos =  json_decode($item["productos"], true);

			 	foreach ($productos as $key => $valueProductos) {
			 			
			 			echo utf8_decode($valueProductos["cantidad"]."<br>");
			 		}

			 	echo utf8_decode("</td><td style='border:1px solid #eee;'>");	

		 		foreach ($productos as $key => $valueProductos) {
			 			
		 			echo utf8_decode($valueProductos["descripcion"]."<br>");
		 		
		 		}

		 		echo utf8_decode("</td>
					<td style='border:1px solid #eee;'>$ ".number_format($item["impuesto"],2)."</td>
					<td style='border:1px solid #eee;'>$ ".number_format($item["neto"],2)."</td>	
					<td style='border:1px solid #eee;'>$ ".number_format($item["total"],2)."</td>
					<td style='border:1px solid #eee;'>".$item["metodo_pago"]."</td>
					<td style='border:1px solid #eee;'>".substr($item["fecha"],0,10)."</td>		
		 			</tr>");


			}


			echo "</table>";

		}

	}


	/*=============================================
	SUMA TOTAL VENTAS EN GENERAL USADO POR EL REPORTE FINAL
	=============================================*/

	static public function ctrSumaTotalVentas(){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlSumaTotalVentas($tabla);

		return $respuesta;

	}

	/*=============================================
	SUMA TOTAL CREDITOS
	=============================================*/

	static public function ctrSumaTotalCreditos(){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlSumaTotalCreditos($tabla);

		return $respuesta;

	}

	/*=============================================
	SUMA TOTAL CREDITOS ABONADOS
	=============================================*/

	static public function ctrSumaTotalCreditosab(){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlSumaTotalCreditosab($tabla);

		return $respuesta;

	}

	/*=============================================
	SUMA TOTAL NEQUI
	=============================================*/

	static public function ctrSumaTotalNequi(){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlSumaTotalNequi($tabla);

		return $respuesta;

	}
	
	/*=============================================
	DESCARGAR XML
	=============================================*/

	static public function ctrDescargarXML(){

		if(isset($_GET["xml"])){


			$tabla = "ventas";
			$item = "codigo";
			$valor = $_GET["xml"];

			$ventas = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

			// PRODUCTOS

			$listaProductos = json_decode($ventas["productos"], true);

			// CLIENTE

			$tablaClientes = "clientes";
			$item = "id";
			$valor = $ventas["id_cliente"];

			$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $item, $valor);

			// VENDEDOR

			$tablaVendedor = "usuarios";
			$item = "id";
			$valor = $ventas["id_vendedor"];

			$traerVendedor = ModeloUsuarios::mdlMostrarUsuarios($tablaVendedor, $item, $valor);

			//http://php.net/manual/es/book.xmlwriter.php

			$objetoXML = new XMLWriter();

			$objetoXML->openURI($_GET["xml"].".xml"); //Creación del archivo XML

			$objetoXML->setIndent(true); //recibe un valor booleano para establecer si los distintos niveles de nodos XML deben quedar indentados o no.

			$objetoXML->setIndentString("\t"); // carácter \t, que corresponde a una tabulación

			$objetoXML->startDocument('1.0', 'utf-8');// Inicio del documento
			
			// $objetoXML->startElement("etiquetaPrincipal");// Inicio del nodo raíz

			// $objetoXML->writeAttribute("atributoEtiquetaPPal", "valor atributo etiqueta PPal"); // Atributo etiqueta principal

			// 	$objetoXML->startElement("etiquetaInterna");// Inicio del nodo hijo

			// 		$objetoXML->writeAttribute("atributoEtiquetaInterna", "valor atributo etiqueta Interna"); // Atributo etiqueta interna

			// 		$objetoXML->text("Texto interno");// Inicio del nodo hijo
			
			// 	$objetoXML->endElement(); // Final del nodo hijo
			
			// $objetoXML->endElement(); // Final del nodo raíz


			$objetoXML->writeRaw('<fe:Invoice xmlns:fe="http://www.dian.gov.co/contratos/facturaelectronica/v1" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:clm54217="urn:un:unece:uncefact:codelist:specification:54217:2001" xmlns:clm66411="urn:un:unece:uncefact:codelist:specification:66411:2001" xmlns:clmIANAMIMEMediaType="urn:un:unece:uncefact:codelist:specification:IANAMIMEMediaType:2003" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2" xmlns:qdt="urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2" xmlns:sts="http://www.dian.gov.co/contratos/facturaelectronica/v1/Structures" xmlns:udt="urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dian.gov.co/contratos/facturaelectronica/v1 ../xsd/DIAN_UBL.xsd urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2 ../../ubl2/common/UnqualifiedDataTypeSchemaModule-2.0.xsd urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2 ../../ubl2/common/UBL-QualifiedDatatypes-2.0.xsd">');

			$objetoXML->writeRaw('<ext:UBLExtensions>');

			foreach ($listaProductos as $key => $value) {
				
				$objetoXML->text($value["descripcion"].", ");
			
			}

			

			$objetoXML->writeRaw('</ext:UBLExtensions>');

			$objetoXML->writeRaw('</fe:Invoice>');

			$objetoXML->endDocument(); // Final del documento

			return true;	
		}

	}

		/*=============================================
	ABONAR VENTA
	=============================================*/

	static public function ctrAbonarVenta(){
		
           // if para validar menor o igual a deuda

		if(isset($_POST["nuevoValor"])){

			
			if(preg_match('/^[#\.\0-9 ]+$/', $_POST["nuevoValor"])){
			
				$tabla = "ventas";
				$datos = array("id"=>$_POST["idVenta"],
			   				   "valor"=>$_POST["nuevoValor"]);
							   

							   $respuesta = ModeloVentas::mdlAbonarVenta($tabla, $datos);
							   
							   if($respuesta == "ok"){

								echo'<script>
			
								swal({
									  type: "success",
									  title: "El abono se ha realizado correctamente",
									  showConfirmButton: true,
									  confirmButtonText: "Cerrar"
									  }).then(function(result){
												if (result.value) {
			
												window.location = "ventas-credito";
			
												}
											})
			
								</script>';
			
							}
			
						}else{
			
							echo'<script>
			
								swal({
									  type: "error",
									  title: "¡El abono no se realizo Intentalo de nuevo!",
									  showConfirmButton: true,
									  confirmButtonText: "Cerrar"
									  }).then(function(result){
										if (result.value) {
			
										window.location = "ventas-credito";
			
										}
									})
			
							  </script>';
			
			
			
						}
						if($respuesta == "super"){
			
							echo'<script>
			
								swal({
									  type: "error",
									  title: "¡El abono no se realizo por que sobrepasa el valor del credito!",
									  showConfirmButton: true,
									  confirmButtonText: "Cerrar"
									  }).then(function(result){
										if (result.value) {
			
										window.location = "ventas";
			
										}
									})
			
							  </script>';
			
			
			
						}
			
					}
  }

  		/*=============================================
	PAGAR VENTA CREDITO
	=============================================*/

	static public function ctrPagarVenta(){

	 if(isset($_GET["idPagarVenta"])){

			 $tabla = "ventas";
			 $valor = $_GET["idPagarVenta"];
							
							$respuesta = ModeloVentas::mdlPagarVenta($tabla, $valor);
							
							if($respuesta == "ok"){

							 echo'<script>
		 
							 swal({
								   type: "success",
								   title: "El pago se ha realizado correctamente",
								   showConfirmButton: true,
								   confirmButtonText: "Cerrar"
								   }).then(function(result){
											 if (result.value) {
		 
											 window.location = "ventas-credito";
		 
											 }
										 })
		 
							 </script>';
		 
						 }else{
		 
						 echo'<script>
		 
							 swal({
								   type: "error",
								   title: "¡El pago no se realizo Intentalo de nuevo!",
								   showConfirmButton: true,
								   confirmButtonText: "Cerrar"
								   }).then(function(result){
									 if (result.value) {
		 
									 window.location = "ventas-credito";
		 
									 }
								 })
		 
						   </script>';
		 
		 
		 
					 }
		 
		 
				 }
}


}
