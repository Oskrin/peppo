<?php

require('../dompdf/dompdf_config.inc.php');
session_start();
$codigo = '<html> 
    <head> 
        <link rel="stylesheet" href="../../css/estilosAgrupados.css" type="text/css" /> 
    </head> 
    <body>
        <header>
            <img src="../../images/logo_empresa.jpg" />
            <div id="me">
                <h2 style="text-align:center;border:solid 0px;width:100%;">' . $_SESSION['empresa'] . '</h2>
                <h4 style="text-align:center;border:solid 0px;width:100%;">' . $_SESSION['slogan'] . '</h4>
                <h4 style="text-align:center;border:solid 0px;width:100%;">' . $_SESSION['propietario'] . '</h4>
                <h4 style="text-align:center;border:solid 0px;width:100%;">' . $_SESSION['direccion'] . '</h4>
                <h4 style="text-align:center;border:solid 0px;width:100%;">Telf: ' . $_SESSION['telefono'] . ' Cel:  ' . $_SESSION['celular'] . ' ' . $_SESSION['pais_ciudad'] . '</h4>
            </div>            
    </header>        
    <hr>
    <div id="linea">
        <h3>INVENTARIO</h3>
    </div>';
include '../../procesos/base.php';
conectarse();
$sql = pg_query("select  I.comprobante, I.fecha_actual, I.hora_actual, U.nombre_usuario, U.apellido_usuario  from inventario I, usuario U where I.id_usuario = U.id_usuario and I.comprobante='$_GET[id]'");
while ($row = pg_fetch_row($sql)) {
    $codigo.='<table border=0>';
    $codigo.='<tr>
        <td style="width:80px;text-align:left;">Comprobante:</td>   
        <td style="width:100px;text-align:left;">' . $row[0] . '</td>   
        <td style="width:60px;text-align:left;">Fecha:</td>
        <td style="width:100px;text-align:left;">' . $row[1] . '</td>   
        <td style="width:60px;text-align:left;">Hora:</td>
        <td style="width:100px;text-align:left;">' . $row[2] . '</td></tr>
        <tr><td style="width:100px;text-align:left;">Usuario:</td>   
        <td style="width:130px;text-align:left;">' . $row[3] . ' ' . $row[4] . '</td>';
    $codigo.='</tr>';
    $codigo.='</table>';
}

$sql2 = pg_query("select D.cod_productos, P.codigo, P.articulo, D.p_costo, D.p_venta, D.disponibles, D.existencia, D.diferencia from inventario I, detalle_inventario D, productos P where D.cod_productos = P.cod_productos and I.id_inventario = D.id_inventario and D.id_inventario='$_GET[id]'");
$codigo.='<br/><table border=0><tr>';
$codigo.='<td style="width:100px;text-align:center;border:solid 1px;">Código</td>
    <td style="width:200px;text-align:center;border:solid 1px;">Producto</td>   
    <td style="width:90px;text-align:center;border:solid 1px;">P.Costo</td>   
    <td style="width:90px;text-align:center;border:solid 1px;">P.venta</td>
    <td style="width:80px;text-align:center;border:solid 1px;">Stock</td>
    <td style="width:80px;text-align:center;border:solid 1px;">Existencia</td>
    <td style="width:80px;text-align:center;border:solid 1px;">Diferencia</td>';
$total1 = 0;
$total2 = 0;
while ($row = pg_fetch_row($sql2)) {
    $total1 = $total1 + $row[3];
    $total2 = $total2 + $row[4];
    $codigo.='<tr>
        <td style="width:100px;text-align:center;">' . $row[1] . '</td>   
        <td style="width:200px;text-align:left;">' . $row[2] . '</td>   
        <td style="width:90px;text-align:center;">' . $row[3] . '</td> 
        <td style="width:90px;text-align:center;">' . $row[4] . '</td>
        <td style="width:80px;text-align:center;">' . $row[5] . '</td>
        <td style="width:80px;text-align:center;">' . $row[6] . '</td>
        <td style="width:80px;text-align:center;">' . $row[7] . '</td>    
        </tr>';
}
$codigo.='<tr><hr></tr>';
$codigo.='</table>';
$codigo.='<table><tr>
    <td style="width:280px;text-align:center;">Totales:</td>   
    <td style="width:140px;text-align:center;">'.number_format($total1, 2, '.', '').'</td>    
    <td style="width:60px;text-align:center;">'.number_format($total2, 2, '.', '').'</td>    
</tr>';
$codigo.='</table>';



$codigo.='</body></html>';
$codigo = utf8_decode($codigo);

$dompdf = new DOMPDF();
$dompdf->load_html($codigo);
ini_set("memory_limit", "100M");
$dompdf->set_paper("A4", "portrait");
$dompdf->render();
$dompdf->stream('factura_compra.pdf', array('Attachment' => 0));
?>