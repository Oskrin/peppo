<html>
    <head>
        <title>.:PDF:.</title>
        <script type="text/php">{literal}if ( isset($pdf) ) { 
            $font = Font_Metrics::get_font("helvetica", "bold");
            $pdf->page_text(72, 18, "TEST!", $font, 6, array(0,0,0));}
            {/literal}</script>
    </head>
</html>