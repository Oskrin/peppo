<?php

session_start();
include 'base.php';
conectarse();
$texto = $_GET['term'];

$consulta = pg_query("select id_ordenes,codigo from ordenes_produccion  where codigo like '%$texto%' and estado = 'Activo'");
while ($row = pg_fetch_row($consulta)) {
    $data[] = array(
        'value' => $row[0],
        'label' => $row[1]
    );
}
echo $data = json_encode($data);
?>
