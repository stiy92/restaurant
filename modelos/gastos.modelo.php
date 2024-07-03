<?php
set_time_limit(1320);
ini_set('max_exection_time', '1600');

require_once "conexion.php";

class ModeloGastos{

	/*=============================================
	MOSTRAR GASTOS
	=============================================*/

	static public function mdlMostrarGastos($tabla, $item, $valor, $orden){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $orden DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}


	/*=============================================
	REGISTRO DE GASTOS
	=============================================*/
	static public function mdlIngresarGasto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(vendedor, valor, descripcion) VALUES (:vendedor, :valor, :descripcion)");

		$stmt->bindParam(":vendedor", $datos["vendedor"], PDO::PARAM_INT);
		$stmt->bindParam(":valor", $datos["valor"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	EDITAR PRODUCTO
	=============================================*/
	static public function mdlEditarProducto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_categoria = :id_categoria, descripcion = :descripcion, codigo = :codigo, imagen = :imagen, stock = :stock, precio_compra = :precio_compra, precio_venta = :precio_venta, stock_t = :stock_t WHERE id = :id");
        
		$stmt->bindParam(":id_categoria", $datos["id_categoria"], PDO::PARAM_INT);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
		$stmt->bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_compra", $datos["precio_compra"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_venta", $datos["precio_venta"], PDO::PARAM_STR);
		$stmt->bindParam(":stock_t", $datos["stock_t"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	BORRAR PRODUCTO
	=============================================*/

	static public function mdlEliminarGasto($tabla, $datos){

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
	ACTUALIZAR PRODUCTO
	=============================================*/

	static public function mdlActualizarProducto($tabla, $item1, $valor1, $valor){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE id = :id");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":id", $valor, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	MOSTRAR SUMA TOTAL DE LOS GASTOS
	=============================================*/	

	static public function mdlMostrarSumaGastos($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT SUM(valor) as total FROM $tabla");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;
	}

		/*=============================================
	SUMAR EL TOTAL DE GASTOS POR DIA
	=============================================*/

	static public function mdlSumaTotalgastosdia($tabla){	

		$stmt = Conexion::conectar()->prepare("SELECT SUM(valor) as total FROM $tabla where DATE(fecha) >= DATE( NOW())" );

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

	static public function mdlRangogastosf($tabla, $fechaInicial, $fechaFinal){	

		try {
			// Agregar las horas para abarcar el día completo
			$fechaInicial .= ' 00:00:01';
			$fechaFinal .= ' 23:59:59';
	
			// Preparar la consulta con parámetros de fechas
			$stmt = Conexion::conectar()->prepare("SELECT SUM(valor) as total FROM $tabla WHERE fecha BETWEEN :fechaInicial AND :fechaFinal");
	
			// Vincular parámetros
			$stmt->bindParam(":fechaInicial", $fechaInicial, PDO::PARAM_STR);
			$stmt->bindParam(":fechaFinal", $fechaFinal, PDO::PARAM_STR);
	
			// Ejecutar la consulta
			$stmt->execute();
	
			// Devolver el resultado
			return $stmt->fetch();
		} catch (Exception $e) {
			// Manejar excepciones
			echo "Error: " . $e->getMessage();
		} finally {
			// Cerrar la conexión
			if ($stmt) {
				$stmt->closeCursor();
				$stmt = null;
			}
		}

	}

}