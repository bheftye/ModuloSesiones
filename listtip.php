<?php
function __autoload($nombre_clase) {
  $nombre_clase = strtolower($nombre_clase);
    include 'clases/'.$nombre_clase .'.php';
}
$seguridad = new seguridad();
$seguridad->candado();

$tip = new Tip();
$listaTip = $tip -> listarTips();
$clave='AgrTip';
$clave2='ElimTip';
$clave3='AcDcTip';
?>
<?php
include('head.html');//Contiene los estilos y los metas.
?>
	<title>Listado Tips</title>
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
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <p class="titulo">Tips</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">                    	
                    	<form action="formtip.php" method="post">
                    		<button <?php if($seguridad->valida_permiso_usuario($_SESSION['idusuario'],$clave)==0) echo ' disabled ';?> value="" class="buttonagregar">Agregar Nuevo</button>
                        </form> 
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    	<hr class="hrmenu">
                    </div>
                    <div class="clearfix"></div>
                    <!--Sección para realizar cambios Nota: el div con la clase styled-large es la que se visualiza con lg y md-->
                    <form method="post" action="operaciones.php">
                    <div class="styled-large">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        	<div class='notifications top-right'></div>
                            <ul class="ulfiltros">
                                <li class="lifiltros">
                                    <div class="styled-select">
                                        <select name="operador">
                                          <option class="styled" <?php if($seguridad->valida_permiso_usuario($_SESSION['idusuario'],$clave2)==0) echo ' disabled ';?>>Eliminar</option>
                                          <option class="styled" <?php if($seguridad->valida_permiso_usuario($_SESSION['idusuario'],$clave3)==0) echo ' disabled ';?>>Mostrar</option>
                                          <option class="styled" <?php if($seguridad->valida_permiso_usuario($_SESSION['idusuario'],$clave3)==0) echo ' disabled ';?>>No Mostrar</option>
                                       </select>
                                    </div>
                                </li>
                                <li class="lifiltros">    
                                    <button type="submit" class="buttonaplicar" name="operaciones" value="operatip">Aplicar</button>
                                </li>
                                <li class="lifiltros" style="display: none">
                                    <div class="styled-select">
                                        <select>
                                          <option class="styled" >Ver Por</option>
                                          <option class="styled" >Por mes</option>
                                          <option class="styled" >Por nombre</option>
                                       </select>
                                    </div>
                                </li>
                                <li class="lifiltros" style="display: none">    
                                    <button class="buttonaplicar">Aplicar</button>
                                </li>
                            </ul>
                            <div class="busqueda"><input type="text" onkeyup="buscarTipPorPalabra(this.value)" class="form-control search" placeholder="Buscar..."></div>                        
                        </div>
                    </div><!--Cierra el div class styled-large-->
     				<div class="clearfix"></div>
                    <!--Esta sección es para la version movil-->
                    <div class="styled-small">
                    	<div class="col-sm-12 col-xs-12">
                        	<div class="busqueda"><input type="text" onkeyup="buscarTipPorPalabra(this.value)" class="form-control search" placeholder="Buscar..."></div> 
                        </div>
                    	<div class="col-sm-12 col-xs-12">
                            <ul class="ulfiltros">
                                <li class="lifiltros">
                                    <div class="styled-select">
                                        <select>
                                          <option class="styled" >Eliminar</option>
                                          <option class="styled" >Mostrar</option>
                                          <option class="styled" >No Mostrar</option>
                                       </select>
                                    </div>
                                </li>
                                <li class="lifiltros">    
                                    <button class="buttonaplicar">Aplicar</button>
                                </li>
                            </ul>                       
                        </div>
                    </div><!--Cierra el div class styled-small-->
                    <div class="clearfix"></div>
                    <!--Seccion de la tabla-->
                    <div class="col-lg-12">
                        <div class="table-responsive">
                          <table class="table table-hover table-striped tablesorter">
                            <thead class="styled-thead">
                              <tr>
                              	<th width="50">
                                	<input type="checkbox" id="marcar" name="marcar" onclick="marcartodos(this);" value="marcar">
									<label for="marcar"><span></span></label>
                                </th>
                                <th width="100">Clave <i class="fa fa-sort"></i></th>
                                <th>Titulo <i class="fa fa-sort"></i></th>
                                <th class="text-center visible-lg visible-md">Mostrar</th>
                              </tr>
                            </thead>
                            <tbody class="styled-tbody">
               	<?php
                 	foreach ($listaTip as $elemento) {
                 			if($seguridad->valida_permiso_usuario($_SESSION['idusuario'],$clave3)==0){
								if($elemento -> status!=0){
									$img='img/visible.png';
									$funcion='';
								}
								else{
							  		$img='img/invisible.png';
									$funcion='';
							   }	
							}
							else{
								if($elemento -> status!=0){
									$img='img/visible.png';
									$funcion='Desactivar('.$elemento -> idTip.')';
								}
								else{
							  		$img='img/invisible.png';
									$funcion='Activar('.$elemento -> idTip.')';
							   }
							}		
                 				
                 			
						echo  '<tr>
                              	<td>
                                	<input type="checkbox" id="'.$elemento -> idTip.'" name="idtip[]" value="'.$elemento -> idTip.'">
									                <label for="'.$elemento -> idTip.'"><span></span></label>
                                </td>
                                <td>'.$elemento -> idTip.'</td>
                                <td><a href="formtip.php?idtip='.$elemento -> idTip.'">'.$elemento -> titulo.'</a></td>
                                <td class="text-center visible-lg visible-md"><img class="manita" onclick="'.$funcion.'" id="temp'.$elemento -> idTip.'" src="'.$img.'"></td>
                              </tr>';
					}
         		?>	       
         					</form>                
                            </tbody>
                            <tfoot class="styled-tfoot">
                              <tr>
                              	<th>
                                	<input type="checkbox" id="marcar2" name="marcar2" onclick="marcartodos(this);" value="marcar2">
									<label for="marcar2"><span></span></label>
                                </th>
                                <th>Clave <i class="fa fa-sort"></i></th>
                                <th>Titulo <i class="fa fa-sort"></i></th>
                                <th class="text-center visible-lg visible-md">Mostrar</th>
                              </tr>
                            </tfoot>
                          </table>
                        </div><!--Div de cierre de la clase table-responsive-->
                    </div><!--Div de cierre que contiene las tablas-->
                    <!--Sección del pie de pagina-->
                    <footer id="footer">
                    	<div class="col-lg-12 text-center">
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
include('javascripts.html');
?>
<script>
	function Activar(id){
		$.ajaxSetup({ cache: false });
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"operaciones.php",
			data:"id="+id+"&operaciones=activatip",
			success:function(data){
					$("#temp"+id).attr("src", "img/visible.png");
					$("#temp"+id).attr("onclick", "Desactivar("+id+")");
			},
			cache:false
		});			
	}
	
	function Desactivar(id){
		$.ajaxSetup({ cache: false });
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"operaciones.php",
			data:"id="+id+"&operaciones=desactivatip",
			success:function(data){				
				$("#temp"+id).attr("src", "img/invisible.png");
				$("#temp"+id).attr("onclick", "Activar("+id+")");			
			},
			cache:false
		});			
	}	
</script>  
</body>
</html>
