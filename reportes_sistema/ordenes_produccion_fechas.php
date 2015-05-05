<?php

session_start();
//include '../fdpf/fpdf.php';
include '../fdpf/rotation.php';
include '../procesos/base.php';
include '../procesos/convertir.php';
include '../procesos/funciones.php';
conectarse();
$letras = new EnLetras();

//header("Content-Type: text/html; charset=iso-8859-1 ");
date_default_timezone_set('UTC');
$fecha = date("Y-m-d");
$anulado = 0;
class PDF extends FPDF
    {   
        var $widths;
        var $aligns;
        function SetWidths($w){            
            $this->widths=$w;
        }                       
        function Header(){                         
            $this->SetFont('Arial','',10);        
            $fecha = date('Y-m-d', time());
            $this->SetX(1);
            $this->SetY(1);
            $this->Cell(20, 5, $fecha, 0,0, 'C', 0);                         
            $this->Cell(150, 5, "CLIENTE", 0,1, 'R', 0);      
            $this->SetFont('Arial','B',16);        
            $sql = pg_query("select ruc_empresa,nombre_empresa,propietario,telefono_empresa,celular_empresa,direccion_empresa,email_empresa,pagina_web,imagen from empresa");
            while($row = pg_fetch_row($sql)){
                $this->Cell(160, 8, maxCaracter(utf8_decode($row[1]),50), 0,1, 'C',0);                                
                //$this->Image('../logos_empresa/'.$row[8],0,8,52,40);
                $this->SetFont('Arial','',9);            
                $this->Cell(170, 5, maxCaracter("PROPIETARIO: ".utf8_decode($row[2]),50),0,1, 'C',0);                                
                $this->Cell(70, 5, maxCaracter("TEL.: ".utf8_decode($row[3]),50),0,0, 'R',0);                                
                $this->Cell(60, 5, maxCaracter("CEL.: ".utf8_decode($row[4]),50),0,1, 'C',0);                                
                $this->Cell(170, 5, maxCaracter("DIR.: ".utf8_decode($row[5]),55),0,1, 'C',0);                                
                $this->Cell(170, 5, maxCaracter("E-MAIL.: ".utf8_decode($row[6]),55),0,1, 'C',0);                                
                $this->Cell(170, 5, maxCaracter("SITIO WEB.: ".utf8_decode($row[7]),55),0,1, 'C',0);                
                $this->SetFont('Arial','B',10);                            
                $this->Cell(85, 6, maxCaracter(utf8_decode('Inicio:'.$_GET['inicio']),17),0,0, 'R',0);                                     
                $this->Cell(98, 6, maxCaracter(utf8_decode('Fin:'.$_GET['fin']),40),0,0, 'L',0);        
                $this->Text(50,48,utf8_decode("REPORTES DE ORDENES DE PRODUCCIÓN POR FECHAS"),0,'C',0);                                         
                
            }                        
            $this->SetDrawColor(0,0,0);
            $this->SetLineWidth(0.5);
            $this->Line(1,49,210,49);
            $this->Ln(12);            
        }
        function Footer(){            
            $this->SetY(-15);            
            $this->SetFont('Arial','I',8);            
            $this->Cell(0,10,'Pag. '.$this->PageNo().'/{nb}',0,0,'C');
        }               
    }
    $pdf = new PDF('P','mm','a4');
    $pdf->AddPage();
    $pdf->SetMargins(0,0,0,0);
    $pdf->AliasNbPages();    
    $pdf->SetFont('Arial','B',9);   
    $pdf->SetX(1);
    $tt = 0;
    
    $sql = pg_query("select id_ordenes,id_usuario,ordenes_produccion.codigo,fecha_actual,hora_actual,productos.cod_productos,cantidad,sub_total,articulo from ordenes_produccion,productos where ordenes_produccion.cod_productos = productos.cod_productos and ordenes_produccion.estado = 'Activo' and fecha_actual between '".$_GET['inicio']."' and '".$_GET['fin']."'");
    while ($row = pg_fetch_row($sql)) {
        $pdf->SetFont('Arial','B',9);            
        $pdf->SetX(1); 
        $pdf->SetFillColor(187, 179, 180);            
        $pdf->Cell(50, 6, maxCaracter(utf8_decode('Comprobante:'.$row[0]),17),1,0, 'L',1);                                     
        $pdf->Cell(98, 6, maxCaracter(utf8_decode('Producto:'.$row[8]),40),1,0, 'L',1);        
        $pdf->Cell(30, 6, maxCaracter(utf8_decode('Cantidad:'.$row[6]),20),1,0, 'L',1);        
        $pdf->Cell(30, 6, maxCaracter(utf8_decode('Total:'.$row[7]),20),1,1, 'L',1);        

        //////////////////////
        $sql1 = pg_query("select cantidad,precio_costo,total_costo,codigo,articulo,stock from detalles_ordenes,productos where detalles_ordenes.cod_productos = productos.cod_productos and id_ordenes = '".$row[0]."'");    
        $pdf->SetX(1);  
        $pdf->Cell(30, 5, "CODIGO",1,0, 'C',0);
        $pdf->Cell(62, 5, utf8_decode("ARTÍCULO"),1,0, 'C',0);
        $pdf->Cell(22, 5, "CANTIDAD",1,0, 'C',0);  
        $pdf->Cell(22, 5, "PRECIO",1,0, 'C',0);    
        $pdf->Cell(22, 5, "TOTAL",1,0, 'C',0);        
        $pdf->Cell(25, 5, "EXISTENCIA",1,0, 'C',0);        
        $pdf->Cell(25, 5, "FALTANTE",1,1, 'C',0);        
        $pdf->SetX(1);    
        $pdf->SetFont('Arial','',9);            
        $rr = 0;
        while($row1 = pg_fetch_row($sql1)){                        
            $pdf->SetTextColor(0,0,0);
            $pdf->SetX(1);    
            $pdf->Cell(30, 5, maxCaracter(utf8_decode($row1[3]),10),0,0, 'L',0);
            $pdf->Cell(62, 5, maxCaracter(utf8_decode($row1[4]),25),0,0, 'L',0);
            $pdf->Cell(22, 5, maxCaracter(utf8_decode($row1[0]),15),0,0, 'C',0);        
            $pdf->Cell(22, 5, maxCaracter(utf8_decode($row1[1]),15),0,0, 'C',0);
            $pdf->Cell(22, 5, maxCaracter(utf8_decode($row1[2]),20),0,0, 'C',0);         
            $pdf->Cell(25, 5, maxCaracter(utf8_decode($row1[5]),20),0,0, 'C',0);    
            $rr = $rr + $row1[2];
            $faltante = $row1[5] - $row1[0];
            if($faltante > 0){
                $pdf->SetTextColor(240,11,11);
                $pdf->Cell(25, 5, utf8_decode('0'),0,1, 'C',0);                             
            }else{
                $pdf->SetTextColor(240,11,11);
                $pdf->Cell(25, 5, utf8_decode(abs($faltante)),0,1, 'C',0);                         
            }        
            $pdf->SetX(1);                  
        }
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(210, 0, "",1,1, 'L',0);   
        $pdf->Cell(137, 5, maxCaracter("TOTAL",10),0,0, 'R',0);
        $pdf->Cell(25, 5, maxCaracter(utf8_decode($rr),25),0,0, 'C',0);
        $pdf->Ln(8);  
        $tt = $tt + $rr;
    }            
    $pdf->SetTextColor(0,0,0);    
    $pdf->Cell(137, 5, maxCaracter("SUMATORIA TOTAL",10),0,0, 'R',0);
    $pdf->Cell(25, 5, maxCaracter(utf8_decode($tt),25),0,0, 'C',0);
    $pdf->Ln(1);  
    //////////////////////////                                                        
    $pdf->Output();

?>



<?php
 $fecha=date('Y-m-d', time());   
require('../dompdf/dompdf_config.inc.php');
session_start();
    $codigo='<html> 
    <head> 
        <link rel="stylesheet" href="../../css/estilosAgrupados.css" type="text/css" /> 
    </head> 
    <body>
        <header>
            <img src="../../images/logo_empresa.jpg" />
            <div id="me">
                <h2 style="text-align:center;border:solid 0px;width:100%;">'.$_SESSION['empresa'].'</h2>
                <h4 style="text-align:center;border:solid 0px;width:100%;">'.$_SESSION['slogan'].'</h4>
                <h4 style="text-align:center;border:solid 0px;width:100%;">'.$_SESSION['propietario'].'</h4>
                <h4 style="text-align:center;border:solid 0px;width:100%;">'.$_SESSION['direccion'].'</h4>
                <h4 style="text-align:center;border:solid 0px;width:100%;">Telf: '.$_SESSION['telefono'].' Cel:  '.$_SESSION['celular'].' '.$_SESSION['pais_ciudad'].'</h4>
                <h4 style="text-align: center;width:50%;display: inline-block;">Desde el : '.$_GET['inicio'].'</h4>
                <h4 style="text-align: center;width:45%;display: inline-block;">Hasta el : '.$_GET['fin'].'</h4>
            </div>       
    </header>        
    <hr>
    <div id="linea">
        <h3>ORDENES DE PRODUCCION POR FECHAS</h3>
    </div>';
    include '../../procesos/base.php';
    conectarse();    
    $total=0;
    $sub=0;
    $repetido=0;   
    $contador=0; 
    $consulta=pg_query("select id_usuario,ci_usuario,nombre_usuario,apellido_usuario,telefono_usuario,direccion_usuario from usuario;");
    while($row=pg_fetch_row($consulta)){
        $repetido=0;
        $total=0;
        $sql1=pg_query("select comprobante,fecha_actual,codigo,articulo,cantidad,precio_compra,sub_total from ordenes_produccion,usuario,productos where  ordenes_produccion.id_usuario = usuario.id_usuario and ordenes_produccion.cod_productos = productos.cod_productos and fecha_actual between '".$_GET['inicio']."' and '".$_GET['fin']."' and usuario.id_usuario='$row[0]'");
        if(pg_num_rows($sql1)){
            if($repetido==0){
                $codigo.='<h2 style="color:#1B8D72;font-weight: bold;font-size:13px;">RUC/CI: '.$row[1].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row[2].' '.$row[3].'</h2>';
                $codigo.='<h2 style="color:#1B8D72;font-weight: bold;font-size:13px;">TELF: '.$row[4].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DIRECCIÓN '.$row[5].'</h2>';

                $codigo.='<table>';                      
                $codigo.='<tr>                
                <td style="width:70px;text-align:center;">Comprobante</td>    
                <td style="width:70px;text-align:center;">Fecha</td>
                <td style="width:150px;text-align:center;">Código</td>
                <td style="width:250px;text-align:center;">Artículo</td>
                <td style="width:50px;text-align:center;">Cantidad</td>
                <td style="width:70px;text-align:center;">P. Costo</td>
                <td style="width:80px;text-align:center;">T. Costo</td>
                </tr><hr>';
                $codigo.='</table>';         
                $repetido=1;
            }
            $codigo.='<table style="font-size:11px;">';
            while($row1=pg_fetch_row($sql1)){
                $codigo.='<tr>
                <td style="width:70px;text-align:center;">'.' '.$row1[0].'</td>    
                <td style="width:70px;text-align:center;">'.' '.$row1[1].'</td>
                <td style="width:150px;text-align:center;">'.' '.$row1[2].'</td>
                <td style="width:250px;text-align:center;">'.' '.$row1[3].'</td>
                <td style="width:50px;text-align:center;">'.' '.$row1[4].'</td>
                <td style="width:70px;text-align:center;">'.' '.$row1[5].'</td>
                <td style="width:80px;text-align:center;">'.' '.$row1[6].'</td>
                
                
                </tr>';
            }
            $codigo.='</table><br/>';    
           
        }
        
    }
    $codigo=utf8_decode($codigo);
    $dompdf= new DOMPDF();
    $dompdf->load_html($codigo);
    ini_set("memory_limit","1000M");
    $dompdf->set_paper("A4","portrait");
    $dompdf->render();
    //$dompdf->stream("reporteRegistro.pdf");
    $dompdf->stream('reporte_autorizacion_caducidad.pdf',array('Attachment'=>0));
?>