<?php

require_once "conexion.php";

class ModeloVentas{

	/*=============================================
	MOSTRAR VENTAS
	=============================================*/

	static public function mdlMostrarVentas($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id ASC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");

			$stmt -> execute();

			return $stmt -> fetchAll(); 

		}
		
		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	REGISTRO DE VENTA
	=============================================*/

	static public function mdlIngresarVenta($tabla, $datos){

		try {
			// Obtener el último código
			$stmtCodigo = Conexion::conectar()->prepare("SELECT MAX(codigo) as max_codigo FROM $tabla");
			$stmtCodigo->execute();
			$resultadoCodigo = $stmtCodigo->fetch(PDO::FETCH_ASSOC);
			$ultimoCodigo = $resultadoCodigo['max_codigo'] + 1;
	
        //preparar la insercion
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo, id_cliente, id_vendedor, productos, impuesto, neto, total, metodo_pago) VALUES (:codigo, :id_cliente, :id_vendedor, :productos, :impuesto, :neto, :total, :metodo_pago)");

		//agregar los valores
		$stmt->bindParam(":codigo", $ultimoCodigo, PDO::PARAM_INT);
		//$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":impuesto", $datos["impuesto"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

	} catch (PDOException $e) {
        return false;
    }

		$stmt->close();
		$stmt = null;


	}

	/*=============================================
	EDITAR VENTA
	=============================================*/

	static public function mdlEditarVenta($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  id_cliente = :id_cliente, id_vendedor = :id_vendedor, productos = :productos, impuesto = :impuesto, neto = :neto, total= :total, metodo_pago = :metodo_pago WHERE codigo = :codigo");

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":impuesto", $datos["impuesto"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	ELIMINAR VENTA
	=============================================*/

	static public function mdlEliminarVenta($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	RANGO FECHAS REPORTE FINAL
	=============================================*/	

	static public function mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal){
        
		if($fechaInicial == null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE DATE(fecha) = CURRENT_DATE() ORDER BY id DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();	 


		}else if($fechaInicial == $fechaFinal){
			$fechaInicial .= ' 00:00:01';
            $fechaFinal .= ' 23:59:59';
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN :fechaInicial AND :fechaFinal");

			$stmt->bindParam(":fechaInicial", $fechaInicial, PDO::PARAM_STR);
            
			$stmt->bindParam(":fechaFinal", $fechaFinal, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{
            $fechaFinal .= ' 23:59:59';

			$fechaActual = new DateTime();
			$fechaActual ->add(new DateInterval("P1D"));
			$fechaActualMasUno = $fechaActual->format("Y-m-d");

			$fechaFinal2 = new DateTime($fechaFinal);
			$fechaFinal2 ->add(new DateInterval("P1D"));
			$fechaFinalMasUno = $fechaFinal2->format("Y-m-d");

			if($fechaFinalMasUno == $fechaActualMasUno){

				$fechaInicial .= ' 00:00:01';
                $fechaFinalMasUno .= ' 23:59:59';
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'");

			}else{
				$fechaInicial .= ' 00:00:01';
                $fechaFinal .= ' 23:59:59';

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal'");

			}
		
			$stmt -> execute();

			return $stmt -> fetchAll();

		}

	}

	/*=============================================
	REPORTE PRINCIPAL PARA EL GRAFICO SUMA EFECTIVO, CREDITO, NEQUI
	=============================================*/	

	static public function mdlRangoF($tabla){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE DATE(fecha) >= DATE( NOW()) ORDER BY id DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();	 


	}

	/*=============================================
	REPORTE FINAL PARA EL GRAFICO SUMA EFECTIVO, CREDITO, NEQUI
	=============================================*/	

	static public function mdlRangoFF($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC");

		$stmt -> execute();

		return $stmt -> fetchAll();	 


}
	/*=============================================
	SUMAR EL TOTAL DE VENTAS EFECTIVO REPORTE FINAL
	=============================================*/

	static public function mdlSumaTotalVentas($tabla){	

		$stmt = Conexion::conectar()->prepare("SELECT SUM(neto) as total FROM $tabla where metodo_pago= 'Efectivo'");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	SUMAR EL TOTAL DE VENTAS CREDITOS REPORTE FINAL
	=============================================*/

	static public function mdlSumaTotalCreditos($tabla){	

		$stmt = Conexion::conectar()->prepare("SELECT SUM(neto) as total FROM $tabla where metodo_pago= 'crédito-0'");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}
	
		/*=============================================
	SUMAR EL TOTAL DE VENTAS NEQUI REPORTE FINAL
	=============================================*/

	static public function mdlSumaTotalNequi($tabla){	

		$stmt = Conexion::conectar()->prepare("SELECT SUM(neto) as total FROM $tabla where metodo_pago= 'NEQUI-0'");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

	////////////////////////////////////////////////////REPORTE INICIAL//////////////////////////////////////////////////
	/*=============================================
	SUMAR EL TOTAL DE VENTAS POR DIA EFECTIVO REPORTE INICIAL
	=============================================*/

	static public function mdlSumaTotalVentasdia($tabla){	

		$stmt = Conexion::conectar()->prepare("SELECT SUM(neto) as total FROM $tabla where DATE(fecha) >= DATE( NOW()) and metodo_pago= 'Efectivo'" );

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	SUMAR EL TOTAL DE VENTAS POR DIA CREDITO REPORTE INICIAL
	=============================================*/

	static public function mdlSumaTotalVentascreditodia($tabla){	

		$stmt = Conexion::conectar()->prepare("SELECT SUM(neto) as total FROM $tabla where DATE(fecha) >= DATE( NOW())and metodo_pago= 'crédito-0'" );

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

	
	/*=============================================
	SUMAR EL TOTAL DE VENTAS POR DIA NEQUI REPORTE INICIAL
	=============================================*/

	static public function mdlSumaTotalVentasdianequi($tabla){	

		$stmt = Conexion::conectar()->prepare("SELECT SUM(neto) as total FROM $tabla where DATE(fecha) >= DATE( NOW())and metodo_pago= 'NEQUI-0'" );

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}
	
	
}