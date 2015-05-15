<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);

/////datos ordenes de produccion/////
$campo1 = $_POST['campo1'];
$campo2 = $_POST['campo2'];
$campo3 = $_POST['campo3'];
////////////////////////////////////
//
//////descompner arreglo///////////
$arreglo1 = explode('|', $campo1);
$arreglo2 = explode('|', $campo2);
$arreglo3 = explode('|', $campo3);
$nelem1 = count($arreglo1);
//////////////////////////////////


for ($i = 0; $i <= $nelem1; $i++) {
    //////////////modificar productos///////////
    $consulta = pg_query("select * from productos where cod_productos = '".$arreglo1[$i]."'");
    while ($row = pg_fetch_row($consulta)) {
        $stock = $row[13];
    }
    $cal = $stock + $arreglo2[$i];

    pg_query("Update productos Set stock='" . $cal . "' where cod_productos='" . $arreglo1[$i] . "'"); 

    // $consulta2 = pg_query("select D.cod_productos, D.cantidad, D.precio_costo from detalles_componentes D, componentes C, productos P where C.id_componentes = D.id_componentes and C.cod_productos = P.cod_productos and P.cod_productos = '$arreglo1[$i]'");
    // while ($row = pg_fetch_row($consulta2)) {
    //     $cod = $row[0];
    //     $can = $row[1];
    //     $pre = $row[2];
    //     // $cantidad_tota = $can  * $arreglo2[$i];
    //     // $precio_total = $pre * $arreglo2[$i];
    //     // $total_costo = $cantidad_tota * $pre;


    //     pg_query("Update productos Set stock='" . $cal2 . "' where cod_productos='" . $arreglo1[$j] . "'"); 
       
    // }
}
$data = 1;

echo $data;
?>
