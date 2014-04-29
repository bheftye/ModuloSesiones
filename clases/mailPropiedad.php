<?php

include_once("propiedad.php");
include("../../includes/path.php");
include("../../lang/es.php");
include("../../lang/en.php");
/*
**
 * 
 */
class mailPropiedad{
	
	var $owner_email;
	var $froms;
	var $headers;
	var $subject;
	var $messageBody;
	var $nombre;
	var $email;
	var $mensaje;
	var $telefono;
	var $ciudad;
	var $propiedad;
	
	
	
	function mailPropiedad() {
	$this->owner_email = 'rodrigosc123@gmail.com';  
	$this->froms = "noreply@cercasa.com";
    $this->headers = "From: " .strip_tags ($this->froms). "\r\n";
	$this->headers .= "MIME-Version: 1.0\r\n";
    $this->headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $this->subject = 'Mensaje de contacto desde el sitio web, CERCASA';
	$this->email="";
	$this->idpropiedad="";
	$propiedad = new propiedad($this->idpropiedad);
	$propiedad->obtenerPropiedad();
	$propiedad->obtener_datos();
	}
	function generaBody(){

		
$this->messageBody = '<head>
	<script type="text/javascript" src="<?php echo PATH ?>js/jquery.js"></script>
		<!-- / -->
		<link rel="stylesheet" href="<?php echo PATH ?>css/cercasa.css" type="text/css"/>
		<!-- LIBRERIAS BOOTSTRAP -->
		<link rel="stylesheet" href="<?php echo PATH ?>css/bootstrap.css" type="text/css" />
		<script type="text/javascript" src="<?php echo PATH ?>js/bootstrap.js"></script>
		<!-- / -->
		<!-- SLIDER -->
		<script src="<?php echo PATH ?>js/jquery.royalslider.min.js"></script>
		<link href="<?php echo PATH ?>css/royalslider.css" rel="stylesheet"/>
		<link href="<?php echo PATH ?>css/rs-minimal-white.css" rel="stylesheet"/>
		<!-- / -->
		<link href="<?php echo PATH ?>css/font-awesome.min.css" type="text/css" rel="stylesheet"/>
		 
		
		<style>					
		
			.jumbotron{
				padding: 10px;
				background: #fef3e8;
				margin-bottom: 0;
			}
			.border{
				background: #FFF;
			}
			.navbar-default {
				background: none;
				border: none;
			}
			.royalSlider{
				width:100%;
				height: 100%;			
			}
			.rsOverflow img{
				height: 400px!important;
			}
			#content-slider-1{
				width:100%;
				height: 430px;
			}						
			
			.nav > li > a {
				position: relative;
				display: block;
				padding: 7.5px 15px;
				
			}
			.nav > li.active > div{
				border-bottom: 5px solid #fbbe0f;
			}
			
		</style>
</head>
<div class="container">
	<div class="row" align="center">
		<div class="col-md-12 col-lg-12">
			<img src="<?=PATH ?>img/cercasa.jpg" />
		</div>
	</div>
<div class="row" style="margin-bottom: -7px;">
		<div class="col-md-5 col-lg-5">
			<div class="tituloLista" style="margin-left: 0">
				<p class="alegreyaBold" style="font-size: 24px;margin-bottom: 0"><?=$propiedad->titulo?>.</p>
			</div>
		</div>
		<div class="col-md-7 col-lg-7">
			<p style="text-align: right;margin-bottom: 5px;margin-top:10px;font-size: 13px;color:#636363">'.CLAVE.': '.$propiedad->clave.'</p>
		</div>
	</div>	
	
	
	<div class="row" style="margin-top: 15px">
		<div class="col-md-12 col-lg-12" align="center">
			<img width="700" style="width: 400px" src="'.PATH.'/propiedades/'.$propiedad->ruta.'" />			
		</div>
	</div>
	<!-- SLIDER PROPIEDAD MOVIL -->	
	<!-- / -->
	<div class="row" style="margin-top: 30px">
		<div class="col-md-6 col-lg-6">
			<p class="alegreyaBold" style="font-size: 18px;color:#636363" >$ <?=$propiedad->precio?> MN</p>
			<p class="alegreya" style="font-size: 18px;color:#636363"><?=$propiedad -> subtitulo;?></p>
			<p class="tituloLista robotoitalic" style="margin-left: 0;color:#FFFFFF"><?=DETALLES ?></p>
			<p class="robotoBold" style="font-size: 13px;color:#636363;float: left;margin-right: 15px;">
				'.UBICACION .':     <br>
				'.TERRENO .':       <br>
				'.FRENTE .':        <br>
				'.FONDO .':         <br>
				'.CONSTRUCCION .':  <br>
				'.CUARTOS.':       <br>
				'.BANOS .':         <br>
				'.ESTACIONAMIENTO .': <br>
							
			</p>
			<p class="roboto" style="font-size: 13px;color:#636363">
				<span class="roboto" style="font-size: 13px;color:#636363">'.$propiedad->ciudad.', '.$propiedad->estado.'</span><br>
				<span class="roboto" style="font-size: 13px;color:#636363">'.$propiedad->datospropiedad->terreno .'</span><br>
				<span class="roboto" style="font-size: 13px;color:#636363">'.$propiedad->datospropiedad->frente .'</span><br>
				<span class="roboto" style="font-size: 13px;color:#636363">'.$propiedad->datospropiedad->fondo .'</span><br>
				<span class="roboto" style="font-size: 13px;color:#636363">'.$propiedad->datospropiedad->construccion .'</span><br>
				<span class="roboto" style="font-size: 13px;color:#636363">'.$propiedad->datospropiedad->cuartos .'</span><br>
				<span class="roboto" style="font-size: 13px;color:#636363">'.$propiedad->datospropiedad->banos .'</span><br>
				<span class="roboto" style="font-size: 13px;color:#636363">'.$propiedad->datospropiedad->estacionamiento .'</span><br>			
			</p>			
			<br>			
		    <!-- /RS -->
		</div>
		<div class="col-md-6 col-lg-6">						
			<p class="roboto" style="color: #7e7e7e;font-size: 13px;">'. $propiedad->descripcion
					.'</p>
		</div>
	</div>
</div>';
	}


function send(){	
		
    try{ 
        if(!mail($this->email, $this->subject, $this->messageBody, $this->headers)){ 
            throw new Exception('mail failed'); 
        }else{ 
            echo ''; 
        } 
    }catch(Exception $e){ 
        echo $e->getMessage() ."\n"; 
    } 
  }
  }
?>

