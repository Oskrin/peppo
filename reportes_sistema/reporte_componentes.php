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
                $this->Text(70,43,utf8_decode("REPORTES DE ORDENES DE PRODUCCIÓN"),0,'C',0);                         
            }                        
            $this->SetDrawColor(0,0,0);
            $this->SetLineWidth(0.5);
            $this->Line(1,45,210,45);
            $this->Ln(10);
            $sql = pg_query("select id_ordenes,id_usuario,ordenes_produccion.codigo,fecha_actual,hora_actual,productos.cod_productos,cantidad,sub_total,articulo from ordenes_produccion,productos where ordenes_produccion.cod_productos = productos.cod_productos and id_ordenes = '".$_GET['id']."'");
            while ($row = pg_fetch_row($sql)) {
                $this->SetFont('Arial','B',9);            
                $this->SetX(1); 
                $this->SetFillColor(187, 179, 180);            
                $this->Cell(50, 6, maxCaracter(utf8_decode('Comprobante:'.$row[0]),17),1,0, 'L',1);                                     
                $this->Cell(98, 6, maxCaracter(utf8_decode('Producto:'.$row[8]),40),1,0, 'L',1);        
                $this->Cell(30, 6, maxCaracter(utf8_decode('Cantidad:'.$row[6]),20),1,0, 'L',1);        
                $this->Cell(30, 6, maxCaracter(utf8_decode('Total:'.$row[7]),20),1,1, 'L',1);        
            }
            $this->SetDrawColor(0,0,0);
            $this->SetLineWidth(0.5);
            $this->Line(1,58,210,58);
            $this->Ln(5);
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
    $sql = pg_query("select cantidad,precio_costo,total_costo,codigo,articulo,stock from detalles_ordenes,productos where detalles_ordenes.cod_productos = productos.cod_productos and id_ordenes = '".$_GET['id']."'");    
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
    while($row = pg_fetch_row($sql)){                        
        $pdf->SetTextColor(0,0,0);
        $pdf->SetX(1);    
        $pdf->Cell(30, 5, maxCaracter(utf8_decode($row[3]),10),0,0, 'L',0);
        $pdf->Cell(62, 5, maxCaracter(utf8_decode($row[4]),25),0,0, 'L',0);
        $pdf->Cell(22, 5, maxCaracter(utf8_decode($row[0]),15),0,0, 'C',0);        
        $pdf->Cell(22, 5, maxCaracter(utf8_decode($row[1]),15),0,0, 'C',0);
        $pdf->Cell(22, 5, maxCaracter(utf8_decode($row[2]),20),0,0, 'C',0);         
        $pdf->Cell(25, 5, maxCaracter(utf8_decode($row[5]),20),0,0, 'C',0);    
        $rr = $rr + $row[2];
        $faltante = $row[5] - $row[0];
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
                                                     
    $pdf->Output();

?>




