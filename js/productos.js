$(document).on("ready", inicio);
function evento(e) {
    e.preventDefault();
}

$(function() {
    $('#main-menu').smartmenus({
        subMenusSubOffsetX: 1,
        subMenusSubOffsetY: -8
    });
});

function scrollToBottom() {
    $('html, body').animate({
        scrollTop: $(document).height()
    }, 'slow');
}

function scrollToTop() {
    $('html, body').animate({
        scrollTop: 0
    }, 'slow');
}

var dialogos =
{
    autoOpen: false,
    resizable: false,
    width: 860,
    height: 350,
    modal: true
};

var dialogos_categoria =
{
    autoOpen: false,
    resizable: false,
    width: 230,
    height: 180,
    modal: true
};

var dialogos_marca =
{
    autoOpen: false,
    resizable: false,
    width: 230,
    height: 180,
    modal: true
};

var dialogos_unidad =
{
    autoOpen: false,
    resizable: false,
    width: 250,
    height: 250,
    modal: true
};

var dialogo3 =
{
    autoOpen: false,
    resizable: false,
    width: 400,
    height: 210,
    modal: true,
    position: "top",
    show: "explode",
    hide: "blind"    
}

var dialogo4 ={
    autoOpen: false,
    resizable: false,
    width: 240,
    height: 150,
    modal: true,
    position: "top",
    show: "explode",
    hide: "blind"
}

var dialogo5 ={
    autoOpen: false,
    resizable: false,
    width: 500,
    height: 400,
    modal: true,
    position: "top",
    show: "explode",
    hide: "blind"
}

function abrirDialogo() {
    $("#productos").dialog("open");
}

function abrirCategoria() {
    $("#categorias").dialog("open");
}

function abrirMarca() {
    $("#marcas").dialog("open");
}

function abrirUnidades() {
    $("#unidades").dialog("open");
}

function guardar_producto(){
    var v1 = new Array();
    var v2 = new Array();
    var v3 = new Array();
    var v4 = new Array();
    var v5 = new Array();
    var string_v1 = "";
    var string_v2 = "";
    var string_v3 = "";
    var string_v4 = "";
    var string_v5 = "";
    var fil2 = jQuery("#list2").jqGrid("getRowData");
    
    for (var i = 0; i < fil2.length; i++) {
        var datos2 = fil2[i];
        v1[i] = datos2['cod_productos'];
        v2[i] = datos2['detalle'];
        v3[i] = datos2['cantidad'];
        v4[i] = datos2['precio_u'];
        v5[i] = datos2['total'];
    }
    for (i = 0; i < fil2.length; i++) {
        string_v1 = string_v1 + "|" + v1[i];
        string_v2 = string_v2 + "|" + v2[i];
        string_v3 = string_v3 + "|" + v3[i];
        string_v4 = string_v4 + "|" + v4[i];
        string_v5 = string_v5 + "|" + v5[i];
    }
    //////////////////////////////
    
    if ($("#cod_prod").val() === "") {
        $("#cod_prod").focus();
        alertify.error("Indique un Código");
    } else {
        if ($("#nombre_art").val() === "") {
            $("#nombre_art").focus();
            alertify.error("Nombre del producto");
        } else {
            if ($("#iva").val() === "") {
                $("#iva").focus();
                alertify.error("Seleccione una opción");
            } else {
                if ($("#precio_compra").val() === "") {
                    $("#precio_compra").focus();
                    alertify.error("Indique un precio");
                } else {
                    if ($("#series").val() === "") {
                        $("#series").focus();
                        alertify.error("Seleccione una opción");
                    } else {
                        if ($("#precio_minorista").val() === "") {
                            $("#precio_minorista").focus();
                            alertify.error("Ingrese precio minorista");
                        } else {
                            if ($("#precio_mayorista").val() === "") {
                                $("#precio_mayorista").focus();
                                alertify.error("Ingrese precio mayorista");
                            } else {
                                $.ajax({        
                                    type: "POST",
                                    data: $("#productos_form").serialize()+"&campo1="+string_v1+"&campo2="+string_v2+"&campo3="+string_v3+"&campo4="+string_v4+"&campo5="+string_v5,                
                                    url: "../procesos/guardar_productos.php",      
                                    success: function(data) { 
                                        if( data == 1 ){
                                            alertify.alert("Datos Agregados Correctamente",function(e){
                                                location.reload(); 
                                            });
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
}

function modificar_producto(){
    if ($("#cod_productos").val() === "") {
        alertify.error("Seleccione un producto");
    } else {
        if ($("#cod_prod").val() === "") {
            $("#cod_prod").focus();
            alertify.error("Indique un Código");
        } else {
            if ($("#nombre_art").val() === "") {
                $("#nombre_art").focus();
                alertify.error("Nombre del producto");
            } else {
                if ($("#iva").val() === "") {
                    $("#iva").focus();
                    alertify.error("Seleccione una opción");
                } else {
                    if ($("#precio_compra").val() === "") {
                        $("#precio_compra").focus();
                        alertify.error("Indique un precio");
                    } else {
                        if ($("#series").val() === "") {
                            $("#series").focus();
                            alertify.error("Seleccione una opción");
                        } else {
                            if ($("#precio_minorista").val() === "") {
                                $("#precio_minorista").focus();
                                alertify.error("Ingrese precio minorista");
                            } else {
                                if ($("#precio_mayorista").val() === "") {
                                    $("#precio_mayorista").focus();
                                    alertify.error("Ingrese precio mayorista");
                                } else {
                                    //                                    if ($("#medida").val() === "") {
                                    //                                    $("#medida").focus();
                                    //                                    alertify.error("Seleccione una opción");
                                    //                                }else{
                                    $("#productos_form").submit(function(e) {
                                        var formObj = $(this);
                                        var formURL = formObj.attr("action");
                                        if(window.FormData !== undefined) {	
                                            var formData = new FormData(this);   
                                            formURL=formURL; 
                                            
                                            $.ajax({
                                                url: "../procesos/modificar_productos.php",
                                                type: "POST",
                                                data:  formData,
                                                mimeType:"multipart/form-data",
                                                contentType: false,
                                                cache: false,
                                                processData:false,
                                                success: function(data, textStatus, jqXHR) {
                                                    var res=data;
                                                    if(res == 1){
                                                        alertify.alert("Datos Modificados Correctamente",function(){
                                                            location.reload();
                                                        });
                                                    } else{
                                                        alertify.error("Error..... Datos no Modificados");
                                                    }
                                                },
                                                error: function(jqXHR, textStatus, errorThrown) 
                                                {
                                                } 	        
                                            });
                                            e.preventDefault();
                                        } else {
                                            var  iframeId = "unique" + (new Date().getTime());
                                            var iframe = $('<iframe src="javascript:false;" name="'+iframeId+'" />');
                                            iframe.hide();
                                            formObj.attr("target",iframeId);
                                            iframe.appendTo("body");
                                            iframe.load(function(e) {
                                                var doc = getDoc(iframe[0]);
                                                var docRoot = doc.body ? doc.body : doc.documentElement;
                                                var data = docRoot.innerHTML;
                                            });
                                        }
                                    });
                                    $("#productos_form").submit();
                                }
                            }
                        //                            }
                        }
                    }
                }
            }
        }
    }     
}


function eliminar_productos() {
    if ($("#cod_productos").val() === "") {
        alertify.alert("Seleccione un producto");
    } else {
        $("#clave_permiso").dialog("open");  
    }
}

function validar_acceso(){
    if($("#clave").val() == ""){
        $("#clave").focus();
        alertify.alert("Ingrese la clave");
    }else{
        $.ajax({
            url: '../procesos/validar_acceso.php',
            type: 'POST',
            data: "clave=" + $("#clave").val(),
            success: function(data) {
                var val = data;
                if (val == 0) {
                    $("#clave").val("");
                    $("#clave").focus();
                    alertify.alert("Error... La clave es incorrecta ingrese nuevamente");
                } else {
                    if (val == 1) {
                        $("#seguro").dialog("open");   
                    }
                }
            }
        });
    }   
}

function aceptar(){
    $.ajax({
        type: "POST",
        url: "../procesos/eliminar_productos.php",
        data: "cod_productos=" + $("#cod_productos").val(),
        success: function(data) {
            var val = data;
            if (val == 1) {
                alertify.alert("Error... El Producto tiene movimientos en el sistema",function(){
                    location.reload();
                });
            }else{
                alertify.alert("Producto Eliminado Correctamente",function(){
                    location.reload();
                });
            }
        }
    }); 
}

function cancelar(){
    $("#seguro").dialog("close");   
    $("#clave_permiso").dialog("close");    
    $("#clave").val("");    
}

function cancelar_acceso(){
    $("#clave_permiso").dialog("close");     
    $("#clave").val("");
}

function nuevo_producto() {
    location.reload();
}

function agregar_categoria() {
    if ($("#nombre_categoria").val() === "") {
        $("#nombre_categoria").focus();
        alertify.error("Nombre Categoria");
    }else{
        $.ajax({
            type: "POST",
            url: "../procesos/guardar_categoria.php",
            data: "nombre_categoria=" + $("#nombre_categoria").val(),
            success: function(data) {
                var val = data;
                if (val == 1) {
                    $("#nombre_categoria").val("");
                    $("#categoria").load("../procesos/categorias_combos.php");
                    $("#categorias").dialog("close");
                }else{
                    $("#nombre_categoria").val("");
                    alertify.error("Error.... La categoria ya existe");
                }
            }
        });
    }
}

function agregar_marca() {
    if ($("#nombre_marca").val() === "") {
        $("#nombre_marca").focus();
        alertify.error("Nombre Marca");
    }else{
        $.ajax({
            type: "POST",
            url: "../procesos/guardar_marca.php",
            data: "nombre_marca=" + $("#nombre_marca").val(),
            success: function(data) {
                var val = data;
                if (val == 1) {
                    $("#nombre_marca").val("");
                    $("#marca").load("../procesos/marcas_combos.php");
                    $("#marcas").dialog("close");
                }else{
                    $("#nombre_marca").val("");
                    alertify.error("Error.... La marca ya existe");
                }
            }
        });
    }
}

function agregar_unidades() {
    if ($("#descripcion").val() === "") {
        $("#descripcion").focus();
        alertify.error("Unidad de medida");
    }else{
        if ($("#abreviatura").val() === "") {
            $("#abreviatura").focus();
            alertify.error("Ingrese Abreviatura");
        }else{
            $.ajax({
                type: "POST",
                url: "../procesos/guardar_medidas.php",
                data: "descripcion=" + $("#descripcion").val()+ "&abreviatura=" + $("#abreviatura").val() ,
                success: function(data) {
                    var val = data;
                    if (val == 1) {
                        $("#descripcion").val("");
                        $("#medida").load("../procesos/unidades_combos.php");
                        $("#unidades").dialog("close");
                    }else{
                        $("#descripcion").val("");
                        alertify.error("Error.... La unidad de medida ya existe");
                    }
                }
            });
        }
    }
}


function Valida_punto() {
    var key;
    if (window.event)
    {
        key = event.keyCode;
    } else if (event.which)
{
        key = event.which;
    }

    if (key < 48 || key > 57)
    {
        if (key === 46 || key === 8)
        {
            return true;
        } else {
            return false;
        }
    }
    return true;
}

function ValidNum() {
    if (event.keyCode < 48 || event.keyCode > 57) {
        event.returnValue = false;
    }
    return true;
}

function enter(e) {
    if (e.which === 13 || e.keyCode === 13) {
        porcenta();
        return false;
    }
    return true;
}

function enter2(e) {
    if (e.which === 13 || e.keyCode === 13) {
        porcenta2();
        return false;
    }
    return true;
}

function enter3(event) {
    if (event.which === 13 || event.keyCode === 13) {
        entrar2();
        return false;
    }
    return true;
}

function entrar2() {
    if ($("#cod_producto2").val() === "") {
        $("#codigo2").focus();
        alertify.alert("Ingrese un producto");
    } else {
        if ($("#producto2").val() === "") {
            $("#producto2").focus();
            alertify.alert("Ingrese un producto");
        } else {
            if ($("#cantidad2").val() === "") {
                $("#cantidad2").focus();
            //  alertify.alert("Ingrese una cantidad");
            } else {
                if ($("#precio2").val() === "") {
                    $("#precio2").focus();
                    alertify.alert("Ingrese precio costo");
                } else {
                    if ($("#cantidad2").val() === "0") {
                        $("#cantidad2").val("");
                        $("#cantidad2").focus();
                        alertify.alert("Ingrese una cantidad válida");
                    } else {
                        //                        if (parseInt($("#cantidad2").val()) <= parseInt($("#disponibles").val())) {
                        var filas = jQuery("#list2").jqGrid("getRowData");
                        var su = 0;
                        var total = 0;
                        if (filas.length === 0) {
                            total = ($("#cantidad2").val() * $("#precio2").val()).toFixed(2);
                            var datarow = {
                                cod_productos: $("#cod_producto2").val(), 
                                codigo: $("#codigo2").val(), 
                                detalle: $("#producto2").val(), 
                                cantidad: $("#cantidad2").val(), 
                                precio_u: $("#precio2").val(), 
                                total: total,
                                stock: $("#disponibles").val()
                            // oculto: $("#cantidad2").val() 
                            };
                            su = jQuery("#list2").jqGrid('addRowData', $("#cod_producto2").val(), datarow);
                            $("#cod_producto2").val("");
                            $("#codigo2").val("");
                            $("#producto2").val("");
                            $("#cantidad2").val("");
                            $("#precio2").val("");
                            $("#p_venta2").val("");
                            $("#disponibles").val("");
                        } else {
                            var repe = 0;
                            for (var i = 0; i < filas.length; i++) {
                                var id = filas[i];
                                if (id['cod_productos'] === $("#cod_producto2").val()) {
                                    repe = 1;
                                }
                            }
                            if (repe === 1) {
                                total = ($("#cantidad2").val() * $("#precio2").val()).toFixed(2);
                                datarow = {
                                    cod_productos: $("#cod_producto2").val(), 
                                    codigo: $("#codigo2").val(), 
                                    detalle: $("#producto2").val(), 
                                    cantidad: $("#cantidad2").val(), 
                                    precio_u: $("#precio2").val(), 
                                    total: total,
                                    stock: $("#disponibles").val()
                                //oculto: $("#cantidad2").val() 
                                };
                                su = jQuery("#list2").jqGrid('setRowData', $("#cod_producto2").val(), datarow);
                                $("#cod_producto2").val("");
                                $("#codigo2").val("");
                                $("#producto2").val("");
                                $("#cantidad2").val("");
                                $("#precio2").val("");
                                $("#p_venta2").val("");
                                $("#disponibles").val("");
                            } else {
                                total = ($("#cantidad2").val() * $("#precio2").val()).toFixed(2);
                                datarow = {
                                    cod_productos: $("#cod_producto2").val(), 
                                    codigo: $("#codigo2").val(), 
                                    detalle: $("#producto2").val(), 
                                    cantidad: $("#cantidad2").val(), 
                                    precio_u: $("#precio2").val(), 
                                    total: total,
                                    stock: $("#disponibles").val()
                                //oculto: $("#cantidad2").val() 
                                };
                                su = jQuery("#list2").jqGrid('addRowData', $("#cod_producto2").val(), datarow);
                                $("#cod_producto2").val("");
                                $("#codigo2").val("");
                                $("#producto2").val("");
                                $("#cantidad2").val("");
                                $("#precio2").val("");
                                $("#p_venta2").val("");
                                $("#disponibles").val("");
                            }
                        }

                        var fil = jQuery("#list2").jqGrid("getRowData");
                        var subtotal = 0;
                        for (var t = 0; t < fil.length; t++) {
                            var dd = fil[t];
                            subtotal = (subtotal + parseFloat(dd['total']));
                            var sub = parseFloat(subtotal).toFixed(2);
                        }
                        $("#subtot").val(sub);
                        $("#codigo2").focus();
                    //                        } else {
                    //                            $("#cantidad2").focus();
                    //                            alertify.alert("Error... Fuera de stock");
                    //                        }
                    }
                }
            }
        }
    }
}

function porcenta(){
    var resta = parseFloat($("#precio_minorista").val() - $("#precio_compra").val());
    var entero = resta * 100;
    var val = Math.round(entero / parseFloat($("#precio_compra").val()));
    $("#utilidad_minorista").val(val); 
}

function porcenta2(){
    var resta = parseFloat($("#precio_mayorista").val() - $("#precio_compra").val());
    var entero = resta * 100;
    var val = Math.round(entero / parseFloat($("#precio_compra").val()));
    $("#utilidad_mayorista").val(val);    
}

function tab(){
    alert("dsf");
    
}


function inicio() {
    
    alertify.set({
        delay: 1000
    });
    jQuery().UItoTop({
        easingType: 'easeOutQuart'
    });
    
    $("#cod_prod").focus();
    
    //////////////////para cargar fotos/////////////
    function getDoc(frame) {
        var doc = null;     
     	
        try {
            if (frame.contentWindow) {
                doc = frame.contentWindow.document;
            }
        } catch(err) {
        }
        if (doc) { 
            return doc;
        }
        try { 
            doc = frame.contentDocument ? frame.contentDocument : frame.document;
        } catch(err) {
       
            doc = frame.document;
        }
        return doc;
    }
    //////////////////////////
    
    
    /////////////////verificar repetidos/////////////
    /////valida si ya existe/////
    $("#cod_prod").keyup(function() {
        $.ajax({
            type: "POST",
            url: "../procesos/comparar_codigo.php",
            data: "codigo=" + $("#cod_prod").val(),
            success: function(data) {
                var val = data;
                if (val == 1) {
                    $("#cod_prod").val("");
                    $("#cod_prod").focus();
                    alertify.error("Error... El código ya existe");
                }
            }
        });
    });
    
    $("#cod_barras").keyup(function() {
        $.ajax({
            type: "POST",
            url: "../procesos/comparar_codigo2.php",
            data: "codigo=" + $("#cod_barras").val(),
            success: function(data) {
                var val = data;
                if (val == 1) {
                    $("#cod_barras").val("");
                    $("#cod_barras").focus();
                    alertify.error("Error... El código ya existe");
                }
            }
        });
    });
    /////////////////////////////////////////////////

    /////////atributos/////////////
    $("#utilidad_minorista").attr("maxlength", "5");
    $("#utilidad_mayorista").attr("maxlength", "5");
    $("#precio_compra").keypress(Valida_punto);
    $("#precio_minorista").keypress(Valida_punto);
    $("#precio_mayorista").keypress(Valida_punto);
    $("#utilidad_minorista").keypress(ValidNum);
    $("#utilidad_mayorista").keypress(ValidNum);
    $("#descuento").keypress(ValidNum);
    $("#stock").keypress(Valida_punto);
    $("#stock").attr("maxlength", "5");
    $("#maximo").keypress(Valida_punto);
    $("#maximo").attr("maxlength", "5");
    $("#minimo").keypress(Valida_punto);
    $("#minimo").attr("maxlength", "5");
    ////////////////////////////
    
    $("#precio_minorista").on("keypress", enter);
    $("#precio_mayorista").on("keypress", enter2);
    
    $("#codigo2").on("keypress", enter3);
    $("#producto2").on("keypress", enter3);
    $("#cantidad2").on("keypress", enter3);
    $("#precio2").on("keypress", enter3);

    /////////botones/////////////
    $("#btnCategoria").click(function(e) {
        e.preventDefault();
    });
    $("#btnMarca").click(function(e) {
        e.preventDefault();
    });
    $("#btnGuardarCategoria").click(function(e) {
        e.preventDefault();
    });
    $("#btnGuardarMarca").click(function(e) {
        e.preventDefault();
    });
    $("#btnGuardar").click(function(e) {
        e.preventDefault();
    });
    $("#btnModificar").click(function(e) {
        e.preventDefault();
    });
    $("#btnEliminar").click(function(e) {
        e.preventDefault();
    });
    $("#btnBuscar").click(function(e) {
        e.preventDefault();
    });
    $("#btnNuevo").click(function(e) {
        e.preventDefault();
    });
    
    $("#btnGuardarCategoria").on("click", agregar_categoria);
    $("#btnGuardarMarca").on("click", agregar_marca);
    $("#btnGuardarUnidad").on("click", agregar_unidades);
    $("#btnGuardar").on("click", guardar_producto);
    $("#btnModificar").on("click", modificar_producto);
    $("#btnNuevo").on("click", nuevo_producto);
    $("#btnCategoria").on("click", abrirCategoria);
    $("#btnMarca").on("click", abrirMarca);
    $("#btnUnidades").on("click", abrirUnidades);
    $("#btnBuscar").on("click", abrirDialogo);
    $("#btnEliminar").on("click", eliminar_productos);
    $("#btnAceptar").on("click", aceptar);
    $("#btnSalir").on("click", cancelar);
    $("#btnAcceder").on("click", validar_acceso);
    $("#btnCancelar").on("click", cancelar_acceso);
    $("#productos").dialog(dialogos);
    $("#categorias").dialog(dialogos_categoria);
    $("#marcas").dialog(dialogos_marca);
    $("#unidades").dialog(dialogos_unidad);
    $("#clave_permiso").dialog(dialogo3);
    $("#seguro").dialog(dialogo4);
    ///////////////////////////////////////////////
      
    /////////calendarios///////
    $("#fecha_creacion").datepicker({
        dateFormat: 'yy-mm-dd'
    }).datepicker('setDate', 'today');
    //////////////////////////////////////////

    ////calcular datos////////////////////////
    $("#utilidad_minorista").keyup(function() {
        if($("#precio_compra").val() === ""){
            $("#precio_compra").focus();   
            $("#utilidad_minorista").val(""); 
            alertify.error("Error... Ingrese precio compra");
        }else{
            if ($("#utilidad_minorista").val() === "") {
                $("#precio_minorista").val("");
            }else {
                var precio_minorista = ((parseFloat($("#precio_compra").val()) * parseFloat($("#utilidad_minorista").val())) / 100) + parseFloat($("#precio_compra").val());
                var entero = precio_minorista.toFixed(2);
                $("#precio_minorista").val(entero);
            }
        }
    });
    ///////////////////////////////////////////

    $("#utilidad_mayorista").keyup(function() {
        if($("#precio_compra").val() === ""){
            $("#precio_compra").focus();   
            $("#utilidad_mayorista").val("");
            alertify.error("Error... Ingrese precio compra");
        }else{
            if ($("#utilidad_mayorista").val() === "") {
                $("#precio_mayorista").val("");
            } else {
                var precio_mayorista = ((parseFloat($("#precio_compra").val()) * parseFloat($("#utilidad_mayorista").val())) / 100) + parseFloat($("#precio_compra").val());
                var entero2 = precio_mayorista.toFixed(2);
                $("#precio_mayorista").val(entero2);
            }
        }
    });
    //////////////////////////

    ////////////////calcular datos 2//////////////////
    $("#precio_minorista").keyup(function() {
        if($("#precio_compra").val() === ""){
            $("#precio_minorista").val("");
            $("#precio_compra").focus();  
            alertify.error("Error... Ingrese precio compra");
        }else{
            if ($("#precio_minorista").val() === "") {
                $("#utilidad_minorista").val("");
            }
        }
    });
    /////////////////////////////////////////////////

    ////////////////calcular datos 2//////////////////
    $("#precio_mayorista").keyup(function() {
        if($("#precio_compra").val() === ""){
            $("#precio_mayorista").val("");
            $("#precio_compra").focus();  
            alertify.error("Error... Ingrese precio compra");
        }else{
            if ($("#precio_mayorista").val() === "") {
                $("#utilidad_mayorista").val("");
            }
        }
    });

    /////////////////////////////////////////////////
    
    /////buscador componentes///// 
    $("#codigo2").autocomplete({
        source: "../procesos/buscar_producto5.php",
        minLength: 1,
        focus: function(event, ui) {
        $("#codigo2").val(ui.item.value);
        $("#cod_producto2").val(ui.item.cod_producto2);
        $("#producto2").val(ui.item.producto2);
        $("#precio2").val(ui.item.precio2);
        $("#disponibles").val(ui.item.disponibles);
        return false;
        },
        select: function(event, ui) {
        $("#codigo2").val(ui.item.value);
        $("#cod_producto2").val(ui.item.cod_producto2);
        $("#producto2").val(ui.item.producto2);
        $("#precio2").val(ui.item.precio2);
        $("#disponibles").val(ui.item.disponibles);
        return false;
        }

        }).data("ui-autocomplete")._renderItem = function(ul, item) {
        return $("<li>")
        .append("<a>" + item.value + "</a>")
        .appendTo(ul);
    };
    //////////////////////////////

    /////buscador productos2 segunda tabla///// 
    $("#producto2").autocomplete({
        source: "../procesos/buscar_producto6.php",
        minLength: 1,
        focus: function(event, ui) {
        $("#producto2").val(ui.item.value);
        $("#cod_producto2").val(ui.item.cod_producto2);
        $("#codigo2").val(ui.item.codigo2);
        $("#precio2").val(ui.item.precio2);
        $("#disponibles").val(ui.item.disponibles);
        return false;
        },
        select: function(event, ui) {
        $("#producto2").val(ui.item.value);
        $("#cod_producto2").val(ui.item.cod_producto2);
        $("#codigo2").val(ui.item.codigo2);
        $("#precio2").val(ui.item.precio2);
        $("#disponibles").val(ui.item.disponibles);
        return false;
        }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
        return $("<li>")
        .append("<a>" + item.value + "</a>")
        .appendTo(ul);
    };
//////////////////////////////

    //////////////tabla Productos////////////////
    jQuery("#list").jqGrid({
        url: '../xml/datos_productos.php',
        datatype: 'xml',
        colNames: ['ID', 'CÓDIGO', 'CÓDIGO BARRAS', 'ARTICULO', 'IVA', 'SERIES', 'PRECIO COMPRA', 'UTILIDAD MINORISTA', 'PRECIO MINORISTA', 'UTILIDAD MAYORISTA', 'PRECIO MAYORISTA', 'CATEGORIA', 'MARCA', 'DESCUENTO', 'STOCK', 'MÍNIMO', 'MÁXIMO', 'FECHA COMPRA', 'CARACTERISTICAS', 'OBSERVACIONES', 'ESTADO','INVENTARIABLE','UNIDADES'],
        colModel: [
            {name: 'cod_productos', index: 'cod_productos', editable: true, align: 'center', width: '60', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'cod_prod', index: 'cod_prod', editable: true, align: 'center', width: '120', search: true, frozen: true, formoptions: {elmsuffix: " (*)"}, editrules: {required: true}},
            {name: 'cod_barras', index: 'cod_barras', editable: true, align: 'center', width: '120', search: true, frozen: true, formoptions: {elmsuffix: " (*)"}, editrules: {required: true}},
            {name: 'nombre_art', index: 'nombre_art', editable: true, align: 'center', width: '180', search: true, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'iva', index: 'iva', editable: true, align: 'center', width: '50', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'series', index: 'series', editable: true, align: 'center', width: '50', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'precio_compra', index: 'precio_compra', editable: true, align: 'center', width: '120', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'utilidad_minorista', index: 'utilidad_minorista', editable: true, align: 'center', hidden: true, width: '120', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'precio_minorista', index: 'precio_minorista', editable: true, align: 'center', width: '120', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'utilidad_mayorista', index: 'utilidad_mayorista', editable: true, align: 'center', hidden: true, width: '120', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'precio_mayorista', index: 'precio_mayorista', editable: true, align: 'center', width: '120', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'categoria', index: 'categoria', editable: true, align: 'center', width: '120', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'marca', index: 'marca', editable: true, align: 'center', width: '120', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'descuento', index: 'descuento', editable: true, align: 'center', width: '120', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'stock', index: 'stock', editable: true, align: 'center', width: '120', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'minimo', index: 'minimo', editable: true, align: 'center', width: '120', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'maximo', index: 'maximo', editable: true, align: 'center', width: '120', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'fecha_creacion', index: 'fecha_creacion', editable: true, align: 'center', width: '120', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'modelo', index: 'modelo', editable: true, align: 'center', width: '120', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'aplicacion', index: 'aplicacion', editable: true, align: 'center', width: '120', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'vendible', index: 'vendible', editable: true, align: 'center',hidden: true, width: '120', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'inventario', index: 'inventario', editable: true, align: 'center',hidden: true , width: '120', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
            {name: 'medida', index: 'medida', editable: true, align: 'center',hidden: false , width: '120', search: false, frozen: true, editoptions: {readonly: 'readonly'}, formoptions: {elmprefix: ""}},
        ],
        rowNum: 10,
        width: 830,
        height: 200,
        rowList: [10, 20, 30],
        pager: jQuery('#pager'),
        sortname: 'cod_productos',
        shrinkToFit: false,
        sortorder: 'asc',
        caption: 'Lista de Productos',
        editurl: 'procesos/estadio_del.php',
        viewrecords: true,
         ondblClickRow: function(){
         var id = jQuery("#list").jqGrid('getGridParam', 'selrow');
         jQuery('#list').jqGrid('restoreRow', id);   
         jQuery("#list").jqGrid('GridToForm', id, "#productos_form");
         $("#btnGuardar").attr("disabled", true);
//         document.getElementById("cod_prod").readOnly = true;
         $("#productos").dialog("close");      
         }
    }).jqGrid('navGrid', '#pager',
            {
                add: false,
                edit: false,
                del: false,
                refresh: true,
                search: true,
                view: false
            },
    {
        recreateForm: true, closeAfterEdit: true, checkOnUpdate: true, reloadAfterSubmit: true, closeOnEscape: true
    },
    {
        reloadAfterSubmit: true, closeAfterAdd: true, checkOnUpdate: true, closeOnEscape: true,
        bottominfo: "Todos los campos son obligatorios son obligatorios"
    },
    {
        width: 300, closeOnEscape: true
    },
    {
        closeOnEscape: true,
        multipleSearch: false, overlay: false
    },
    {
    },
            {
                closeOnEscape: true
            }
    );
    /////////////////		
    jQuery("#list").jqGrid('navButtonAdd', '#pager', {caption: "Añadir",
        onClickButton: function() {
            var id = jQuery("#list").jqGrid('getGridParam', 'selrow');
            jQuery('#list').jqGrid('restoreRow', id);
            var ret = jQuery("#list").jqGrid('getRowData', id);

            if (id) {
                jQuery("#list").jqGrid('GridToForm', id, "#productos_form");
                $("#btnGuardar").attr("disabled", true);
//                document.getElementById("cod_prod").readOnly = true;
                var valor = ret.cod_productos;

                $("#codigo2").attr("disabled", "disabled");
                $("#producto2").attr("disabled", "disabled");
                $("#cantidad2").attr("disabled", "disabled");
                $("#precio2").attr("disabled", "disabled");

                $("#list2").jqGrid("clearGridData", true);
                $("#subtot").val("0.00");

                ////////////////////llamar facturas flechas tercera parte/////
                $.getJSON('../procesos/retornar_componentes.php?com=' + valor, function(data) {
                    var tama = data.length;
                    if (tama !== 0) {
                        for (var i = 0; i < tama; i = i + 5) {
                            var datarow = {
                                cod_productos: data[i], 
                                codigo: data[i + 1], 
                                detalle: data[i + 2], 
                                cantidad: data[i + 3], 
                                precio_u: data[i + 4], 
                                // total: data[i + 5]
                                };
                            var su = jQuery("#list2").jqGrid('addRowData', data[i], datarow);
                        }
                    }
                });
            $("#productos").dialog("close");
            } else {
                alertify.alert("Seleccione un fila");
            }

        }
    });
///////////////////fin tabla productos////////////   

   //////////////////////tabla productos/////////////////////////
    jQuery("#list2").jqGrid({
        datatype: "local",
        colNames: ['', 'ID', 'Código', 'Producto', 'Cantidad', 'Precio Costo', 'Total'],
        colModel: [
            {name: 'myac', width: 50, fixed: true, sortable: false, resize: false, formatter: 'actions',
                formatoptions: {keys: false, delbutton: true, editbutton: false}
            },
            {name: 'cod_productos', index: 'cod_productos', editable: false, search: false, hidden: true, editrules: {edithidden: false}, align: 'center',
                frozen: true, width: 50},
            {name: 'codigo', index: 'codigo', editable: false, search: false, hidden: false, editrules: {edithidden: false}, align: 'center',
                frozen: true, width: 100},
            {name: 'detalle', index: 'detalle', editable: false, frozen: true, editrules: {required: true}, align: 'center', width: 290},
            {name: 'cantidad', index: 'cantidad', editable: false, frozen: true, editrules: {required: true}, align: 'center', width: 70},
            {name: 'precio_u', index: 'precio_u', editable: false, search: false, frozen: true, editrules: {required: true}, align: 'center', width: 110},
            {name: 'total', index: 'total', editable: false, search: false, frozen: true, editrules: {required: true}, align: 'center', width: 110},
        ],
        rowNum: 30,
        width: 780,
        sortable: true,
        rowList: [10, 20, 30],
        pager: jQuery('#pager2'),
        sortname: 'cod_productos',
        sortorder: 'asc',
        viewrecords: true,
        cellEdit: true,
        cellsubmit: 'clientArray',
        shrinkToFit: true,
        delOptions: {
            onclickSubmit: function(rp_ge, rowid) {
                var id = jQuery("#list2").jqGrid('getGridParam', 'selrow');
                jQuery('#list2').jqGrid('restoreRow', id);
                var ret = jQuery("#list2").jqGrid('getRowData', id);
                rp_ge.processing = true;
                var su = jQuery("#list2").jqGrid('delRowData', rowid);
                if (su === true) {
                    var subtotal = $("#subtot").val();
                    var total = (subtotal - ret.total).toFixed(2);
                    $("#subtot").val(total);
                    $("#delmodlist").hide();
                }
                return true;
            },
            processing: true
        }
    });
    ////////////////fin tabla componentes///////////////////////////        
}


