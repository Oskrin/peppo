function guardar_factura(){
    var vect1 = new Array();
    var vect2 = new Array();
    var vect3 = new Array();
    var vect4 = new Array();
    var vect5 = new Array();
    var cont=0;
    $("#detalle_factura tbody tr").each(function (index) {                                                                 
        $(this).children("td").each(function (index) {                               
            switch (index) {                                            
                case 0:
                    vect1[cont] = $(this).text();   
                    break; 
                case 3:
                    vect2[cont] = $(this).text();                                       
                    break; 
                case 6:
                    vect3[cont] = $(this).text();                                       
                    break;
                case 7:
                    vect4[cont] = $(this).text();                                       
                    break;
                case 8:
                    vect5[cont] = $(this).text();                                       
                    break;        
            }                          
        });
        cont++;  
    });
  
    if($("#id_proveedor").val() == ""){  
        $('#txt_nro_identificacion').trigger('mousedown');    
        alert("Seleccione un proveedor");
    }else{
        if($("#serie1").val() == ""){
            $("#serie1").focus();
        }else{
            if($("#serie2").val() == ""){
                $("#serie2").focus();
            }else{
                if($("#serie3").val() == ""){
                    $("#serie3").focus();
                    alert("Ingrese la serie");
                }else{
                    if($("#autorizacion").val() == ""){
                        var a = autocompletar($("#serie3").val());
                        $("#serie3").val(a + "" + $("#serie3").val());
                        $("#autorizacion").focus();
                        alert("Ingrese la autorización");
                    }else{
                        if(vect1.length == 0){
                            alert("Ingrese los productos");  
                        }else{
                            var a = autocompletar($("#serie3").val());
                            $("#serie3").val(a + "" + $("#serie3").val());
                            $.ajax({        
                                type: "POST",
                                data: $("#form_facturaCompra").serialize()+"&campo1="+vect1+"&campo2="+vect2+"&campo3="+vect3+"&campo4="+vect4+"&campo5="+vect5+"&hora="+$("#estado").text(),                
                                url: "factura_compra.php",      
                                success: function(data) { 
                                    if( data == 0 ){
                                        alert('Datos Agregados Correctamente');     
                                        setTimeout(function() {
                                            location.reload();
                                        }, 1000);
                                    }
                                }
                            }); 
                        }
                    }
                }
            }
        }
    }
}	


