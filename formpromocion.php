<?php
function __autoload($ClassName){
    $ClassName = strtolower($ClassName);
    include('clases/'.$ClassName.".php");
}

    $seguridad = new seguridad();
    $seguridad->candado();
    
if(isset($_REQUEST['idpromocion'])){
    $id=$_REQUEST['idpromocion'];
    $operacion='modificarpromocion';
    $palabra='Editar Promoci&oacute;n';
    $temporal = new Promocion($id);
    $temporal -> obtenerPromocion();
    //$categorias = $temporal -> obtenerCategoriasDePaquete();
    
    if($temporal->imgPrincipal != ''){
        $img = '<img src="../promociones/principales/'.$temporal->imgPrincipal.'" width="auto" height="221"/>';
    }
    else 
        $img='';
    if($temporal->imgPrincipal != ''){
        $validator='';
    }
    else{
        $validator='if (!val.match(/(?:gif|jpg|png)$/)) {
            $("#check").removeClass("form-group").addClass("form-group has-error"); 
            $(".top-right").notify({
                message: { text: "El tipo de archivo que intenta subir no es admitido, solo se aceptan imágenes con formato .jpg .png .gif" },
                type:"blackgloss",
                delay: 6000,
            }).show(); 
            return false; 
        }';
    }
}
else{
    $id=0;
    $operacion='agregarpromocion';
    $palabra='Nuevo Promoci&oacute;n';
    $img='';
    $deshabilitado = ' disabled';
    $temporal = new Promocion($id);
    //$categorias = $temporal -> obtenerCategoriasDePaquete();
    $validator='if (!val.match(/(?:gif|jpg|png)$/)) {
            $("#check").removeClass("form-group").addClass("form-group has-error"); 
            $(".top-right").notify({
                message: { text: "Agregue la imagen principal para poder continuar y solo se aceptan imágenes con formato .jpg .png .gif" },
                type:"blackgloss",
                delay: 10000,
            }).show(); 
            return false; 
        }';
}

$clave = 'ModPromo';
?>

<?php
include 'head.html';//contiene los estilos y los metas
?>
    <title>Formulario Promoci&oacute;n</title>
<?php
include'header.html';//contiene las barras de arriba y los menus.
include'menu.php';//Contiene a todo el menu.
?> 

        <!-- Page content Sección del contenido de la pagina-->
        <div id="page-content-wrapper">
            
            <!-- Keep all page content within the page-content inset div! -->
            <div class="page-content inset">
                <div class="row rowedit">
                    <!--Seccion del titulo y el boton de agregar-->
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <p class="titulo"><?=$palabra?></p>
                    </div>
                        <form id="form-validation" name="form1" action="operaciones.php" method="post" onsubmit="return validar_campos()" enctype="multipart/form-data">
                            <input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
                            <input type="hidden" name="idpromocion" value="<?=$temporal->idPromocion?>"/>
                            <input type="hidden" name="status" value="<?=$temporal->status?>"/> 
                            <button type="submit" <?php if($seguridad->valida_permiso_usuario($_SESSION['idusuario'],$clave)==0) echo ' disabled ';?> name="operaciones" value="<?=$operacion?>" class="buttonguardar">Guardar y Publicar</button>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <hr class="hrmenu">
                    </div>
                    
                    <div class="clearfix"></div>
                    <!--Seccion de los forms
                        En esta sección esta para editar el titulo y la descripcion
                    -->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class='notifications top-right'></div>
                    </div>
                    <div class="col-lg-7 col-md-6 col-sm-12 col-xs-12">
                        <div id="titulo" class="form-group espacios">
                            <input type="text"  name="titulo" class="form-control" placeholder="Ingrese el titulo aquí..." value="<?=$temporal->titulo?>">
                        </div>
                    </div><!--Div de cierre col-lg-9-->
                    <!--
                        En esta sección es del subtitulo y la imagen principal
                    -->
                    <div class="clearfix"></div>
                    <!--
                    Aqui es la sección para subir las imágenes secundarias
                    -->
                    <div class="col-lg-7 col-md-6 col-sm-12 col-xs-12">
                        <!--Aquí es donde se previsualiza la imagen-->
                        <span class="textHelper">Previsualizar:</span>
                        <br>
                        <output align="center" id="list"><?=$img?></output>
                        <br>
                        <div class="fileUpload btn btn-default form-group" style="width:100%">
                            <span class="inputUploadFont">Agregar Imagen de Portada</span>
                            <input id="files" name="archivo" type="file" class="upload"/>
                        </div>
                        <br>
                        <div class="text-center textHelper">
                            Tipo de archivos permitidos: jpg, jpeg, png, gif.
                            <br>
                            Tamaño máximo de archivo: 2,000MB.
                        </div>
                        <br>
                    </div>
                    <!--Sección del lado izquierdo-->
                    <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12 textHelper">
                        Tipo de archivos permitidos: jpg, jpeg, png, gif.
                        <br>
                        Tamaño máximo de archivo: 1GB.
                    </div>
                    
                    <div class="clearfix"></div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <span class="textHelper">Previsualizar:</span>
                    </div>
                    <br>
                    <!--Aquí es donde se previsualiza las imágenes secundarias-->
                    <output align="center" id="list2">
                        
                    </output>
                    <!--Este div contiene la barra inferior-->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <hr class="hrmenu">
                    </div>
                    <!--Este div contiene al boton inferior-->
                    <div class="clearfix"></div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button type="submit" <?php if($seguridad->valida_permiso_usuario($_SESSION['idusuario'],$clave)==0) echo ' disabled ';?> name="operaciones" value="<?=$operacion?>" class="buttonguardar">Guardar y Publicar</button>
                    </div>
                </form>
                    <!--Sección del pie de pagina-->
                    <footer id="footer">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            Derechos Reservados a Locker Agencia Creativa S.A. de C.V.
                            <br>
                            soporte@locker.com.mx
                            <br>
                            www.locker.com.mx
                        </div>
                    </footer>
                </div><!--Div de cierre del row-->
            </div><!--Div de cierre de page-content inset-->
        </div><!--Div de cierre de page-content-wrapper-->
    </div><!--Div de cierre de id Wrapper-->

<?php
include 'javascripts.html';
?>
 <!--Scripts Especificos para los formularios
    Script que inicia el summernote-->
    <script>
        jQuery(document).ready(function() {
            jQuery('#summernote2').summernote({
                height: 100
            });
            $('#form-validation').on('submit', function (e) {
                 var content = $('textarea[name="descripcion"]').html($('#summernote2').code());
             });
        });
        jQuery(document).ready(function() {
            jQuery('#summernote3').summernote({
                height: 100
            });
            $('#form-validation').on('submit', function (e) {
                 var content = $('textarea[name="descripcionEN"]').html($('#summernote3').code());
             });
        });
        /*DESCRIPCION DE USO:
         #summernote: es el id que tenga tu textarea
         #form-validation: es el id que como se llame tu form
         textarea[name="descripcion"]: es el nombre del textarea
         estos datos los cambias por como llamaste a los tuyos*/
    </script>

   
    <!--Script que permite previsualizar la imagen primaria-->
    <script>
      function handleFileSelect(evt) {
        var files = evt.target.files; // FileList object
    
        // Loop through the FileList and render image files as thumbnails.
        for (var i = 0, f; f = files[i]; i++) {
    
          // Only process image files.
          if (!f.type.match('image.*')) {
            continue;
          }
    
          var reader = new FileReader();
    
          // Closure to capture the file information.
          reader.onload = (function(theFile) {
            return function(e) {
              // Render thumbnail.
              var span = document.createElement('span');
              span.innerHTML = ['<img width="auto" height="221" src="', e.target.result,
                                '" title="', escape(theFile.name), '"/>'].join('');
              $("#list").empty();
              document.getElementById('list').insertBefore(span, null);
            };
          })(f);
    
          // Read in the image file as a data URL.
          reader.readAsDataURL(f);
        }
      }
    
      document.getElementById('files').addEventListener('change', handleFileSelect, false);
    </script>
    <!--Script que permite previsualizar la imagen Secundaria-->
    <script>
      function handleFileSelect(evt) {
        var files2 = evt.target.files; // FileList object
        $("#list2").empty();
        // Loop through the FileList and render image files as thumbnails.
        for (var i = 0, f; f = files2[i]; i++) {
    
          // Only process image files.
          if (!f.type.match('image.*')) {
            continue;
          }
    
          var reader = new FileReader();
    
          // Closure to capture the file information.
          reader.onload = (function(theFile) {
            return function(e) {
              // Render thumbnail.
              var span = document.createElement('div');
              span.className = "col-lg-3 col-md-4 col-sm-12 col-xs-12";
              span.innerHTML = ['<img style="margin: 0 0 20px 0" class="img-responsive" src="', e.target.result,
                                '" title="', escape(theFile.name), '"/>'].join('');
              document.getElementById('list2').insertBefore(span, null);
            };
          })(f);
    
          // Read in the image file as a data URL.
          reader.readAsDataURL(f);
        }
      }
    
      //document.getElementById('files2').addEventListener('change', handleFileSelect, false);
    </script>
 <!--Script que sirve para validar-->
    <script>
    function validar_campos(){
        var val = $("#files").val();
        
        if (form1.titulo.value == ''){
            form1.titulo.focus();
            $('#titulo').removeClass("form-group").addClass("form-group has-error");
            $('.top-right').notify({
                message: { text: 'El Campo del titulo esta vacío, para poder continuar asigne un titulo al paquete.' },
                type:'blackgloss',
            }).show();
            return false;
            }
        else{
            $('#titulo').removeClass("form-group has-error").addClass("form-group has-success");
        }
        <?=$validator?>
    }
    </script>
<!--script que inizializa el formato precio-->
<script>
    $(window).load(function () {
        var i = $("input[type=radio][name=google]:checked").val();
        if(i == 0){
            //$("#map-canvas").show("slow");
            $('.map-wrap').css({ height: 'auto', width: 'auto', opacity:1 });
        }
        else{
            //$("#map-canvas").hide("slow");
            $('.map-wrap').css({ opacity:0 });  
        }
    });
</script>
<script>
$(function(){
    $(".static_class").click(function(){
      if($(this).val() == 0)
        //$("#map-canvas").show("slow");
        $('.map-wrap').css({ height: 'auto', width: 'auto', opacity:1 });
      else
        //$("#map-canvas").hide("slow");
        $('.map-wrap').css({ height: 0, width: 0 });
    });
  });
</script>
<script>
    function deleteIMG2(id){
        var elementoDOM = "#img"+id;
        $.ajaxSetup({ cache: false });
        $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"operaciones.php",
            data:"idImg2="+id+"&operaciones=eliminarImgPaquete",
            success:function(data){             
                $("#img2"+id).fadeOut('slow');
            },
            cache:false
        });     
    }
</script>
<script>
$(function() {
    $('#titulo').tooltip(
    {
        placement: "top",
        title: "Este campo es requerido"
    });
    
    $('#files').tooltip(
    {
        placement: "top",
        title: "Campo Requerido. Agregue la imagen principal de este paquete, solo se aceptan imágenes con formato .jpg, .png y .gif ."
    });
});
</script>
</html>
