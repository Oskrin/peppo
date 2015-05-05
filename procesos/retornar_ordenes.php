<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);
$id = $_GET['com'];
$arr_data = array();

$consulta = pg_query("select  O.fecha_actual, O.hora_actual, U.nombre_usuario, U.apellido_usuario, O.codigo  from ordenes_produccion O, usuario U where O.id_usuario = U.id_usuario and O.id_ordenes='" . $id . "'");
while ($row = pg_fetch_row($consulta)) {
    $arr_data[] = $row[0];
    $arr_data[] = $row[1];
    $arr_data[] = $row[2];
    $arr_data[] = $row[3];
    $arr_data[] = $row[4];
}
echo json_encode($arr_data);
?>
