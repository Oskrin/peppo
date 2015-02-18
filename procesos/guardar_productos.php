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
//
////////////guardar productos///////////
if ($_POST['tipo'] == "Componente") {
    $valor = number_format($_POST['precio_compra'], 2, '.', '');
    $valor2 = number_format($_POST['precio_minorista'], 2, '.', '');
    $valor3 = number_format($_POST['precio_mayorista'], 2, '.', '');
    pg_query("insert into productos values('$cont','$_POST[cod_prod]','$_POST[cod_barras]','" . strtoupper($_POST[nombre_art]) . "','$_POST[iva]','$_POST[series]','$valor','$_POST[utilidad_minorista]','$_POST[utilidad_mayorista]','$valor2','$valor3','$_POST[categoria]','$_POST[marca]','$_POST[stock]','$_POST[minimo]','$_POST[maximo]','$_POST[fecha_creacion]','$_POST[modelo]','$_POST[aplicacion]','$_POST[descuento]','$_POST[vendible]','$_POST[inventario]','','','$_POST[medida]','$_POST[tipo]')");
    $data = 1;
///////////////////////////////////////
} else {
    if ($_POST['tipo'] == "Producto") {
        $valor = number_format($_POST['precio_compra'], 2, '.', '');
        $valor2 = number_format($_POST['precio_minorista'], 2, '.', '');
        $valor3 = number_format($_POST['precio_mayorista'], 2, '.', '');
        pg_query("insert into productos values('$cont','$_POST[cod_prod]','$_POST[cod_barras]','" . strtoupper($_POST[nombre_art]) . "','$_POST[iva]','$_POST[series]','$valor','$_POST[utilidad_minorista]','$_POST[utilidad_mayorista]','$valor2','$valor3','$_POST[categoria]','$_POST[marca]','$_POST[stock]','$_POST[minimo]','$_POST[maximo]','$_POST[fecha_creacion]','$_POST[modelo]','$_POST[aplicacion]','$_POST[descuento]','$_POST[vendible]','$_POST[inventario]','','','$_POST[medida]','$_POST[tipo]')");

        /////detalles componentes//
        $campo1 = $_POST['campo1'];
        $campo2 = $_POST['campo2'];
        $campo3 = $_POST['campo3'];
        $campo4 = $_POST['campo4'];
        ///////////////////////////////
        //
        ////////////agregar detalle_componentes////////
        $arreglo1 = explode('|', $campo1);
        $arreglo2 = explode('|', $campo2);
        $arreglo3 = explode('|', $campo3);
        $arreglo4 = explode('|', $campo4);
        $nelem = count($arreglo1);
        
        if($nelem != 0){
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
        pg_query("insert into componentes values('$cont1','$_SESSION[id]','$cont','$_POST[subtot]','Activo')");
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
            pg_query("insert into detalles_componentes values('$cont2','$cont1','$arreglo1[$j]','$arreglo2[$j]','$arreglo3[$j]','$arreglo4[$j]','Activo')");
            ////////////////////////////////
            $data = 1;
        }
    }
}

echo $data;
?>
