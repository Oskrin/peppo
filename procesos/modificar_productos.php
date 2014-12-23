<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);

///////////////modificar productos//////////
$valor = number_format($_POST['precio_compra'], 2, '.', '');
$valor1 = number_format($_POST['precio_minorista'], 2, '.', '');
$valor2 = number_format($_POST['precio_mayorista'], 2, '.', '');

pg_query("Update productos Set codigo='$_POST[cod_prod]', cod_barras='$_POST[cod_barras]', articulo='".strtoupper($_POST[nombre_art])."', iva='$_POST[iva]', series='$_POST[series]', precio_compra='$valor', utilidad_minorista='$_POST[utilidad_minorista]', utilidad_mayorista='$_POST[utilidad_mayorista]', iva_minorista='$valor1', iva_mayorista='$valor2',categoria='$_POST[categoria]', marca='$_POST[marca]', stock='$_POST[stock]', stock_minimo='$_POST[minimo]', stock_maximo='$_POST[maximo]', fecha_creacion='$_POST[fecha_creacion]', caracteristicas='$_POST[modelo]', observaciones='$_POST[aplicacion]', descuento='$_POST[descuento]', estado='$_POST[vendible]', inventariable='$_POST[inventario]', unidades_medida='$_POST[medida]' where cod_productos='$_POST[cod_productos]'");


$data = 1;
echo $data;
?>
