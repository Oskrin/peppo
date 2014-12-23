<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);

/////////////////eliminar clientes////////////////////
pg_query("Update directores Set estado='Pasivo' where id_director='$_POST[id_director]'");
//////////////////////////////////////////////////////

$data = 1;
echo $data;
?>