<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);


if ($_POST['tipo'] == "Componente") {
///////////////modificar productos//////////	
$valor = number_format($_POST['precio_compra'], 2, '.', '');
$valor1 = number_format($_POST['precio_minorista'], 2, '.', '');
$valor2 = number_format($_POST['precio_mayorista'], 2, '.', '');

pg_query("Update productos Set codigo='$_POST[cod_prod]', cod_barras='$_POST[cod_barras]', articulo='".strtoupper($_POST[nombre_art])."', iva='$_POST[iva]', series='$_POST[series]', precio_compra='$valor', utilidad_minorista='$_POST[utilidad_minorista]', utilidad_mayorista='$_POST[utilidad_mayorista]', iva_minorista='$valor1', iva_mayorista='$valor2',categoria='$_POST[categoria]', marca='$_POST[marca]', stock='$_POST[stock]', stock_minimo='$_POST[minimo]', stock_maximo='$_POST[maximo]', fecha_creacion='$_POST[fecha_creacion]', caracteristicas='$_POST[modelo]', observaciones='$_POST[aplicacion]', descuento='$_POST[descuento]', estado='$_POST[vendible]', inventariable='$_POST[inventario]', unidades_medida='$_POST[medida]', tipo_producto='$_POST[tipo]' where cod_productos='$_POST[cod_productos]'");
$data = 1;
////////////////////////////////////////////
} else {
    if ($_POST['tipo'] == "Producto") {
    	// /////detalles componentes//
        $campo1 = $_POST['campo1'];
        $campo2 = $_POST['campo2'];
        $campo3 = $_POST['campo3'];
        $campo4 = $_POST['campo4'];
        $campo5 = $_POST['campo5'];
        ///////////////////////////////
        //
        ////////////agregar detalle_componentes////////
        $arreglo1 = explode('|', $campo1);
        $arreglo2 = explode('|', $campo2);
        $arreglo3 = explode('|', $campo3);
        $arreglo4 = explode('|', $campo4);
        $arreglo5 = explode('|', $campo5);
        $nelem = count($arreglo1);

        ////////////////////////modificar Productos////////////
        $valor = number_format($_POST['precio_compra'], 2, '.', '');
		$valor1 = number_format($_POST['precio_minorista'], 2, '.', '');
		$valor2 = number_format($_POST['precio_mayorista'], 2, '.', '');

        pg_query("Update productos Set codigo='$_POST[cod_prod]', cod_barras='$_POST[cod_barras]', articulo='".strtoupper($_POST[nombre_art])."', iva='$_POST[iva]', series='$_POST[series]', precio_compra='$valor', utilidad_minorista='$_POST[utilidad_minorista]', utilidad_mayorista='$_POST[utilidad_mayorista]', iva_minorista='$valor1', iva_mayorista='$valor2',categoria='$_POST[categoria]', marca='$_POST[marca]', stock='$_POST[stock]', stock_minimo='$_POST[minimo]', stock_maximo='$_POST[maximo]', fecha_creacion='$_POST[fecha_creacion]', caracteristicas='$_POST[modelo]', observaciones='$_POST[aplicacion]', descuento='$_POST[descuento]', estado='$_POST[vendible]', inventariable='$_POST[inventario]', unidades_medida='$_POST[medida]', tipo_producto='$_POST[tipo]' where cod_productos='$_POST[cod_productos]'");
        ///////////////////////////////////////////////////////
        //
        ///////////////////verificar componentes///////////////
        $consulta2 = pg_query("select COUNT(*) from componentes C where C.cod_productos = '$_POST[cod_productos]'");
	    while ($row = pg_fetch_row($consulta2)) {
	    	$variable = $row[0];
	    }
		/////////////////////////////////////////////////////    

        if ($variable == 1){
        	$consulta2 = pg_query("select * from componentes C where C.cod_productos = '$_POST[cod_productos]'");
		    while ($row = pg_fetch_row($consulta2)) {
		        $cod = $row[0];
		        /////////////////////modificar componentes///////////////
		        pg_query("Update componentes Set subtotal='$_POST[subtot]' where id_componentes='".$cod."'");
		        ////////////////////////////////////////////////////////
		        //
		        ///////////////////eliminar detalle coomponentes//////////
		        pg_query("DELETE FROM  detalles_componentes D where D.id_componentes='".$cod."'");
		        /////////////////////////////////////////////////////////

		        /////////////////agreagar nuevos detalles componentes//////////////////////////
		        for ($j = 0; $j <= $nelem; $j++) {
		            /////////////////contador detalle componente/////////////
		            $cont2 = 0;
		            $consulta = pg_query("select max(id_detalles_componentes) from detalles_componentes");
		            while ($row = pg_fetch_row($consulta)) {
		                $cont2 = $row[0];
		            }
		            $cont2++;
		            //////////////////////////  
		            //
		            ///guardar detalle_componentes/////
		            pg_query("insert into detalles_componentes values('$cont2','$cod','$arreglo1[$j]','$arreglo2[$j]','$arreglo3[$j]','$arreglo4[$j]','$arreglo5[$j]','Activo')");
		            ////////////////////////////////
		            }
		            $data = 1;
		        }
        }else{
        	if ($nelem != 1) {
            /////////////contador componentes//////////
            $cont1 = 0;
            $consulta = pg_query("select max(id_componentes) from componentes");
            while ($row = pg_fetch_row($consulta)) {
                $cont1 = $row[0];
            }
            $cont1++;
            ////////////////////////////////////////
            //
	        /////////////guardar Componente/////////
	        pg_query("insert into componentes values('$cont1','$_SESSION[id]','$_POST[cod_productos]','$_POST[subtot]','Activo')");
	        }
	        /////////////////////////////////////
	        //
	        ///////////////////////////////////////////
	        for ($j = 0; $j <= $nelem; $j++) {
	            /////////////////contador detalle componente/////////////
	            $cont2 = 0;
	            $consulta = pg_query("select max(id_detalles_componentes) from detalles_componentes");
	            while ($row = pg_fetch_row($consulta)) {
	                $cont2 = $row[0];
	            }
	            $cont2++;
	            //////////////////////////  
	            //
	            ///guardar detalle_componentes/////
	            pg_query("insert into detalles_componentes values('$cont2','$cont1','$arreglo1[$j]','$arreglo2[$j]','$arreglo3[$j]','$arreglo4[$j]','$arreglo5[$j]','Activo')");
	            ////////////////////////////////
	            $data = 1;
        	}
        }
    }
}
///////////////////////////////////////////////////////


echo $data;
?>
