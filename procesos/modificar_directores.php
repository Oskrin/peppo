<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);

/////////////////modificar director@////////////////////
pg_query("Update directores Set identificacion_dire='$_POST[ruc_ci]', nombres='$_POST[nombres_cli]', direccion='$_POST[direccion_cli]', telefono='$_POST[nro_telefono]', celular='$_POST[nro_celular]', pais='$_POST[pais_cli]', ciudad='$_POST[ciudad_cli]', correo='$_POST[email]', estado='Activo' where id_director='$_POST[id_director]'");
//////////////////////////////////////////////////////

$data = 1;
echo $data;
?>
