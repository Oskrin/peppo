<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);
$id = $_GET['com'];
$arr_data = array();

$consulta = pg_query("SELECT D.cod_productos, D.articulo, D.cantidad, D.precio_costo, D.total FROM componentes C, detalles_componentes D, productos P  where C.id_componentes=D.id_componentes and C.cod_productos = P.cod_productos and P.cod_productos='" . $id . "' ");
    while ($row = pg_fetch_row($consulta)) {
        $arr_data[] = $row[0];
        $arr_data[] = $row[1];
        $arr_data[] = $row[2];
        $arr_data[] = $row[3];
        $arr_data[] = $row[4];
    }
echo json_encode($arr_data);
?>
