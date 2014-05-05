<?php
	include_once('clases/usuario.php');
	include_once('clases/seguridad.php');
	$seguridad = new seguridad();
	$seguridad->candado();
	session_start();
	$idusuario = 0;
	if(isset($_SESSION["idusuario"]) && $_SESSION["idusuario"] != 0 ){
		
	}
	
	if($idusuario != 0){
		$usuario = new usuario($idusuario);
		$usuario -> obten_usuario();
	}
	
?>
<?php
include('head.html');//Contiene los estilos y los metas.
?>
	<title>Info usuario</title>
<?php
include('header.html');//contiene las barras de arriba y los menus.
include('menu.php');
?>    
        <!-- Page content Sección del contenido de la pagina-->
        <div id="page-content-wrapper">
            
            <!-- Keep all page content within the page-content inset div! -->
            <div class="page-content inset">
                <div class="row rowedit">
                	<!--Seccion del titulo y el boton de agregar-->
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <p class="titulo">Informaci&oacute;n Usuario</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    	<form id="form-validation" action="operaciones.php" method="post" name="form1" onsubmit="return validar_campos()">
                    		<input type="hidden" name="idusuario" value="<?php echo $temporal->idusuario; ?>"/>
                    		<input type="hidden" name="status" value="<?php echo $temporal->status; ?>" />
                    		<button type="submit" name="operaciones" value="modificarusuario" class="buttonguardar">Guardar</button>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    	<hr class="hrmenu">
                    </div>
                    
                    <div class="clearfix"></div>
                    <!--Seccion de los forms
                    ---------------------------------------------------------------------------------
                    	En esta sección esta para editar el titulo y la descripcion
                    -------------------------------------------------------------------------------->
                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    	<div class='notifications top-right'></div>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
                    	<p class="subtitulo">Usuario y Contraseña:</p>
                    	<div id="nomuser" class="form-group espacios">
                        	<input id="checkuser" name="nomuser" type="text" class="form-control" placeholder="Ingrese el nombre de usuario aquí..." value="<?php echo ($idusuario != 0)?$usuario->user:'' ?>">
                       	</div>
                       	<div id="old_pass" class="form-group">
                        	<input id="oldusepass" name="oldpass" type="password" class="form-control" placeholder="Ingrese la contraseña anterior aquí..." value="">
                       	</div>
                       	<div id="pass" class="form-group">
                        	<input id="usepass" name="pass" type="password" class="form-control" placeholder="Ingrese la contraseña nueva aquí..." value="">
                       	</div>
                       	<div id="repass" class="form-group">
                        	<input id="userepass" name="repass" type="password" class="form-control" placeholder="Reingrese la contraseña nueva aquí..." value="">
                       	</div>
                       	<div class="espacios" id="valuser"></div>
        				<?=$opciones?>
                    </div><!--Div de cierre col-lg-5-->
                    <div class="col-lg-7 col-md-6 col-sm-12 col-xs-12">
                    	<p class="subtitulo">Datos del usuario:</p>
                    	<div id="nombre" class="form-group espacios">
                        	<input name="nombre" type="text" class="form-control" placeholder="Ingrese el nombre completo aquí..." value="<?php echo ($idusuario != 0)?$usuario->nombre:'' ?>">
                       	</div>
                       	<div id="apellido" class="form-group espacios">
                        	<input name="apellido" type="text" class="form-control" placeholder="Ingrese el apellido aquí..." value="<?php echo ($idusuario != 0)?$usuario->apellido:'' ?>">
                       	</div>
                       	<div id="pregunta" class="form-group espacios">
                        	<input name="question" type="text" class="form-control" placeholder="Ingrese la pregunta aquí..." value="<?php echo ($idusuario != 0)?$usuario->preguntaSecreta:'' ?>">
                       	</div>
                       	<div id="respuesta" class="form-group espacios">
                        	<input name="answer" type="text" class="form-control" placeholder="Ingrese la respuesta aquí..." value="<?php echo ($idusuario != 0)?$usuario->respuestaSecreta:'' ?>">
                       	</div>
    
                    </div>                  
                    <div class="clearfix"></div>                    
                    <!--Este div contiene la barra inferior-->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    	<hr class="hrmenu">
                    </div>
                    <!--Este div contiene al boton inferior-->
                    <div class="clearfix"></div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    		<button type="submit" name="operaciones" value="<?php echo $operacion; ?>" class="buttonguardar">Guardar y Publicar</button>
                        </form>
                    </div>
                    
                    <!--Sección del pie de pagina-->
                    <footer id="footer">
                    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <br>
                            
                            <br>
                    	</div>
                    </footer>
                </div><!--Div de cierre del row-->
            </div><!--Div de cierre de page-content inset-->
        </div><!--Div de cierre de page-content-wrapper-->
    </div><!--Div de cierre de id Wrapper-->

<?php
include 'javascripts.html';
?> 
<script type="text/javascript">
$(document).ready(function() {    
    $('#checkuser').blur(function(){

        $('#valuser').html('<div class="progress progress-striped active"><div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span class="sr-only">45% Complete</span></div></div>');

        var username = $(this).val();        
        var dataString = 'username='+username+'&operaciones=verificarusuario';

        $.ajax({
            type: "POST",
            url: "operaciones.php",
            data: dataString,
            success: function(data) {
                $('#valuser').show("slow").html(data);
            }
        });
    });              
});    
</script>
<script>  
	function validar_campos(){
		var filter=/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		
		if ( $('#checkuser').is('[disabled]') ){
			$('#nomuser').removeClass("form-group has-error").addClass("form-group");
		}
		else{
			if (form1.nomuser.value == ''){
			form1.nomuser.focus();
			$('#nomuser').removeClass("form-group").addClass("form-group has-error");
			$('.top-right').notify({
    			message: { text: 'El nombre de usuario esta vacío, llene el campo para poder continuar' },
    			type:'blackgloss',
  			}).show();
			return false;
			}
			else{
				$('#nomuser').removeClass("form-group has-error").addClass("form-group has-success");
			}	
		}
		if ( $('#usepass').is('[disabled]') ){
			 $('#pass').removeClass("form-group has-error").addClass("form-group");
		}
		else{
			if (form1.pass.value == "")
			{
				form1.pass.focus();
				$('#pass').removeClass("form-group").addClass("form-group has-error");
				$('.top-right').notify({
    			message: { text: 'El campo contraseña esta vacío, llene este campo para poder continuar' },
    			type:'blackgloss',
  			}).show();	
			return false;
			}
			else{
				$('#pass').removeClass("form-group has-error").addClass("form-group has-success");
			}	
		}
		if ( $('#userepass').is('[disabled]') ){
			$('#repass').removeClass("form-group has-error").addClass("form-group");
		}
		else{
			if (form1.repass.value == "")
			{
				form1.repass.focus();
				$('#repass').removeClass("form-group").addClass("form-group has-error");
				$('.top-right').notify({
	    			message: { text: 'El escriba de nuevo la contraseña para poder continuar' },
	    			type:'blackgloss',
	  			}).show();	
				return false;
			}
			else{
				$('#repass').removeClass("form-group has-error").addClass("form-group has-success");
			}	
		}
		if ( $('#userepass').is('[disabled]') && $('#userpass').is('[disabled]') ){
			 $('#repass').removeClass("form-group has-error").addClass("form-group");
			 $('#pass').removeClass("form-group has-error").addClass("form-group");
		}
		else{
			if (form1.pass.value != form1.repass.value)
			{
				form1.repass.focus();
				$('#repass').removeClass("form-group").addClass("form-group has-error");
				$('.top-right').notify({
	    			message: { text: 'Las contraseñas no coinciden, verifique que sea la misma para poder continuar' },
	    			type:'blackgloss',
	  			}).show();	
				return false;
			}
			else{
				$('#repass').removeClass("form-group has-error").addClass("form-group has-success");
			}
		}	 
		if (form1.nombre.value == ''){
			form1.nombre.focus();
			$('#nombre').removeClass("form-group").addClass("form-group has-error");
			$('.top-right').notify({
    			message: { text: 'Este campo es requerido para poder continuar' },
    			type:'blackgloss',
  			}).show();
			return false;
			}
		else{
			$('#nombre').removeClass("form-group has-error").addClass("form-group has-success");
		}
		if (form1.nombre.value == ''){
			form1.nombre.focus();
			$('#nombre').removeClass("form-group").addClass("form-group has-error");
			$('.top-right').notify({
    			message: { text: 'Este campo es requerido para poder continuar' },
    			type:'blackgloss',
  			}).show();
			return false;
			}
		else{
			$('#nombre').removeClass("form-group has-error").addClass("form-group has-success");
		}
		if(form1.email.value == '')
		{
			form1.email.focus();
			$('#email').removeClass("form-group").addClass("form-group has-error");
			$('.top-right').notify({
    			message: { text: 'Este no es un correo válido' },
    			type:'blackgloss',
  			}).show();
			return false;
		}
		else{
			$('#email').removeClass("form-group has-error").addClass("form-group has-success");
		}
		if(filter.test(form1.email.value))
		{
			$('#nombre').removeClass("form-group has-error").addClass("form-group has-success");
		}
		else{
			form1.email.focus();
			$('#email').removeClass("form-group").addClass("form-group has-error");
			$('.top-right').notify({
    			message: { text: 'Este no es un correo válido' },
    			type:'blackgloss',
  			}).show();
			return false;
		}
		if($('#typeuser').val()==0){
			$('.top-right').notify({
    			message: { text: 'Seleccione un tipo de usuario' },
    			type:'blackgloss',
  			}).show();
			return false;
		}
	}
	</script>
	<script>
	function cambiar(){
   		if($("#nameuser").is(':checked')) {  
            $("#checkuser").attr('disabled',false);
        } else {  
            $("#checkuser").attr('disabled',true); 
        }  
	}
	function cambiar2(){
   		if($("#contraseña").is(':checked')) {  
            $("#usepass").attr('disabled',false);
            $("#userepass").attr('disabled',false);
        } else {  
            $("#usepass").attr('disabled',true);
            $("#userepass").attr('disabled',true); 
        }  
	}
	
</script>
</body>
</html>
