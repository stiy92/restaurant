sistema de logeo
tablero inicial caja superiores muestra el total de las ventas efectivo por dia, gastos, ventas creditos, ventas nequi
tiene un grafico de ventas sumando efectivo y nequi y resta los gastos
grafico de productos mas vendidos y un listado de los ultimos pordutos agregados
secion de usuarios:
permite agregar usuarios con ciertos roles y fotos, los muestra en una tabla donde indica nombre usuario foto perfil estado y se pueden modificar o eliminar mas agregar nuevos
secion de gastos:
tambien tiene una secion similar aplicando el crud
categorias lo mismo para agregarlos a los productos
productos despues sigo

nota de posibles errores con su soluction
si al crear un usuario nuevo o producto y no permite la imagen, se debe de activar en el php.ini 
Habilita la extensión GD en PHP:
Abre el archivo php.ini (lo encontrarás en la carpeta de configuración de tu servidor XAMPP, normalmente en C:\xampp\php\php.ini).
Busca la línea que dice ;extension=gd o ;extension=gd2.
Quita el punto y coma (;) al inicio de la línea para descomentarla, dejándola así:
ini
Copiar código
extension=gd
Reinicia XAMPP:
Después de guardar los cambios en el archivo php.ini, reinicia Apache desde el panel de control de XAMPP para aplicar la configuración.
Después de hacer esto, la función imagecreatefrompng() debería funcionar correctamente.

para que tome las impresiones se dbe de instalar las impresoras y configurar de forma virtual tambien

la direcion ip debe ser fija en caso tal se conectaran otros dispositivos al servidor 
recordar que la direcion de internet es con los digitos 8
si en caso tal no permite el servidor toca agregar la regla en el firewall

para los datos reales de las entas toca veririfcar la zona horaria del servidor que sea igual al equipo
por que si verificamos la zona horaria en un archivo 'la zona horaria: ' . date_default_timezone_get(); nos muestra por defecto echo la zona horaria: Europe/Berlin
toca cambiarla en el archivo php.in search this: date.timezone = America/Bogota

problema de impimir tickect y pdf tocaba actualizar la carpeta tcpdf exactamente el archivo tcpdf, tcpdf_barcodes_1d, tcpdf_static, tcpdf_images listo

el error despues de realizar venta si estaba en la linea 126 como mostraba el mensaje y se modifico la linea poniendo el - al final

la impresora par que sea modo bidirecional tiene que ser version -4 y no -3  en regedy se pude ver w+r y regedy
