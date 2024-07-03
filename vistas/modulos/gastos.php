<?php

if($_SESSION["perfil"] == "Vendedor"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar gastos
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar gastos</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregargastos">
          
          Agregar gasto

        </button>
      
      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tabla" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Vendedor</th>
           <th>Valor</th>
           <th>Descripción</th>
           <th>Fecha</th>
           <th>Acciones</th>
           
         </tr> 

        </thead>  
        
       
       <tbody>

       <?php
       $item = null;
       $valor = null;
       $orden = "id";
 
       $respuesta = ControladorGastos::ctrMostrarGastos($item, $valor, $orden);

       foreach ($respuesta as $key => $value) {
        // obtener el nombre del vendedor 
        // cambiar esto y utilizar el mismo llamado de ventas

        $itemUsuario = "id";
        $valorUsuario = $value["vendedor"];

        $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);
        
        echo '<tr>

               <td>'.($key+1).'</td>

               <td>'.$respuestaUsuario["nombre"].'</td>

               <td>'.$value["valor"].'</td>

               <td>'.$value["descripcion"].'</td>

               <td>'.$value["fecha"].'</td>

               <td>

                    <div class="btn-group">
                        
                     ';

                      if($_SESSION["perfil"] == "Administrador"){

                      echo '
                      <button class="btn btn-warning btnEditarGasto" idGasto="'.$value["id"].'"><i class="fa fa-pencil"></i></button>
                      <button class="btn btn-danger btnEliminarGasto" idGasto="'.$value["id"].'"><i class="fa fa-times"></i></button>';

                    }

                    echo '</div>

             </tr>';
         }
       ?>
        </tbody>

        </table>
       <input type="hidden" value="<?php echo $_SESSION['perfil']; ?>" id="perfilOculto">

      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR GASTO
======================================-->

<div id="modalAgregargastos" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar gastos</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">


                <!--=====================================
                ENTRADA DEL VENDEDOR
                ======================================-->
            
                <div class="form-group">
                
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                    <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $_SESSION["nombre"]; ?>" readonly>

                    <input type="hidden" name="idVendedor" value="<?php echo $_SESSION["id"]; ?>">

                  </div>

                </div> 

                   <!-- ENTRADA PARA VALOR -->

                  <div class="form-group row">

                    <div class="col-xs-6">

                      <div class="input-group">
  
                     <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 

                      <input type="number" class="form-control input-lg" id="nuevoGasto" name="nuevoGasto" step="any" min="0" placeholder="Valor del gasto" required>

                    </div>

                  </div>

            <!-- ENTRADA PARA LA DESCRIPCIÓN -->

             <div class="form-group ">
             <div class="col-xs-12" style="padding-top: 20px;">
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 

                <textarea class="form-control input-lg" name="nuevaDescripcion" placeholder="Ingresar descripción" required ></textarea>
                </div>
              </div>

            </div>

                </div>

            </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar gasto</button>

        </div>

      </form>

        <?php

          $crearGasto = new ControladorGastos();
          $crearGasto -> ctrCrearGasto();

        ?>  

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR PRODUCTO
======================================-->

<div id="modalEditarGasto" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar gasto</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">


            <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg"  name="editarCategoria" readonly required>
                  
                  <option id="editarCategoria"></option>

                </select>

              </div>

            </div>

            <!-- ENTRADA PARA EL CÓDIGO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-code"></i></span> 

                <input type="text" class="form-control input-lg" id="editarCodigo" name="editarCodigo" required>
                
                <input type="hidden" id="editarid" name="editarid" readonly required >
                             
                </div>
            </div>


            <!-- ENTRADA PARA LA DESCRIPCIÓN -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 

                <input type="text" class="form-control input-lg" id="editarDescripcion" name="editarDescripcion" required >

              </div>

            </div>

             <!-- ENTRADA PARA STOCK_MAX -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-check"></i></span> 

                <input type="number" class="form-control input-lg" id="editarStockM" name="editarStockM" min="0" required>

              </div>

            </div>

             <!-- ENTRADA PARA STOCK -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-check"></i></span> 

                <input type="number" class="form-control input-lg" id="editarStock" name="editarStock" min="0" required>

              </div>

            </div>

             <!-- ENTRADA PARA PRECIO COMPRA -->

             <div class="form-group row">

                <div class="col-xs-6">
                
                  <div class="input-group">
                  
                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 

                    <input type="number" class="form-control input-lg" id="editarPrecioCompra" name="editarPrecioCompra" step="any" min="0" required>

                  </div>

                </div>

                <!-- ENTRADA PARA PRECIO VENTA -->

                <div class="col-xs-6">
                
                  <div class="input-group">
                  
                    <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 

                    <input type="number" class="form-control input-lg" id="editarPrecioVenta" name="editarPrecioVenta" step="any" min="0" readonly required>

                  </div>
                
                  <br>

                  <!-- CHECKBOX PARA PORCENTAJE -->

                  <div class="col-xs-6">
                    
                    <div class="form-group">
                      
                      <label>
                        
                        <input type="checkbox" class="minimal porcentaje">
                        Utilizar procentaje
                      </label>

                    </div>

                  </div>

                  <!-- ENTRADA PARA PORCENTAJE -->

                  <div class="col-xs-6" style="padding:0">
                    
                    <div class="input-group">
                      
                      <input type="number" class="form-control input-lg nuevoPorcentaje" min="0" value="40" required>

                      <span class="input-group-addon"><i class="fa fa-percent"></i></span>

                    </div>

                  </div>

                </div>

            </div>

            <!-- ENTRADA PARA SUBIR FOTO -->

             <div class="form-group">
              
              <div class="panel">SUBIR IMAGEN</div>

              <input type="file" class="nuevaImagen" name="editarImagen">

              <p class="help-block">Peso máximo de la imagen 2MB</p>

              <img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">

              <input type="hidden" name="imagenActual" id="imagenActual">

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cambios</button>

        </div>

      </form>

        <?php

          $editarProducto = new ControladorProductos();
          $editarProducto -> ctrEditarProducto();

        ?>      

    </div>

  </div>

</div>

<?php

  $eliminarGasto = new ControladorGastos();
  $eliminarGasto -> ctrEliminarGasto();

?>      


<!-- //Validacion de caracteres paa el ingreso de datos de un producto  -->

<script>
    function validarEntrada(input) {
      // Expresión regular que acepta solo números y letras
      var regex = /^[a-zA-Z0-9]*$/;
      // Verifica si el valor ingresado coincide con la expresión regular
      if (!regex.test(input.value)) {
        // Si no coincide, elimina el último carácter ingresado
        input.value = input.value.slice(0, -1);
      }
    }
  </script>
