<?php
require('../fdpf/fpdf.php');
include '../procesos/base.php';

date_default_timezone_set('UTC');
$fecha = date("Y-m-d");
function maxCaracter($texto, $cant){        
    $texto = substr($texto, 0,$cant);
    return $texto;
}
class PDF extends FPDF
{
    var $widths;
    var $aligns;

    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths=$w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns=$a;
    }

    function Row($data)
    {
        //Calculate the height of the row
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=5*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            
            //$this->Rect($x,$y,$w,$h);

            $this->MultiCell( $w,5,$data[$i],0,$a,false);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }
    

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r", '', $txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}

    
}
date_default_timezone_set('America/Guayaquil');
$fecha=date('Y-m-d H:i:s', time());   
$pdf = new PDF('L','mm',array(210,170));
$pdf->AddPage();
$pdf->SetMargins(0,0,0,0);
$pdf->AddFont('Amble-Regular');
$pdf->SetFont('Amble-Regular','',14);
$sql = pg_query("SELECT id_factura_venta,nombres_cli,identificacion,fecha_actual,direccion_cli,telefono,celular,tarifa0,tarifa12,iva_venta,descuento_venta,total_venta from factura_venta,clientes where factura_venta.id_cliente = clientes.id_cliente and id_factura_venta = '$_GET[id]'");
$subtotal = 0;
$iva12= 0;
$iva0 = 0;
$total = 0;

while($row = pg_fetch_row($sql)){        
    $pdf->SetFont('Amble-Regular', '', 11);    
    $pdf->Text(40, 46, utf8_decode('' . strtoupper($row[1])), 0, 'C', 0); ////CLIENTE (X,Y)    
    $pdf->Text(40, 52, utf8_decode('' . strtoupper($row[2])), 0, 'C', 0); ////RUC (X,Y)    
    $pdf->Text(140, 52, utf8_decode('' . strtoupper($row[3])), 0, 'C', 0); ///FECHA (X,Y)  
    $pdf->Text(40, 58, utf8_decode('' . strtoupper($row[4])), 0, 'C', 0); ///DIRECCION(X,Y)    
    $pdf->Text(165, 58, utf8_decode('' . strtoupper($row[5])), 0, 'C', 0); ///TELEFONO(X,Y)             
    $pdf->Ln(1);
    $subtotal = $row[8];
    $iva12= $row[9];
    $iva0 = $row[7];
    $total = $row[11];
}
$pdf->SetY(70);///PARA LOS DETALLES
$pdf->SetX(18);
$pdf->SetFont('Amble-Regular', '', 11);
$pdf->SetWidths(array(30, 110, 30, 30));//TAMAÑOS DE LA TABLA DE DETALLES PRODUCTOS
$pdf->SetFillColor(85, 107, 47);
$sql = pg_query("select detalle_factura_venta.cantidad,productos.articulo,detalle_factura_venta.precio_venta,detalle_factura_venta.total_venta from factura_venta,detalle_factura_venta,productos where factura_venta.id_factura_venta=detalle_factura_venta.id_factura_venta and detalle_factura_venta.cod_productos=productos.cod_productos and detalle_factura_venta.id_factura_venta='$_GET[id]'");
$numfilas = pg_num_rows($sql);
for ($i = 0; $i < $numfilas; $i++) {
    $pdf->SetX(18);
    $fila = pg_fetch_row($sql);
    $pdf->SetFont('Amble-Regular', '', 11);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0);    
    $pdf->Row(array(utf8_decode($fila[0]), maxCaracter(utf8_decode($fila[1]),45), utf8_decode($fila[2]), utf8_decode($fila[3])));

    
}
$pdf->SetFont('Amble-Regular', '', 11);
$pdf->Text(192, 155, utf8_decode('' . strtoupper($subtotal)), 0, 'C', 0); ////SUBTOTAL (X,Y)    
$pdf->Text(192, 160, utf8_decode('' . strtoupper($iva12)), 0, 'C', 0); ////IVA12 (X,Y)    
$pdf->Text(192, 165, utf8_decode('' . strtoupper($iva0)), 0, 'C', 0); ///IVA0 (X,Y)  
$pdf->Text(192, 170, utf8_decode('' . strtoupper($total)), 0, 'C', 0); ///TOTAL(X,Y)    

        




$pdf->Output();
?>