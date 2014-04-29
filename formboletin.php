<?php
function __autoload($ClassName){
    $ClassName = strtolower($ClassName);
    include('clases/'.$ClassName.".php");
}

    $seguridad = new seguridad();
    $seguridad->candado();
    
if(isset($_REQUEST['idboletin'])){
    $id=$_REQUEST['idboletin'];
    $operacion='modificarboletin';
    $palabra='Editar Bolet&iacute;n';
    $temporal = new Boletin($id);
    $temporal -> obtenerBoletin();
    
}
else{
    $id=0;
    $operacion='agregarboletin';
    $palabra='Nuevo Bolet&iacute;n';
    $img='';
    $deshabilitado = ' disabled';
    $temporal = new Boletin($id);
    //$categorias = $temporal -> obtenerCategoriasDePaquete();
}

$clave = 'ModBol';
?>

<?php
include 'head.html';//contiene los estilos y los metas
?>
    <title>Formulario Bolet&iacute;n</title>
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
                            <input type="hidden" name="idboletin" value="<?=$temporal->idboletin?>"/>
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
                        <div id="correo" class="form-group espacios">
                            <input type="text"  name="correo" class="form-control" onkeyup="verificarDisponibilidadDeCorreo()" placeholder="Ingrese el correo electrónico aquí..." value="<?=$temporal->correo?>">
                        </div>
                    </div><!--Div de cierre col-lg-9-->
                    <!--
                        En esta sección es del subtitulo y la imagen principal
                    -->
                    <div class="clearfix"></div>
                    <!--
                    Aqui es la sección para subir las imágenes secundarias
                    -->
                    
                    <!--Sección del lado izquierdo-->
                    
                    
                    <div class="clearfix"></div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <p id="errorMessage" style="font-size:12pt;"></p>
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
    
 <!--Script que sirve para validar-->
    <script>
    function validar_campos(){
        
        if (form1.correo.value == ''){
            form1.correo.focus();
            $('#correo').removeClass("form-group").addClass("form-group has-error");
            $('.top-right').notify({
                message: { text: 'El Campo del correo esta vacío, para poder continuar asigne un titulo al paquete.' },
                type:'blackgloss',
            }).show();
            return false;
            }
        else{
            $('#correo').removeClass("form-group has-error").addClass("form-group has-success");
        }
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
$(function() {
    $('#correo').tooltip(
    {
        placement: "top",
        title: "Este campo es requerido"
    });

});
</script>
<script>
function verificarDisponibilidadDeCorreo(){
  var correo = $('[name="correo"]').val();
  $.ajaxSetup({ cache: false });
    $.ajax({
      async:true,
      type: "POST",
      dataType: "html",
      contentType: "application/x-www-form-urlencoded",
      url:"operaciones.php",
      data:"correo="+correo+"&operaciones=verificardisponibilidad",
      success:function(data){
         if(data == "false"){
          $('[name="correo"]').css({borderColor:"red", color:"red"});
           $("#errorMessage").html("El correo ya esta registrado, introduce otro.");
            $(":submit").attr("disabled", "disabled");
         }
         else{
          $('[name="correo"]').css({borderColor:"green", color:"green"});
          $("#errorMessage").html("El correo esta disponible");
          $(":submit").removeAttr("disabled");
         }                    
      },
      cache:false
    });     

}

</script>
</html>
