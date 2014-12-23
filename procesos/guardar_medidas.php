<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);
$cont = 0;
$repe = 0;

//////////////////validar repetidos//////////////////
$consulta = pg_query("select * from unidades_medida where descripcion='" . strtoupper($_POST[descripcion]) . "'");
while ($row = pg_fetch_row($consulta)) {
    $repe++;
}
/////////////////////////////////////////////////// 

if ($repe == 0) {
///////////////////contador marca//////////////
    $consulta = pg_query("select max(id_unidades) from unidades_medida");
    while ($row = pg_fetch_row($consulta)) {
        $cont = $row[0];
    }
    $cont++;
////////////////////////////////////////

    pg_query("insert into unidades_medida values('$cont','" . strtoupper($_POST[descripcion]) . "','" . strtoupper($_POST[abreviatura]) . "','Activo')");
    $data = 1;
} else {
    $data = 0;
}
echo $data;
?>
