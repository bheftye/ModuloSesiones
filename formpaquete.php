<?php
function __autoload($ClassName){
	$ClassName = strtolower($ClassName);
    include('clases/'.$ClassName.".php");
}

	$seguridad = new seguridad();
	$seguridad->candado();
	
if(isset($_REQUEST['idpaquete'])){
	$id=$_REQUEST['idpaquete'];
	$operacion='modificarpaquete';
	$palabra='Editar Paquete';
	$temporal = new Paquete($id);
	$temporal -> obtenerPaquete();
    $categorias = $temporal -> obtenerCategoriasDePaquete();
	
	if($temporal->imgPrincipal != ''){
		$img = '<img src="../paquetes/principales/'.$temporal->imgPrincipal.'" width="auto" height="221"/>';
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
	$operacion='agregarpaquete';
	$palabra='Nuevo Paquete';
	$img='';
	$deshabilitado = ' disabled';
	$temporal = new Paquete($id);
    $categorias = $temporal -> obtenerCategoriasDePaquete();
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

$clave = 'ModPqt';
?>

<?php
include 'head.html';//contiene los estilos y los metas
?>
	<title>Formulario Paquete</title>
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
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    	<form id="form-validation" name="form1" action="operaciones.php" method="post" onsubmit="return validar_campos()" enctype="multipart/form-data">
                    		<input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
                    		<input type="hidden" name="idpaquete" value="<?=$temporal->idPaquete?>"/>
                    		<input type="hidden" name="status" value="<?=$temporal->status?>"/>	
                    		<button type="submit" <?php if($seguridad->valida_permiso_usuario($_SESSION['idusuario'],$clave)==0) echo ' disabled ';?> name="operaciones" value="<?=$operacion?>" class="buttonguardar">Guardar y Publicar</button>
                    </div>
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
                        <span class="textHelper">Seleccione las categorías a las que pertenece el paquete:</span>
						<br>
	                     <select id="categorias" name="categorias[]" class="selectpicker form-group" title="Seleccione una o varias categorías" multiple>
		                    <option value="1" <?php if(in_array("1", $categorias)) echo "selected"; ?>>Circuitos</option>
		                    <option value="2" <?php if(in_array("2", $categorias)) echo "selected"; ?>>Paquetes de temporada</option>
		                    <option value="3" <?php if(in_array("3", $categorias)) echo "selected"; ?>>Boda</option>
		                    <option value="4" <?php if(in_array("4", $categorias)) echo "selected"; ?>>XV</option>
		                    <option value="5" <?php if(in_array("5", $categorias)) echo "selected"; ?>>Grupos</option>
		                    <option value="6" <?php if(in_array("6", $categorias)) echo "selected"; ?>>Graduaciones</option>
		                    <option value="7" <?php if(in_array("7", $categorias)) echo "selected"; ?>>Cruceros</option>
		                    <option value="8" <?php if(in_array("8", $categorias)) echo "selected"; ?>>Excursiones</option>
		                    <option value="9" <?php if(in_array("9", $categorias)) echo "selected"; ?>>Nacionales</option>
		                    <option value="10" <?php if(in_array("10", $categorias)) echo "selected"; ?>>Mundo Maya</option>
		                    <option value="11" <?php if(in_array("11", $categorias)) echo "selected"; ?>>Renta de Casas</option>
     					</select>
     					<br>                        
                        <div id="direccion" class="form-group espacios">
                        	<input type="text" name="direccion" id="address" class="form-control" placeholder="Ingrese la dirección..." value="<?=$temporal->dirección?>">
                        </div>
                        <br>
                        <div id="ubicacion" class="form-group espacios">
                        	<input type="text"  name="ubicacion" class="form-control" placeholder="Ingrese la ubicación aquí..." value="<?=$temporal->ubicacion?>">
                        </div>
                        <br>
                        <div id="categoria" class="form-group espacios">
                        	<input type="text"  name="categoria" class="form-control" placeholder="Ingrese la categoría aquí..." value="<?=$temporal->categoria?>">
                        </div>
                        <br>
                        <div id="clase" class="form-group espacios">
                        	<input type="text"  name="clase" class="form-control" placeholder="Ingrese la clase aquí..." value="<?=$temporal->clase?>">
                        </div>
                        <br>
                        <div id="disponibilidad" class="form-group espacios">
                        	<input type="text"  name="disponibilidad" class="form-control" placeholder="Ingrese la disponibilidad aquí..." value="<?=$temporal->disponibilidad?>">
                        </div>
                        <br>
                        
                    </div><!--Div de cierre col-lg-9-->
                    <!--
                    	En esta sección es del subtitulo y la imagen principal
                    -->
                    <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
                    	<div id="subtitulo" class="form-group espacios">
                    		<input type="text" name="subtitulo" class="form-control styled-large" placeholder="Ingrese subtitulo aquí..." value="<?=$temporal->subtitulo?>">
                    	</div>
                        <br>
                        <div id="vigencia_container" class="form-group espacios">
                        	<input type="text"  name="vigencia" id="vigencia" class="form-control" placeholder="Ingrese la vigencia aquí..." value="<?=$temporal->vigencia?>">
                        </div>
                        <br>
                        <div id="precio" class="form-group espacios">
                        	<input type="text"  name="precio" class="form-control" placeholder="Ingrese el precio aquí..." value="<?=$temporal->precio?>">
                        </div>
                        <br>
                        <span class="textHelper">Ingrese la descripción del paquete</span>
                        <textarea name="descripcion" id="summernote2"><?=$temporal->descripcion?></textarea>
                        <br>
		                <span class="textHelper">Recomendar Paquete</span>
		                <input type="checkbox" class="" style="display:block;" name="recomendar" value=1  <?php if($temporal -> recomendado == 1) print 'checked'; ?>> Recomendar	
		            </div>
		                 					
                    
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
                    <div class="col-lg-7 col-md-6 col-sm-12 col-xs-12">
                    	
                    	<div class="fileUpload btn btn-default" style="width:100%">
                            <span class="inputUploadFont">Agregar Imágenes Secundarias</span>
                            <input id="files2" name="archivo2[]" type="file" class="upload" multiple/>
                        </div>
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
                    	<?php
     						if($id != 0){
     							$temporal->listaImgPaquete();
								foreach ($temporal->imgSecundarias as $elementoImgS) {
								  echo '<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12" id="img2'.$elementoImgS -> idImgS.'">
								  			<div class="image-wrapper">
								  				<span class="image-options">
								  					<ul class="ulmenuoptions">
								  						<li onclick="deleteIMG2('.$elementoImgS -> idImgS.')"  class="limenuoptions manita">
                        									<span class="inputUploadFont fontOptionsImg">Eliminar <i class="fa fa-times"></i></span>
                        								</li>	
									  					<li class="limenuoptions manita">
										  					<div class="fileUpload" style="width:100%; border-color: none important!">
										  						<input type="hidden" name="idImgS[]" value="'.$elementoImgS -> idImgS.'"/>
		                            							<span class="inputUploadFont fontOptionsImg manita">Editar <i class="fa fa-pencil"></i></span>
		                            							<input name="archivo3[]" type="file" class="upload manita"/>
		                        							</div>
		                        						</li>	
                        							</ul>	
                        						</span>
								  				<img style="margin: 0 0 20px 0" class="img-responsive" src="../paquetes/secundarias/'.$elementoImgS -> ruta.'"/>
											</div>												
										</div>';
								}
     						}
							else {
								echo '';
							}
     					?>
                    <!--Este div contiene la barra inferior-->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    	<hr class="hrmenu">
                    </div>
                    <!--Este div contiene al boton inferior-->
                    <div class="clearfix"></div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    		<button type="submit" <?php if($seguridad->valida_permiso_usuario($_SESSION['idusuario'],$clave)==0) echo ' disabled ';?> name="operaciones" value="<?=$operacion?>" class="buttonguardar">Guardar y Publicar</button>
                    	</form>
                    </div>
                    
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
	<script>

    document.getElementById('vigencia').onchange = formatDate;

    function formatDate(){
        var date = document.getElementById('vigencia').value;
        var formatDate = '';
        var numeroMeses = new Array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
        var nombreMeses = new Array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
        var formatDate = date.split(" ");
        if(formatDate.length == 4){
         var formatedDate = formatDate[0]+" "+formatDate[1]+" de "+formatDate[2]+" del "+formatDate[3];
         document.getElementById('vigencia').value = formatedDate;
        }
    }

	$('.selectpicker').selectpicker({
		dropupAuto: false
	});
	
	$.datepicker.regional['es'] = {

		closeText: 'Cerrar',

		prevText: '',

		nextText: '',

		currentText: 'Hoy',

		monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],

		monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],

		dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],

		dayNamesShort: ['Dom','Lun','Mar','MiÈ','Juv','Vie','S·b'],

		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S·'],

		weekHeader: 'Sm',

		dateFormat: 'dd-mm-yy',

		firstDay: 1,

		numberOfMonths: 1,

		isRTL: false,

		showMonthAfterYear: false,

		yearSuffix: ''};

    $.datepicker.setDefaults($.datepicker.regional['es']);

	$("#vigencia").datepicker({
			altField: "#vigencia",
			altFormat: "DD dd MM yy",
			changeMonth: true,
			changeYear: true,
		});

		
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
	
	  document.getElementById('files2').addEventListener('change', handleFileSelect, false);
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

        if (form1.elements["categorias[]"].selectedIndex == -1) {
           $('#categorias').focus();
          $('#categorias').removeClass("form-group").addClass("form-group has-error");
          $('.top-right').notify({
                message: { text: 'Selecciona al menos una categoría, para poder continuar.' },
                type:'blackgloss',
            }).show();
          return false;
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
	$('#categorias').tooltip(
	{
		placement: "top",
        title: "Aquí se selecciona las categorías a las que pertenece el paquete."
	});
	$('#direccion').tooltip(
	{
		placement: "top",
        title: "Aquí se pone la dirección del hotel, casa o servicio."
	});
	$('#ubicacion').tooltip(
	{
		placement: "top",
        title: "Aquí se pone la ubicación del hotel, casa o servicio. Ciudad o País así como Continente."
	});
	$('#categoria').tooltip(
	{
		placement: "top",
        title: "Aquí se selecciona la categoría del paquete. Todo incluido, pago por noche, etc."
	});
	$('#disponibilidad').tooltip(
	{
		placement: "top",
        title: "Aquí se pone la disponibilidad. Solo para 20 personas, al menos 2 personas, etc."
	});
	$('#clase').tooltip(
	{
		placement: "top",
        title: "Aquí se selecciona la clase. 5 estrellas, Circuito, Hostal, etc."
	});
	$('#vigencia_container').tooltip(
	{
		placement: "top",
        title: "Aquí se selecciona el límite de fecha para poder utilizar el paquete."
	});
	$('#precio').tooltip(
	{
		placement: "top",
        title: "Aquí se pone el precio. 200 USD, 5000 MXN, etc."
	});
	
	$('#subtitulo').tooltip(
	{
		placement: "top",
        title: "Ingrese el subtitulo del paquete aquí."
	});
	
	$('#files').tooltip(
	{
		placement: "top",
        title: "Campo Requerido. Agregue la imagen principal de este paquete, solo se aceptan imágenes con formato .jpg, .png y .gif ."
	});
});
</script>
</html>
