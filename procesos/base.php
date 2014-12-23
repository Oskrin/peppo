<?php

function conectarse() {
    if (!($conexion = pg_pconnect("host=localhost port=5432 dbname=base_peppo user=postgres password=rootdow"))) {
        exit();
    } else {
        
    }
    return $conexion;
}

conectarse();
?>
