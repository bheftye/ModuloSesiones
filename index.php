<?php
	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    session_start();
    if( isset($_SESSION['idusuario'])){
        if($_SESSION['idusuario'] != "" && $_SESSION['idusuario'] != "0")
        header("Location:formusuario.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Panel Locker Agencia Creativa S.A. de C.V.">
    <meta name="author" content="Luis Josué Caamal Barbosa">

    <title>Login</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700,700italic' rel='stylesheet' type='text/css'>

    <!-- Add custom CSS here -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!--<link href="js/summernote/summernote.css" rel="stylesheet">-->

</head>
<style>
    .error{
        color:red;
        font-size: 12pt;
        font-family:Times, sans-serif;
        font-weight: bold;
        float:left;
        margin: 0px 0 20px 0;
    }
</style>

<body>
	<!--Sección de la cabezera-->
	<header>
    	<!--Header que se muestra en las clases lg y md-->
    	<div class="styled-large">
            <div id="navBlack" class="jumbotron navbar-fixed-top">
                <div class="col-lg-4 col-md-4 col-sm-3 col-xs-3">
                    <!---<img id="imgLogo" class="imgNavBlack" src="img/logolocker.png">-->
                    <spam id="urlLocker"></spam>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-9 col-xs-9">
                    <p id="fecha"><?php echo date('d')." ".$meses[date('n')-1]. " ".date('Y') ;?></p>      	
                </div>
            </div>
            <div id="navBlue" class="jumbotron navbar-fixed-top">
                <div class="col-lg-1 col-md-2">
                    <div id="barraazul">
                        <p id="panel">PANEL DE CONTROL</p>
                    </div>
                </div>
                <div class="col-lg-11 col-md-10">
                    <p class="urlweb">Bienvenido al modulo de sesiones</p>
                </div>
            </div>
        </div>
        <!--Header que se muestra en las clases sm y xs-->
        <div class="styled-small">
        	<div id="navBlack" class="jumbotron navbar-fixed-top">
                <div class="col-sm-12 col-xs-12">
                	<!--<img id="imgLogo" class="imgNavBlack" src="img/logolocker.png">-->
                </div>
            </div>
            <div id="navBlueMovil" class="jumbotron navbar-fixed-top">
            	<p id="panel">PANEL DE CONTROL</p>
            </div>
            <div id="navBlueMovil2" class="jumbotron navbar-fixed-top">
            	 <p class="urlweb">Bienvenido al modulo de sesiones.</p>
            </div>
        </div>
    </header>
    <!--Es el que contiene a toda la pagina-->
    <div id="wrapperlogin">    
        <!-- Page content Sección del contenido de la pagina-->
        <div id="page-content-wrapper" class="wrapperlogin-movil">
            
            <!-- Keep all page content within the page-content inset div! -->
            <div class="page-content">
                <div class="row rowlogin">
                	<!--Seccion del form para agregar-->
                    <div class="col-lg-4 col-md-4 col-lg-offset-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12" id="positiondiv">
                    	<div class="row">
                        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            	<p class="login">Login</p><br><br>
                                <p class="error" id="txt_error" style="display:none;">Usuario o contraseña incorrectos</p>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    			<hr class="hrmenu">
                    		</div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <form method="post" action="operaciones.php">	
                            	<div id="titulo" class="form-group espacios">
                        			<input type="text" id="usuario" name="usuario" class="form-control" placeholder="Usuario" >
                        		</div>
                                <div id="pass" class="form-group espacios">
                        			<input type="password" name="pass" id="password" class="form-control" placeholder="Contraseña" >
                        		</div>
                                <div class="text-center">
                                	<button type="button"  name="operaciones" value="ingresar" onclick="validarUsuario()" class="buttonacceder">Acceder</button>
                                </div>
                            </form>        
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            	<a href="#" data-toggle="modal" data-target="#myModal"><p class="letraslogin">Ha olvidado su contraseña.</p></a>
                            </div>
                             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <a href="#" id="boton_registro" data-toggle="modal" data-target="#myModal2"><p class="letraslogin">Registrarse</p></a>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    			<hr class="hrmenu">
                    		</div>
                        </div>
                    </div>
                   
                </div><!--Div de cierre del row-->
            </div><!--Div de cierre de page-content inset-->
        </div><!--Div de cierre de page-content-wrapper-->
    </div><!--Div de cierre de id Wrapper-->
    <img id="loading" src="img/loading.gif" style="display:none;" align="center">
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Recuperar contraseña</h4>
      </div>
      <div class="modal-body">
      	<div class="row">
        	<div class="col-sm-12" id="Infopass3"></div>
            	<div id="email3" class="form-group">
                	<label class="control-label col-sm-2" for="inputSuccess3"><span style="font:'Open Sans'; font-size:14px;">Email:</span></label>
                	<div class="col-sm-9">
                    	<input name="Email3" id="inputSuccess3" class="jos3 form-control" type="text" placeholder="Introduzca su correo aquí"/>
                    </div>
                </div>	            
        </div>
      </div>
      <div class="modal-footer">
        	<!--<button type="submit" class="btn btn-primary" onClick="enviarCorreo()">Enviar</button>-->
            <a href="#" onClick="enviarCorreo()">Enviar</a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Registrarse</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-12" id="Infopass3"></div>
            <p id="errorMessage"><?php if(isset($_REQUEST["er"])) echo $_REQUEST["er"];?> La contraseña debe ser de al menos 15 caracteres, un número, una mayúscula y un caracter extraño.<p/>
                <form method="post" action="operaciones.php" onsubmit="return registrarUsuario()">   
                    <div id="titulo2" class="form-group espacios">
                        <input type="text" id="usuario2" name="usuario" class="form-control" placeholder="Usuario" >
                    </div>
                    <div id="correo2" class="form-group espacios">
                        <input type="text" id="correo" name="correo" class="form-control" placeholder="Correo Electrónico" >
                    </div>
                    <div id="pass2" class="form-group espacios">
                        <input type="password" name="pass" id="password2" class="form-control" placeholder="Contraseña" >
                    </div>
                    <div id="passConfirm" class="form-group espacios">
                        <input type="password" name="pass_confirm" id="password_confirm" class="form-control" placeholder="Confirma Contraseña" >
                    </div>
                    <div id="name" class="form-group espacios">
                        <input type="text" name="name_txt" id="name_txt" class="form-control" placeholder="Nombre" >
                    </div>
                    <div id="apellido" class="form-group espacios">
                        <input type="text" name="last_name_txt" id="last_name_txt" class="form-control" placeholder="Apellido" >
                    </div>
                    <div class="text-center">
                    <div id="pregunta" class="form-group espacios">
                        <input type="text" name="question_txt" id="question" class="form-control" placeholder="Pregunta Secreta" >
                    </div>
                    <div id="passConfirm" class="form-group espacios">
                        <input type="text" name="answer_txt" id="answer" class="form-control" placeholder="Respuesta Secreta" >
                    </div>
                        <button type="submit"  name="operaciones" value="agregarusuario" class="buttonacceder">Registrarse</button>
                </form>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    <!-- JavaScript -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="js/jquery.blockUI.js"></script>

    <!-- Custom JavaScript for the Menu Toggle -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("active");
    });
    </script>
    <script>

    function validarUsuario(){
        $('.error').css({display:'none'});
        $.blockUI({ 
            message: $('#loading'),
            css:{
              backgroundColor: 'none',
              border: 'hidden'
            }
            });
        var usuario = $('#usuario').val();
        var password = document.getElementById("password").value;
        $.ajaxSetup({ cache: false });
        $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"operaciones.php",
            data:"usuario="+usuario+"&pass="+password+"&operaciones=ingresar",
            success:function(data){
                console.log(data);
                if(data == "true" || data == "false"){
                    if(data =="true"){
                        window.location.href="formusuario.php";
                    }
                    else{
                        $('.error').css({display:'block'});
                        $.unblockUI();
                    }
                }
                else{
                    $('.error').css({display:'block'});
                    $('#txt_error').html('Se ha producido un error, intentalo de nuevo.');
                    $.unblockUI();
                }
               
            },
            cache:false
        });
    }

    function registrarUsuario(){

        var usuario = $("#usuario2").val();
        var password = $("#password2").val();
        var password2 = $("#password_confirm").val();
        var nombre = $("#name_txt").val();
        var apellido = $("#last_name_txt").val();
        var pregunta = $("#question_txt").val();
        var respuesta =$("#answer_txt").val();
        var correo = $("#correo").val();
        var mensaje ="";

        var camposLlenos = usuario != "" && password != "" && password2 != "" && nombre != "" && apellido != "" && pregunta != "" && respuesta != "" && correo != "";

        if(camposLlenos){
            if(!correo.match("[\w-\.]+)@((?:[\w]+\.)+)([a-zA-Z]{2,4}")){
               mensaje = "Correo invalido";
                 $("#errorMessage").html(mensaje).css({color:"red"});
                return false;
            }
            if(password == password2){
                if(password.match("^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{15,}$")){
                       $.unblockUI();
                        return true;
                }
                mensaje = "Contraseña débil";
               
            }
            else{
                mensaje = "Contraseñas no coinciden.";
            }
           
        }
        else{
             mensaje ="Llena todos los campos";
        }
       
        $("#errorMessage").html(mensaje).css({color:"red"});
        
        return false;

        }

	function enviarCorreo(){
		correo=$('#inputSuccess3').val();
		$.ajaxSetup({ cache: false });
			$.ajax({
				async:true,
				type: "POST",
				dataType: "html",
				contentType: "application/x-www-form-urlencoded",
				url:"operaciones.php",
				data:"email="+correo+"&operaciones=recuperapass",
				success:function(data){

					if(data==0)
					{
						$('#Infopass3').html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><p><strong>Advertencia!</strong> Este campo esta vacío.</p></div>")
		//pintaBordeRojo($(form3.Email3));
						$('#inputSuccess3').focus();
						$('#email3').removeClass("jos").addClass("form-group has-error");
					}
					if(data==1)
					{
						$('#Infopass3').html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><p><strong>Advertencia!</strong> Este correo no existe, asegúrese de que es un correo válido o si es con el que se registro.</p></div>")
						$('#email3').removeClass("jos").addClass("form-group has-error");
					}
					if(data==2)
					{
						$('#Infopass3').html("<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><p><strong>¡Muy Bien!</strong> El correo ha sido enviado con éxito, verifique su email, si no puede ver el correo revise si no ha llegado en la carpeta de spam o correo no deseado.</p></div>")
						$('#email3').removeClass("form-group has-error").addClass("form-group has-success");
					}
				},
				cache:false
			});		
	}	
</script>
</body>
</html>
