<?php
	function __autoload($ClassName){
		$ClassName = strtolower($ClassName);
    include('clases/'.$ClassName.".php");
}

	$seguridad = new seguridad();
	$seguridad->candado();

$idCorreo = 0;
$plantilla = 0;
$correo = null;
if(isset($_REQUEST["c"])){
	$idCorreo = $_REQUEST["c"];
}
if(isset($_REQUEST["p"])){
	$plantilla = $_REQUEST["p"];
}

switch ($plantilla) {
	case '1':
		$correo = new correo1($idCorreo);
		$correo -> obtenerCorreo1();
		$correo -> listarCorreo1img();
		$correo -> listarCorreo1img2();
		break;
	case '2':
		$correo = new correo2($idCorreo);
		$correo -> obtenerCorreo2();
		$correo -> listarCorreo2img();
		$correo -> listarCorreo2img2();
		break;
	case '3':
		$correo = new correo3($idCorreo);
		$correo -> obtenerCorreo3();
		$correo -> listarCorreo3img2();
		break;
	
	default:
		break;
}


	$clave = 'agrCat';
	$palabra = 'Correos';
	$operacion = 'enviar';
	$tmpPaquete = new Paquete();
	$listaPaquetes = $tmpPaquete -> listarPaquetesPorFecha();

?>
<?php
include('head.html');//Contiene los estilos y los metas.
?>
	<title>Newsletter</title>
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
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <p class="titulo"><?php echo $palabra;?></p>
                    </div>
                   	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		            	<div class='notifications top-right'></div>
		            </div> 
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    	<ul class="nav nav-tabs">
						  <li id="plant1" class="<?php if($plantilla == 1 || $plantilla == 0 ) echo ' active';?>"><a href="#home" data-toggle="tab"><img src="img/plantillas-01.png" width="50" height="50" /></a></li>
						  <li id="plant2" class="<?php if($plantilla == 2 ) echo ' active';?>"><a href="#profile" data-toggle="tab"><img src="img/plantillas-02.png" width="50" height="50" /></a></li>
						  <li id="plant3" class="<?php if($plantilla == 3 ) echo ' active';?>"><a href="#messages" data-toggle="tab"><img src="img/plantillas-03.png" width="50" height="50" /></a></li>						 
						</ul>
                    </div>
                    <div class="tab-content">
					  <div class="tab-pane fade <?php if($plantilla == 1 || $plantilla == 0 ) echo 'in active';?>" id="home">
					  	 <form id="form-validation" action="operaciones.php" method="post" name="form1" onsubmit="return validar_campos()" enctype="multipart/form-data">
	                		<input type="hidden" name="MAX_FILE_SIZE" value="600000000"/>
	                    	<input type="hidden" name="idcorreo1" value="<?php echo ($idCorreo != 0 && $plantilla == 1)? $correo -> idcorreo1: '' ;?>"/>  
	                    	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="margin: 25px 0 0 0">
                    			<p class="titulo">Plantilla 1</p>
                    		</div>
		                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
		                    	<button type="submit" <?php if($seguridad->valida_permiso_usuario($_SESSION['idusuario'],$clave)==0) echo ' disabled ';?> name="operaciones" value="<?php echo $operacion; ?>" class="buttonguardar">Guardar y Publicar</button>
		                    </div>
		                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right">
	                    		<div class="text-center textHelper">
	                        		Puedes enviar un correo de prueba, antes de enviarselo a todos tus contactos.
	                        	</div>
	                    		<input type="text" class="form-control" name="correo_prueba[]" placeholder="Introduce la dirección del correo para enviar la prueba...">
	                    		<button type="button" <?php if($seguridad->valida_permiso_usuario($_SESSION['idusuario'],$clave)==0) echo ' disabled ';?> onclick="validar_campo_prueba1()"  class="buttonguardar">Enviar Prueba</button>
		                    </div>  
		                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                    	<hr class="hrmenu">
		                    </div>
		                    
		                    <div class="clearfix"></div>
		                    <!--Seccion de los forms
		                    ---------------------------------------------------------------------------------
		                    	En esta sección esta para editar el titulo y la descripcion
		                    -------------------------------------------------------------------------------->
		                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 espacios">
		                    	<div class="row">
		                    		
		                    		<div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
		                    			<div class="row">
		                    				<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
		                    					<div class="row">
		                    						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		                    							<img src="img/logo.png" width="200" height="80"/>
		                    						</div>
		                    						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		                    							<div id="titulo" class="form-group espacios">
                        	          						<input name="titulo" type="text" style="margin: 30px 0 0 0" class="form-control" placeholder="Ingrese el titulo aquí..." value="<?php echo ($idCorreo != 0 && $plantilla == 1)? $correo -> titulo: '' ;?>">
                                     					</div>
		                    						</div>
		                    					</div>		                    						                    			
		                    				</div>
		                    			</div>
		                    		</div>		               
		                    		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin: 10px 0 0 0">
		                    			<hr class="hrmenu">
		                    		</div>
		                    		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                    			<div class="row">
		                    				<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
		                    					<span class="textHelper">Previsualizar:</span>
					                       		<br>
					                        	<output align="center" id="list">
					                        		<?php
					                        		if($idCorreo != 0 && $plantilla == 1 ){
					                        			echo '<img width="100%" height="221" src="./correos/correo1/'.$correo -> ruta.'" title="Imagen Portada"/>';
					                        		}
					                        		?>
												</output>
					                        	<br>
		                    				</div>		                
		                    			</div>
		                    		</div>
		                    		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                        		<div align="center">
			                    			<div id="imgprin" class="fileUpload btn btn-default" style="width:50%">
			                            		<span class="inputUploadFont">Agregar Imagen de Portada</span>
			                            		<input id="files" name="archivo" type="file" class="upload"/>
			                        		</div>
		                        		</div>
		                        		<br>
		                        		<div class="text-center textHelper">
		                        			Tipo de archivos permitidos: jpg, jpeg, png, gif.
		                            		<br>
		                            		Tamaño máximo de archivo: 4MB.
		                        		</div>
		                    		</div>
		                    		<div class="col-lg-4 col-lg-offset-3 col-md-4 col-md-offset-3 col-sm-12 col-xs-12" style="margin-top: 10px">
		                    			<div id="subtitulo" class="form-group espacios">
		                        			<input name="subtitulo" type="text" class="form-control" placeholder="Ingrese el subtitulo aquí..." value="<?php echo ($idCorreo != 0 && $plantilla == 1)? $correo -> subtitulo: '' ;?>">
		                       			</div>
		                    		</div>
		                    		<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12" style="margin-top: 10px"></div>
		                    		<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12" style="margin-top: 10px">
		                    			<span class="textHelper">Ingrese la descripción 1 aquí:</span>
		                        		<textarea name="desc1" id="summernote"><?php echo ($idCorreo != 0 && $plantilla == 1)? $correo -> desc1: '' ;?></textarea>
		                    		</div>
		                    		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin: 20px 0 0 0">
		                    			<hr class="hrmenu">
		                    		</div>
		                    		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		                    			<span class="textHelper">Ingrese la descripción 2 aquí:</span>
		                        		<textarea name="desc2" id="summernote2"><?php echo ($idCorreo != 0 && $plantilla == 1)? $correo -> desc2: '' ;?></textarea>
		                    		</div>
		                    		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		                    			<span class="textHelper">Ingrese la descripción 3 aquí:</span>
		                        		<textarea name="desc3" id="summernote3"><?php echo ($idCorreo != 0 && $plantilla == 1)? $correo -> desc3: '' ;?></textarea>
		                    		</div>
		                    		<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12" style="margin-top: 10px">
				                    	<div id="imgsecu" class="fileUpload btn btn-default" style="width:100%">
				                            <span class="inputUploadFont">Agregar Imágenes Secundarias</span>
				                            <input id="files2" name="archivo2[]" type="file" class="upload" multiple/>
				                        </div>
				                        <br>
		                        		<div class="text-center textHelper">
		                        			Tipo de archivos permitidos: jpg, jpeg, png, gif.
		                            		<br>
		                            		Tamaño máximo de archivo: 4MB.
		                        		</div>
				                        <div class="espacios">
				                        	<span class="textHelper">Previsualizar:</span>
				                        </div>
				                    </div><!--Div de cierre col-lg-7-->
				                    <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12" style="margin-top: 10px">
				                    	<div class="row">
				                    		<output align="center" id="list2"></output>
				                    	</div>
				                    	<div class="row">
				                    		<output align="center" id="list2_2">
						                    	<?php
						     						if($idCorreo != 0 && $plantilla == 1 ){
														foreach ($correo->correo1img as $elementoImgS) {
														  echo '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" id="correo1img'.$elementoImgS["idcorreoimg1"].'">
														  			<div class="image-wrapper">
														  				<span class="image-options">
														  					<ul class="ulmenuoptions">
														  						<li onclick="deleteCorreo1Img('.$elementoImgS["idcorreoimg1"].', '.$correo -> idcorreo1.')"  class="limenuoptions manita">
						                        									<span class="inputUploadFont fontOptionsImg">Eliminar <i class="fa fa-times"></i></span>
						                        								</li>	
															  					<li class="limenuoptions manita">
																  					<div class="fileUpload" style="width:100%; border-color: none important!">
																  						<input type="hidden" name="correo1img[]" value="'.$elementoImgS["idcorreoimg1"].'"/>
								                            							<span class="inputUploadFont fontOptionsImg manita">Editar <i class="fa fa-pencil"></i></span>
								                            							<input name="archivo23[]" type="file" class="upload manita"/>
								                        							</div>
								                        						</li>	
						                        							</ul>	
						                        						</span>
														  				<img style="margin: 0 0 20px 0" class="img-responsive" src="./correos/correo1/correo1img/'.$elementoImgS["ruta"].'"/>
																	</div>												
																</div>';
														}
						     						}
													else {
														echo '';
													}
		     									?>
		     								</output>
		     							</div>
				                    </div>				                   
		                    	</div>
		                    </div>		                
		                    <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
		                    	<span class="textHelper">Previsualizar:</span>
		                       	<br>
		                        <output align="center" id="list3">
		                        	<?php
				     						if($idCorreo != 0 && $plantilla == 1){
												foreach ($correo->correo2img as $elementoImgS) {
												  echo '
												  		<img style="margin: 0 0 20px 0; height:221px; width:100%;" class="img-responsive" src="./correos/correo1/correo2img/'.$elementoImgS["ruta"].'"/>
														';
													break;
												}
				     						}
											else {
												echo '';
											}
     									?>
		                        	
     							</output>
     							<?php
				     						if($idCorreo != 0 && $plantilla == 1){
												foreach ($correo->correo2img as $elementoImgS) {
												  echo '
												  		<input type="hidden" name="idcorreo1img2" value="'.$elementoImgS["idcorreo1img2"].'" />
														';
													break;
												}
				     						}
											else {
												echo '';
											}
     									?>
		                        	
		                        <br>
		                        <div>
			                    	<div id="imgter" class="fileUpload btn btn-default form-group" style="width:100%">
			                        	<span class="inputUploadFont">Agregar Imagen de Portada</span>
			                            <input id="files3" name="archivo3" type="file" class="upload"/>
			                        </div>
		                        </div>
		                        <br>
		                        <div class="text-center textHelper">
		                        	Tipo de archivos permitidos: jpg, jpeg, png, gif.
		                        	<br>
		                        	Tamaño máximo de archivo: 4MB.
		                        </div>
		                        <hr class="hrmenu" style="margin-top: 10px; margin-bottom: 10px">
		                        <!--<select multiple="multiple" id="my-select" name="my-select[]">
		                          <option value="0" selected></option>
	                              <option value="boletin">Boletines</option>
	                              <option value="clientes">Registrados</option>
		                     	</select>
		                     -->
		                    </div>               
		                    <div class="clearfix"></div>                    
		                    <!--Este div contiene la barra inferior-->
		                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin: 15px 0 0 0">
		                    	<hr class="hrmenu">
		                    </div>
		                    <!--Este div contiene al boton inferior-->
		                    <div class="clearfix"></div>
		                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                    	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-left">
		                    		<div class="text-center textHelper">
		                        		Puedes enviar un correo de prueba, antes de enviarselo a todos tus contactos.
		                        	</div>
		                    		<input type="text" class="form-control" name="correo_prueba[]" placeholder="Introduce la dirección del correo de prueba...">
		                    		<button type="button" <?php if($seguridad->valida_permiso_usuario($_SESSION['idusuario'],$clave)==0) echo ' disabled ';?> onclick="validar_campo_prueba1()" class="buttonguardar">Enviar Prueba</button>
		                    	</div>
		                    		<button type="submit" <?php if($seguridad->valida_permiso_usuario($_SESSION['idusuario'],$clave)==0) echo ' disabled ';?> name="operaciones" value="<?php echo $operacion; ?>" class="buttonguardar">Guardar y Publicar</button>
		                        
		                    </div>
	                    </form>
					  </div>
					  <!--****************************************
					  	Comienza plantilla 2
					  *****************************************-->
					  <div class="tab-pane fade <?php if($plantilla == 2) echo 'in active';?>" id="profile">
					  	<form id="form-validation2" action="operaciones.php" method="post" name="form2" onsubmit="return validar_campos2()" enctype="multipart/form-data">
	                		<input type="hidden" name="MAX_FILE_SIZE" value="600000000"/>
	                    	<input type="hidden" name="idcorreo2" value="<?php echo ($idCorreo != 0 && $plantilla == 2)? $correo -> idcorreo2: '' ;?>"/> 
	                    	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin: 25px 0 0 0">
                    			<p class="titulo">Plantilla 2</p>
                    		</div> 
		                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">                    	     
		                    	<button type="submit" <?php if($seguridad->valida_permiso_usuario($_SESSION['idusuario'],$clave)==0) echo ' disabled ';?> name="operaciones" value="enviar2" class="buttonguardar">Guardar y Publicar</button>
		                    </div>
		                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right">
	                    		<div class="text-center textHelper">
	                        		Puedes enviar un correo de prueba, antes de enviarselo a todos tus contactos.
	                        	</div>
	                    		<input type="text" class="form-control" name="correo_prueba[]" placeholder="Introduce la dirección del correo para enviar la prueba...">
	                    		<button type="button" <?php if($seguridad->valida_permiso_usuario($_SESSION['idusuario'],$clave)==0) echo ' disabled ';?> onclick="validar_campo_prueba2()" class="buttonguardar">Enviar Prueba</button>
		                    </div>  
		                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                    	<hr class="hrmenu">
		                    </div>
		                    
		                    <div class="clearfix"></div>
		                    <!--Seccion de los forms
		                    ---------------------------------------------------------------------------------
		                    	En esta sección esta para editar el titulo y la descripcion
		                    -------------------------------------------------------------------------------->
		                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 espacios">
		                    	<div class="row">
		                    		<div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
		                    			<div class="row">
		                    				<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
		                    					<div class="row">
		                    						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		                    							<img src="img/logo.png" width="200" height="80"/>
		                    						</div>
		                    						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		                    							<div id="titulop2" class="form-group espacios">
		                    								<input name="titulop2" type="text" style="margin: 30px 0 0 0" class="form-control" placeholder="Ingrese el titulo aquí..." value="<?php echo ($idCorreo != 0 && $plantilla == 2)? $correo -> titulo: '' ;?>">
		                    							</div>
		                    						</div>
		                    					</div>		                    						                    			
		                    				</div>
		                    			</div>
		                    		</div>		   
		                    		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin: 10px 0 0 0">
		                    			<hr class="hrmenu">
		                    		</div>
		                    		<div class="col-lg-4 col-lg-offset-3 col-md-4 col-md-offset-3 col-sm-12 col-xs-12" style="margin-top: 10px">
		                    			<div id="subtitulop2" class="form-group espacios">
		                        			<input name="subtitulop2" type="text" class="form-control" placeholder="Ingrese el subtitulo aquí..." value="<?php echo ($idCorreo != 0 && $plantilla == 2)? $correo -> subtitulo: '' ;?>">
		                       			</div>
		                    		</div>
		                    		<div class="col-lg-8 col-lg-offset-3 col-md-8 col-md-offset-3 col-sm-12 col-xs-12" style="margin-top: 10px"></div>
		                    		<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12" style="margin-top: 10px">
		                    			<span class="textHelper">Ingrese una pequeña descripción aquí:</span>
		                        		<textarea name="desc1p2" id="summernotep2"><?php echo ($idCorreo != 0 && $plantilla == 2)? $correo -> desc1: '' ;?></textarea>
		                    		</div>
		                    		<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12" style="margin-top: 10px">
				                    	<div id="imgsecup2" class="fileUpload btn btn-default" style="width:100%">
				                            <span class="inputUploadFont">Agregar Imágenes Secundarias</span>
				                            <input id="files2p2" name="archivo2p2[]" type="file" class="upload" multiple/>
				                        </div>
				                        <div class="text-center textHelper">
				                        	Tipo de archivos permitidos: jpg, jpeg, png, gif.
		                        			<br>
		                        			Tamaño máximo de archivo: 10MB.
				                        </div>
				                        <div class="espacios">
				                        	<span class="textHelper">Previsualizar:</span>
				                        </div>
				                    </div><!--Div de cierre col-lg-7-->				                
		                   			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 espacios"></div>
		                   			<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12" style="margin-top: 10px">
				                    	<div class="row">
				                    		<output align="center" id="list2p2"></output>
				                    	</div>
				                    	<div class="row">
				                    		<output align="center" id="list2p2_2">
				                    			<?php
						     						if($idCorreo != 0 && $plantilla == 2 ){
														foreach ($correo->correo1img as $elementoImgS) {
														  echo '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" id="correo2img'.$elementoImgS["idcorreoimg2"].'">
														  			<div class="image-wrapper">
														  				<span class="image-options">
														  					<ul class="ulmenuoptions">
														  						<li onclick="deleteCorreo2Img('.$elementoImgS["idcorreoimg2"].', '.$correo -> idcorreo2.')"  class="limenuoptions manita">
						                        									<span class="inputUploadFont fontOptionsImg">Eliminar <i class="fa fa-times"></i></span>
						                        								</li>	
															  					<li class="limenuoptions manita">
																  					<div class="fileUpload" style="width:100%; border-color: none important!">
																  						<input type="hidden" name="correo2img[]" value="'.$elementoImgS["idcorreoimg2"].'"/>
								                            							<span class="inputUploadFont fontOptionsImg manita">Editar <i class="fa fa-pencil"></i></span>
								                            							<input name="archivo2p23[]" type="file" class="upload manita"/>
								                        							</div>
								                        						</li>	
						                        							</ul>	
						                        						</span>
														  				<img style="margin: 0 0 20px 0" class="img-responsive" src="./correos/correo2/correo1img/'.$elementoImgS["ruta"].'"/>
																	</div>												
																</div>';
														}
						     						}
													else {
														echo '';
													}
		     									?>
				                    		</output>
				                    	</div>
				                    </div>			                   			
		                   			 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		                    			<span class="textHelper">Ingrese una pequeña descripción aquí:</span>
		                        		<textarea name="desc2p2" id="summernote2p2"><?php echo ($idCorreo != 0 && $plantilla == 2)? $correo -> desc2: '' ;?></textarea>
		                    		</div>
		                    		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		                    			<span class="textHelper">Ingrese una pequeña descripción aquí:</span>
		                        		<textarea name="desc3p2" id="summernote3p2"><?php echo ($idCorreo != 0 && $plantilla == 2)? $correo -> desc3: '' ;?></textarea>
		                    		</div>
		                    		
		                    		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 espacios">
		                    			<hr class="hrmenu">
		                    		</div>   
		                    		
		                    		<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12" style="margin-top: 10px">
		                    			<div class="row">
		                    				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		                    					<span class="textHelper">Previsualizar:</span>
				                       			<br>
				                        		<output align="center" id="listp2">
				                        			<?php
						                        		if($idCorreo != 0 && $plantilla == 2){
						                        			echo '<img width="200" height="200" src="./correos/correo2/'.$correo -> ruta.'" title="Imagen Portada"/>';
						                        		}
					                        		?>
				                        		</output>
				                        		<br>
				                        		<div align="center">
					                    			<div id="imgprinp2" class="fileUpload btn btn-default form-group" style="width:100%">
					                            		<span class="inputUploadFont">Agregar Imagen de Portada</span>
					                            		<input id="filesp2" name="archivop2" type="file" class="upload"/>
					                        		</div>
				                        		</div>
				                        		<br>
				                        		<div class="text-center textHelper">
				                        			Tipo de archivos permitidos: jpg, jpeg, png, gif.
				                            		<br>
				                            		Tamaño máximo de archivo: 4MB.
				                        		</div>
		                    				</div>
		                    				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		                    					<span class="textHelper">Ingrese una pequeña descripción aquí:</span>
		                        				<textarea name="desc4p2" id="summernote4p2"><?php echo ($idCorreo != 0 && $plantilla == 2)? $correo -> desc4: '' ;?></textarea>
		                    				</div>
		                    			</div>
		                    		</div>
		                    		
		                    		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin: 20px 0 0 0">
		                    			<hr class="hrmenu">
		                    		</div>  
		                    	</div>
		                    </div>
		                    <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
		                    	<span class="textHelper">Previsualizar:</span>
		                       	<br>
		                        <output align="center" id="list3p2">
		                        	<?php
			     						if($idCorreo != 0 && $plantilla == 2){
											foreach ($correo->correo2img as $elementoImgS) {
											  echo '
											  		<img style="margin: 0 0 20px 0; height:221px; width:100%;" class="img-responsive" src="./correos/correo2/correo2img/'.$elementoImgS["ruta"].'"/>
													';
												break;
											}
			     						}
										else {
											echo '';
										}
     								?>
		                        </output>
		                        	<?php
			     						if($idCorreo != 0 && $plantilla == 2){
											foreach ($correo->correo2img as $elementoImgS) {
											  echo '
											  		<input type="hidden" name="idcorreo2img2" value="'.$elementoImgS["idcorreo2img2"].'" />
													';
												break;
											}
			     						}
										else {
											echo '';
										}
     								?>
		                        <br>
		                        <div>
			                    	<div id="imgterp2" class="fileUpload btn btn-default form-group" style="width:100%">
			                        	<span class="inputUploadFont">Agregar Imagen de Portada</span>
			                            <input id="files3p2" name="archivo3p2" type="file" class="upload"/>
			                        </div>
		                        </div>
		                        <br>
		                        <div class="text-center textHelper">
		                        	Tipo de archivos permitidos: jpg, jpeg, png, gif.
		                        	<br>
		                        	Tamaño máximo de archivo: 4MB.
		                        </div>
		                        <hr class="hrmenu" style="margin-top: 10px; margin-bottom: 10px">
		                         <!--<select multiple="multiple" id="my-select2" name="my-select2[]">
		                         	<option value="0" selected></option>
		                              <option value="boletin">Boletines</option>
		                              <option value="clientes">Registrados</option>
		                     	</select>-->
		                    </div>                 
		                    <div class="clearfix"></div>                    
		                    <!--Este div contiene la barra inferior-->
		                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin: 15px 0 0 0">
		                    	<hr class="hrmenu">
		                    </div>
		                    <!--Este div contiene al boton inferior-->
		                    <div class="clearfix"></div>
		                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                    	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-left">
		                    		<div class="text-center textHelper">
		                        		Puedes enviar un correo de prueba, antes de enviarselo a todos tus contactos.
		                        	</div>
		                    		<input type="text" class="form-control" name="correo_prueba[]" placeholder="Introduce la dirección del correo de prueba...">
		                    		<button type="button" <?php if($seguridad->valida_permiso_usuario($_SESSION['idusuario'],$clave)==0) echo ' disabled ';?> onclick="validar_campo_prueba2()" class="buttonguardar">Enviar Prueba</button>
		                    	</div>
		                    		<button type="submit" <?php if($seguridad->valida_permiso_usuario($_SESSION['idusuario'],$clave)==0) echo ' disabled ';?> name="operaciones" value="enviar2" class="buttonguardar">Guardar y Publicar</button>		                        
		                    </div>
	                    </form>
					  </div>
					  <!--*****************************************************************
					  						Plantilla 3
					  	************************************************************-->
					  <div class="tab-pane fade <?php if($plantilla == 3) echo 'in active';?>" id="messages">
					  	<form id="form-validation3" action="operaciones.php" method="post" name="form3" onsubmit="return validar_campos3()" enctype="multipart/form-data">
	                		<input type="hidden" name="MAX_FILE_SIZE" value="600000000"/>
	                    	<input type="hidden" name="idcorreo3" value="<?php echo ($idCorreo != 0 && $plantilla == 3)? $correo -> idcorreo3: '' ;?>"/>
	                    	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin: 25px 0 0 0">
                    			<p class="titulo">Plantilla 3</p>
                    		</div>  
		                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">                    	     
		                    	<button type="submit" <?php if($seguridad->valida_permiso_usuario($_SESSION['idusuario'],$clave)==0) echo ' disabled ';?> name="operaciones" value="enviar3" class="buttonguardar">Guardar y Publicar</button>
		                    </div>
		                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right">
	                    		<div class="text-center textHelper">
	                        		Puedes enviar un correo de prueba, antes de enviarselo a todos tus contactos.
	                        	</div>
	                    		<input type="text" class="form-control" name="correo_prueba[]" placeholder="Introduce la dirección del correo para enviar la prueba...">
	                    		<button type="button" <?php if($seguridad->valida_permiso_usuario($_SESSION['idusuario'],$clave)==0) echo ' disabled ';?> onclick="validar_campo_prueba3()" class="buttonguardar">Enviar Prueba</button>
		                    </div> 
		                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                    	<hr class="hrmenu">
		                    </div>
		                    
		                    <div class="clearfix"></div>
		                    <!--Seccion de los forms
		                    ---------------------------------------------------------------------------------
		                    	En esta sección esta para editar el titulo y la descripcion
		                    -------------------------------------------------------------------------------->
		                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 espacios">
		                    	<div class="row">
		                    		<div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
		                    			<div class="row">
		                    				<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
		                    					<div class="row">
		                    						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		                    							<img src="img/logo.png" width="200" height="80"/>
		                    						</div>
		                    						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		                    							<div id="titulop2" class="form-group espacios">
		                    								<input name="titulop3" type="text" style="margin: 30px 0 0 0" class="form-control" placeholder="Ingrese el titulo aquí..." value="<?php echo ($idCorreo != 0 && $plantilla == 3)? $correo -> titulo: '' ;?>">
		                    							</div>
		                    						</div>
		                    					</div>		                    						                    			
		                    				</div>
		                    			</div>
		                    		</div>		                    		
		                    		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin: 10px 0 0 0">
		                    			<hr class="hrmenu">
		                    		</div>
		                    		<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
		                    			<div id="subtitulop3" class="form-group espacios">
		                        			<input name="subtitulop3" type="text" class="form-control" placeholder="Ingrese el subtitulo aquí..." value="<?php echo ($idCorreo != 0 && $plantilla == 3)? $correo -> subtitulo: '' ;?>">
		                       			</div>
		                    		</div>
		                    		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">&nbsp;</div>
		                    		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin: 10px 0 0 0">
		                    			&nbsp;
		                    		</div>
		                    		<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
		                    			<div class="row">
		                    				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				                    			<span class="textHelper">Previsualizar:</span>
				                       			<br>
				                        		<output align="center" id="listp3">
				                        			<?php
						                        		if($idCorreo != 0 && $plantilla == 3){
						                        			echo '<img width="200" height="200" src="./correos/correo3/'.$correo -> ruta.'" title="Imagen Portada"/>';
						                        		}
					                        		?>
				                        		</output>
				                        		<br>
				                        		<div align="center">
					                    			<div id="imgprinp3" class="fileUpload btn btn-default form-group" style="width:100%">
					                            		<span class="inputUploadFont">Agregar Imagen de Portada</span>
					                            		<input id="filesp3" name="archivop3" type="file" class="upload"/>
					                        		</div>
					                        		<div id="link3" class="form-group espacios">
		                        						<input name="link3" type="text" class="form-control" placeholder="Link de imagen: www.patadeperroviajes.com..." value="<?php echo ($idCorreo != 0 && $plantilla == 3)? $correo -> link: '' ;?>">
		                       						</div>
				                        		</div>
				                        		<br>
				                        		<div class="text-center textHelper">
				                        			Tipo de archivos permitidos: jpg, jpeg, png, gif.
				                            		<br>
				                            		Tamaño máximo de archivo: 4MB.
				                        		</div>
				                    		</div>
				                    		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin: 10px 0 0 0">
				                    			<div id="subtitulo" class="form-group espacios">
				                        			<span class="textHelper">Ingrese una pequeña descripción aquí:</span>
				                        		<textarea name="desc1p3" id="summernotep3"><?php echo ($idCorreo != 0 && $plantilla == 3)? $correo -> desc1: '' ;?></textarea>
				                       			</div>
		                    				</div>
		                    			</div>
		                    		</div>		                    		                    		
		                    		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin: 10px 0 10px 0">
		                    			<hr class="hrmenu">
		                    		</div>
		                    		<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
				                    	<!--<div id="imgsecup3" class="fileUpload btn btn-default" style="width:100%">
				                            <span class="inputUploadFont">Agregar Imágenes Secundarias</span>
				                            <input id="files2p3" name="archivo2p3[]" type="file" class="upload" multiple/>
				                        </div>
				                        <div class="text-center textHelper">
				                        	Tipo de archivos permitidos: jpg, jpeg, png, gif.
			                        		<br>
			                        		Tamaño máximo de archivo: 10MB.
				                        </div>
				                        <div class="espacios">
				                        	<span class="textHelper">Previsualizar:</span>
				                        </div>-->
				                        <span class="textHelper">Seleccione los paquetes que agregará al correo (8 máximo):</span>
				                        <select multiple="multiple" class="searchable" id="paquetes-select" name="paquetes-select[]">
				                        	<option value="0" selected></option>
										  <?php
				                          foreach($listaPaquetes as $paquete)
				                          {
				                          	  $select = "";
				                         	  if( $plantilla == 3 && in_array($paquete -> idPaquete, $correo -> paquetesAsociados) != false){
				                         	  	$select = "selected";
				                         	  }
				                              echo'<option value="'.$paquete -> idPaquete.'" '.$select.' >'.$paquete -> titulo.'</option>';
				                          }
				                          ?>
				                     	</select>
				                    </div><!--Div de cierre col-lg-7-->				                    
				            	</div>
		                    </div>
		                    <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12" style="margin-top: 10px">
				            	<div class="row">
				                	<output align="center" id="list2p3"></output>
				                </div>
				            </div>		                    
		                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin: 10px 0 0 0">
		                    	<hr class="hrmenu">
		                    </div>		                    
		                    <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
		                    	<span class="textHelper">Previsualizar:</span>
		                       	<br>
		                        <output align="center" id="list3p3">
		                        	<?php
			     						if($idCorreo != 0 && $plantilla == 3){
											foreach ($correo->correo2img as $elementoImgS) {
											  echo '
											  		<img style="margin: 0 0 20px 0; height:221px; width:100%;" class="img-responsive" src="./correos/correo3/correo2img/'.$elementoImgS["ruta"].'"/>
													';
												break;
											}
			     						}
										else {
											echo '';
										}
     								?>
		                        </output>
		                        <?php
			     						if($idCorreo != 0 && $plantilla == 3){
											foreach ($correo->correo2img as $elementoImgS) {
											  echo '
											  		<input type="hidden" name="idcorreo3img2" value="'.$elementoImgS["idcorreo3img2"].'" />
													';
												break;
											}
			     						}
										else {
											echo '';
										}
     								?>
		                        <br>
		                        <div align="center">
			                    	<div id="imgterp3" class="fileUpload btn btn-default form-group" style="width:50%">
			                        	<span class="inputUploadFont">Agregar Imagen de Portada</span>
			                            <input id="files3p3" name="archivo3p3" type="file" class="upload"/>
			                        </div>
		                        </div>
		                        <br>
		                        <div class="text-center textHelper">
		                        	Tipo de archivos permitidos: jpg, jpeg, png, gif.
		                        	<br>
		                        	Tamaño máximo de archivo: 4MB.
		                        </div>
		                        <!--<select multiple="multiple" id="my-select3" name="my-select3[]">
		                        	<option value="0" selected></option>
		                              <option value="boletin">Boletines</option>
		                              <option value="clientes">Clientes Registrados</option>
		                     	</select>-->
		                    </div>                
		                    <div class="clearfix"></div>                    
		                    <!--Este div contiene la barra inferior-->
		                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin: 15px 0 0 0">
		                    	<hr class="hrmenu">
		                    </div>
		                    <!--Este div contiene al boton inferior-->
		                    <div class="clearfix"></div>
		                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                    	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-left">
		                    		<div class="text-center textHelper">
		                        		Puedes enviar un correo de prueba, antes de enviarselo a todos tus contactos.
		                        	</div>
		                    		<input type="text" class="form-control" name="correo_prueba[]" placeholder="Introduce la dirección del correo de prueba...">
		                    		<button type="button" <?php if($seguridad->valida_permiso_usuario($_SESSION['idusuario'],$clave)==0) echo ' disabled ';?> onclick="validar_campo_prueba3()" class="buttonguardar">Enviar Prueba</button>
		                    	</div>
		                    		<button type="submit" <?php if($seguridad->valida_permiso_usuario($_SESSION['idusuario'],$clave)==0) echo ' disabled ';?> name="operaciones" value="enviar3" class="buttonguardar">Guardar y Publicar</button>
		                        
		                    </div>
	                    </form>
					  </div>
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
    <div id="loading" style="display:none;"  align="center">
    	<p id="correos_enviados">Enviado... <span id="enviados">0</span> de <span id="por_enviar"></span></p>
    	<img id="" src="img/loading.gif"/>
	</div>
	

<?php
include 'javascripts.html';
?> 
<script src="js/multi-select/js/jquery.multi-select.js"></script>
<script src="js/correos.js"></script>
<script src="js/jquery.quicksearch.js"></script>
<script src="js/jquery.blockUI.js"></script>

<script>
	var idCorreosActivos = new Array();
	var operacion = "ninguna_operacion";
	var idCorreo = "0";
<?php
	if((isset($_REQUEST["opr"]) && $_REQUEST["opr"] != "") && (isset($_REQUEST["c"]) && $_REQUEST["c"] != 0)){

		$listboletin = array();
		$boletin= new Boletin();
		$listboletin= $boletin->listarBoletinActivados();
				

		echo "operacion = ".json_encode($_REQUEST['opr']).";";
		echo "\n";
		echo "idCorreo = ".json_encode($_REQUEST['c']).";";
		echo "\n";

			  foreach($listboletin as $elementoboletin)
				{
					 $idBoletin = $elementoboletin -> idBoletin;
					 echo "idCorreosActivos.push(".json_encode($idBoletin).");";
					 echo "\n";
				}
		
	}
?>
	realizaOperacion();
	
	function realizaOperacion(){
		
		switch(operacion){
			case "ep1":
				$.blockUI({ 
		            message: $('#loading'),
		            css:{
		              backgroundColor: 'none',
		              border: 'hidden'
		            }
            	});
				setTimeout(enviarPlantilla1, 3000);
				break;
			case "ep2":
				$.blockUI({ 
			            message: $('#loading'),
			            css:{
			              backgroundColor: 'none',
			              border: 'hidden'
			            }
	            	});
				setTimeout(enviarPlantilla2, 3000);
				break;
			case "ep3":
					$.blockUI({ 
			            message: $('#loading'),
			            css:{
			              backgroundColor: 'none',
			              border: 'hidden'
			            }
	            	});
				setTimeout(enviarPlantilla3, 3000);
				break;
			default:

				break;
		}
	}

		function enviarPlantilla1(){
			
            $("#por_enviar").html(idCorreosActivos.length);
			for (var i = 0; i < idCorreosActivos.length ; i++) {
				$.ajaxSetup({cache: false});
				$.ajax({
					async:true,
					type: "POST",
					dataType: "html",
					contentType: "application/x-www-form-urlencoded",
					url:"operaciones.php",
					data:"idcorreo1="+idCorreo+"&idBoletin="+idCorreosActivos[i]+"&operaciones=enviarPlantilla1",
					success:function(data){
						console.log(data);
							if(data == "true"){
								var numEnviados = i + 1;
								$("#enviados").html(numEnviados);
							}
							if(data == "false"){
								i--;
							}
							if(data != "true" && data != "false"){
								$("#correos_enviados").html("Ocurrio un error, intentelo de nuevo");
							}
					},
					cache:false
				});
			}
			$.unblockUI();
			alert("Correos enviados exitosamente");
			window.location.replace("mailing.php");
			return;
		}

		function enviarPlantilla2(){
			$("#por_enviar").html(idCorreosActivos.length);
			for (var i = 0; i < idCorreosActivos.length ; i++) {
				$.ajaxSetup({cache: false});
				$.ajax({
					async:true,
					type: "POST",
					dataType: "html",
					contentType: "application/x-www-form-urlencoded",
					url:"operaciones.php",
					data:"idcorreo2="+idCorreo+"&idBoletin="+idCorreosActivos[i]+"&operaciones=enviarPlantilla2",
					success:function(data){
						console.log(data);
							if(data == "true"){
								var numEnviados = i + 1;
								$("#enviados").html(numEnviados);
							}
							if(data == "false"){
								i--;
							}
							if(data != "true" && data != "false"){
								$("#correos_enviados").html("Ocurrio un error, intentelo de nuevo");
							}
					},
					cache:false
				});
			}
			$.unblockUI();
			alert("Correos enviados exitosamente");
			window.location.replace("mailing.php");
			return;
		}

		function enviarPlantilla3(){
			$("#por_enviar").html(idCorreosActivos.length);
			for (var i = 0; i < idCorreosActivos.length ; i++) {
				$.ajaxSetup({cache: false});
				$.ajax({
					async:true,
					type: "POST",
					dataType: "html",
					contentType: "application/x-www-form-urlencoded",
					url:"operaciones.php",
					data:"idcorreo3="+idCorreo+"&idBoletin="+idCorreosActivos[i]+"&operaciones=enviarPlantilla3",
					success:function(data){
						console.log(data);
							if(data == "true"){
								var numEnviados = i + 1;
								$("#enviados").html(numEnviados);
							}
							if(data == "false"){
								i--;
							}
							if(data != "true" && data != "false"){
								$("#correos_enviados").html("Ocurrio un error, intentelo de nuevo");
							}
					},
					cache:false
				});
			}
			$.unblockUI();
			alert("Correos enviados exitosamente");
			window.location.replace("mailing.php");
			return;
		}

</script>
</body>
</html>
