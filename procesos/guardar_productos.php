<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);

/////////////contador productos//////////
$cont = 0;
$consulta = pg_query("select max(cod_productos) from productos");
while ($row = pg_fetch_row($consulta)) {
    $cont = $row[0];
}
$cont++;
////////////////////////////////////////
////////////guardar productos///////////
$valor = number_format($_POST['precio_compra'], 2, '.', '');
$valor2 = number_format($_POST['precio_minorista'], 2, '.', '');
$valor3 = number_format($_POST['precio_mayorista'], 2, '.', '');
pg_query("insert into productos values('$cont','$_POST[cod_prod]','$_POST[cod_barras]','" . strtoupper($_POST[nombre_art]) . "','$_POST[iva]','$_POST[series]','$valor','$_POST[utilidad_minorista]','$_POST[utilidad_mayorista]','$valor2','$valor3','$_POST[categoria]','$_POST[marca]','$_POST[stock]','$_POST[minimo]','$_POST[maximo]','$_POST[fecha_creacion]','$_POST[modelo]','$_POST[aplicacion]','$_POST[descuento]','$_POST[vendible]','$_POST[inventario]','','','$_POST[medida]')");
///////////////////////////////////////

$data = 1;
echo $data;
?>
