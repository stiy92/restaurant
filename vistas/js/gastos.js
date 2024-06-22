/*=============================================
CARGAR LA TABLA DINÁMICA DE GASTOS
=============================================*/

$.ajax({

	url: "ajax/datatable-gastos.ajax.php",
	success:function(respuesta){
		
		// console.log("respuesta", respuesta);
		// console.log("respuesta", "Prueba de paginas")

	}

})

var perfilOculto = $("#perfilOculto").val();

$('.tablaGastos').DataTable( {
    "ajax": "ajax/datatable-gastos.ajax.php?perfilOculto="+perfilOculto,
    "deferRender": true,
	"retrieve": true,
	"processing": true,
	 "language": {

			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
			"sFirst":    "Primero",
			"sLast":     "Último",
			"sNext":     "Siguiente",
			"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}

	}

} );

// /*=============================================
// EDITAR PRODUCTO
// =============================================*/

// $(".tablaProductos tbody").on("click", "button.btnEditarProducto", function(){

// 	var idProducto = $(this).attr("idProducto");
// 	console.log("listo parcero", idProducto);
	
// 	var datos = new FormData();
//     datos.append("idProducto", idProducto);

//      $.ajax({

//       url:"ajax/productos.ajax.php",
//       method: "POST",
//       data: datos,
//       cache: false,
//       contentType: false,
//       processData: false,
//       dataType:"json",
//       success:function(respuesta){
          
//           var datosCategoria = new FormData();
//           datosCategoria.append("idCategoria",respuesta["id_categoria"]);

//            $.ajax({

//               url:"ajax/categorias.ajax.php",
//               method: "POST",
//               data: datosCategoria,
//               cache: false,
//               contentType: false,
//               processData: false,
//               dataType:"json",
//               success:function(respuesta){
                  
//                   $("#editarCategoria").val(respuesta["id"]);
//                   $("#editarCategoria").html(respuesta["categoria"]);

//               }

//           })
           
// 		  $("#editarid").val(respuesta["id"]);
		   
//            $("#editarCodigo").val(respuesta["codigo"]);

//            $("#editarDescripcion").val(respuesta["descripcion"]);

// 		   $("#editarStockM").val(respuesta["stock_t"]);

//            $("#editarStock").val(respuesta["stock"]);

//            $("#editarPrecioCompra").val(respuesta["precio_compra"]);

//            $("#editarPrecioVenta").val(respuesta["precio_venta"]);

//            if(respuesta["imagen"] != ""){

//            	$("#imagenActual").val(respuesta["imagen"]);

//            	$(".previsualizar").attr("src",  respuesta["imagen"]);

//            }

//       }

//   })

// })

// /*=============================================
// ELIMINAR PRODUCTO
// =============================================*/

// $(".tablaProductos tbody").on("click", "button.btnEliminarProducto", function(){

// 	var idProducto = $(this).attr("idProducto");
// 	var codigo = $(this).attr("codigo");
// 	var imagen = $(this).attr("imagen");
	
// 	swal({

// 		title: '¿Está seguro de borrar el producto?',
// 		text: "¡Si no lo está puede cancelar la accíón!",
// 		type: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         cancelButtonText: 'Cancelar',
//         confirmButtonText: 'Si, borrar producto!'
//         }).then(function(result) {
//         if (result.value) {

//         	window.location = "index.php?ruta=productos&idProducto="+idProducto+"&imagen="+imagen+"&codigo="+codigo;

//         }


// 	})

// })
	
