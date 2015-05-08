<?php

session_start();
include 'base.php';
conectarse();
$texto2 = $_GET['term'];
$consulta = pg_query("SELECT * FROM productos P, componentes C where C.cod_productos = P.cod_productos and P.estado='Activo' and P.articulo like '%$texto2%'");
while ($row = pg_fetch_row($consulta)) {
    $data[] = array(
        'value' => $row[3],
        'codigo' => $row[1],
        'precio_v' => $row[9],
        'stock' => $row[13],
        'cod_producto' => $row[0]
    );
}

echo $data = json_encode($data);
?>
