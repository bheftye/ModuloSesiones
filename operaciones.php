<?php
function __autoload($nombre_clase) {
	$nombre_clase = strtolower($nombre_clase);
    include 'clases/'.$nombre_clase .'.php';
}

$operaciones=$_REQUEST['operaciones'];
switch($operaciones){
		case "verificardisponibilidad":
			 if(isset($_REQUEST["correo"])){
			 	$boletinVerificador = new Boletin();
			 	$correo = $_REQUEST["correo"];
			 	$boletines = $boletinVerificador -> verificarDisponibilidad($correo);
			 	if(count($boletines) > 0){
			 		echo "false";
			 		break;
			 	}
			 	echo "true";
			 }
			break;

		case 'agregarusuario':
			$usuario = new usuario(0, $_REQUEST['usuario'], $_REQUEST['pass'],1,$_REQUEST["question_txt"], $_REQUEST["answer_txt"], $_REQUEST["name_txt"], $_REQUEST["last_name_txt"]);
			$usuario -> inserta_usuario();
			header('Location: index.php');
		break;
		case 'modificarusuario':
			if($_REQUEST['nameuser'] == 'nameuser'){
				$nameuser=$_REQUEST['nomuser'];
			}
			else{
				$nameuser='';
			}
			if($_REQUEST['contra'] == 'pass'){
				$pass = $_REQUEST['pass'];
			}
			else{
				$pass='';
			}
			$usuario= new usuario($_REQUEST['idusuario'], $nameuser, $pass, $_REQUEST['status'],$_REQUEST['tipo']);
			$usuario->modifica_usuario();
			$usuario->modificar_datos_usuario($_REQUEST['nombre'], $_REQUEST['email'], $_REQUEST['telefono']);
			header('Location: listusuarios.php');
		break;
		case 'operausuario':
			if(isset($_REQUEST['idusuario'])){
				$select=$_REQUEST['operador'];
				if ($select == 'Eliminar'){
					foreach ($_REQUEST['idusuario'] as $elementoUsuario) {
						$usuario = new usuario($elementoUsuario);
						$usuario ->eliminar_datos_usuario();
						$usuario->elimina_usuario();
					}
					header('location: listusuarios.php');
				}
				if ($select == 'Mostrar'){
					foreach ($_REQUEST['idusuario'] as $elementoUsuario) {
						$usuario = new usuario($elementoUsuario);
						$usuario -> ActivaUsuario();
					}
					header('location: listusuarios.php');
				}
				if ($select == 'No Mostrar'){
					foreach ($_REQUEST['idusuario'] as $elementoUsuario) {
						$usuario = new usuario($elementoUsuario);
						$usuario->DesactivaUsuario();
					}
					header('location: listusuarios.php');
				}					
			}
			else {
				header('location: listusuarios.php');
			}	
		break;
		case 'activausuario':
			$usuario= new usuario($_REQUEST['id']);
			$usuario->ActivaUsuario();
		break;
		case 'desactivausuario':
			$usuario= new usuario($_REQUEST['id']);
			$usuario->DesactivaUsuario();
		break;
		case 'buscarusuario':
			$usuario= new usuario();
			$usuario->listaUsuarioBusqueda($_REQUEST['cadena']);
		break;
		case 'listausuario':
			$usuario= new usuario();
			$usuario->lista_usuario_Ajax();
		break;
		case 'agregartipousuario':
			$tipousuario= new tipousuario($_REQUEST['idtipousuario'],$_REQUEST['titulo'],$_REQUEST['status']);
			$tipousuario->insertar_tipousuario();
			$idtipousuario=$tipousuario->idtipousuario;
			if(isset($_REQUEST['idpermiso']))
			{
				$tipousuarioxpermiso = new tiposusuarioxpermiso(0,0);
				$tipousuarioxpermiso->idtipousuario=$idtipousuario;
				$tipousuarioxpermiso->desasigna_permiso_rol();

				foreach($_REQUEST['idpermiso'] as $elementoPermiso)
				{
					$tipousuarioxpermiso->idpermiso=$elementoPermiso;
					$tipousuarioxpermiso->asigna_permiso_rol();
				}	
			}
		header('location:listtipousuario.php');
		break;
		case 'modificartipousuario':
		$tipousuario=new tipousuario($_REQUEST['idtipousuario'],$_REQUEST['titulo'],$_REQUEST['status']);
		$tipousuario->modificar_tipousuario();
		if(isset($_REQUEST['idpermiso']))
		{
			$tipousuarioxpermiso = new tiposusuarioxpermiso(0,0);
			$tipousuarioxpermiso->idtipousuario=$_REQUEST['idtipousuario'];
			$tipousuarioxpermiso->desasigna_permiso_rol();
		
			foreach($_REQUEST['idpermiso'] as $elementoPermiso)
			{
				$tipousuarioxpermiso->idpermiso=$elementoPermiso;
				$tipousuarioxpermiso->asigna_permiso_rol();
			}	
		}
		else
		{
			$tipousuarioxpermiso = new tiposusuarioxpermiso();
			$tipousuarioxpermiso->idtipousuario=$_REQUEST['idtipousuario'];
			$tipousuarioxpermiso->desasigna_permiso_rol();
		
			foreach($_REQUEST['idpermiso'] as $elementoPermiso)
			{
				$tipousuarioxpermiso->idpermiso=$elementoPermiso;
				$tipousuarioxpermiso->asigna_permiso_rol();
			}	
		}
		header('location:listtipousuario.php');
		break;
		case 'operatipousuario':
			if(isset($_REQUEST['idtipousuario'])){
				$select=$_REQUEST['operador'];
				if ($select == 'Eliminar'){
					foreach ($_REQUEST['idtipousuario'] as $elementoUsuario) {
						$tipousuario = new tipousuario($elementoUsuario);
						$tipousuarioxpermiso = new tiposusuarioxpermiso($elementoUsuario);
						$tipousuarioxpermiso->desasigna_permiso_rol();
						$tipousuario->elimina_Tipousuario();
					}
					header('location: listtipousuario.php');
				}
				
				if ($select == 'Mostrar'){
					foreach ($_REQUEST['idtipousuario'] as $elementoUsuario) {
						$tipousuario = new tipousuario($elementoUsuario);						
						$tipousuario->ActivaTipousuario();
					}
					header('location: listtipousuario.php');
				}
				if ($select == 'No Mostrar'){
					foreach ($_REQUEST['idtipousuario'] as $elementoUsuario) {
						$tipousuario = new tipousuario($elementoUsuario);						
						$tipousuario -> DesactivaTipousuario();
					}
					header('location: listtipousuario.php');
				}				
			}
			else {
				header('location: listtipousuario.php');
			}	
		break;
		case 'activatipoU':
			$tipousuario= new tipousuario($_REQUEST['id']);
			$tipousuario->ActivaTipousuario();
		break;
		case 'desactivatipoU':
			$tipousuario= new tipousuario($_REQUEST['id']);
			$tipousuario->DesactivaTipousuario();
		break;
		case 'buscartipousuario':
			$tipousuario= new tipousuario();
			$tipousuario->listaTipousuarioBusqueda($_REQUEST['cadena']);
		break;
		case 'listatipousuario':
			$tipousuario= new tipousuario();
			$tipousuario->listado_tipousuarioAjax();
		break;
 		case 'agregarpermiso':
			$permiso = new permiso($_REQUEST['idpermiso'],$_REQUEST['titulo'],$_REQUEST['clave'],$_REQUEST['status']);
			$permiso->insertar_permiso();
			header('Location: listpermisos.php');
		break;
		case 'modificarpermiso':
			$permiso = new permiso($_REQUEST['idpermiso'],$_REQUEST['titulo'],$_REQUEST['clave'],$_REQUEST['status']);
			$permiso->modificar_permiso();
			header('Location: listpermisos.php');
		break;  
		case 'verificarusuario':
			if($_REQUEST['username']!=''){
				$total=0;
				$username = $_REQUEST['username'];
				$usuario= new usuario(0,$username,'','','');
				$verificar=$usuario->VerficarDisponibilidadNomUsuario($username);
				$total=count($verificar);
		
				if($total != 0)
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Advertencia!</strong> Este usuario ya existe o es su actual nombre de usuario, para poder continuar intente con otro nombre.</div>';
				else
					echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Bien hecho!</strong> Nombre de usuario disponible.</div>';
			}
			else
				echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Advertencia!</strong> Se requiere de este campo para poder continuar.</div>';
		break;
		case 'ingresar':
			$user=new usuario(0,$_REQUEST['usuario'],$_REQUEST['pass'],0,0);
			$user->login();
			if($user->idusuario!=0){
				session_start();
				$_SESSION['idusuario']=$user->idusuario;
				echo "true";
				//header('Location:listpropiedad.php');
			}
			
			else{
				session_start();
				if(isset($_SESSION['idusuario']));
				session_destroy();
				//header('Location:index.php');
				echo "false";
			}
		break;
		case 'recuperapass':
			if($_REQUEST['email']!='')
			{
				$usuario = new usuario();
				$usuario->datosusuario->email=$_REQUEST['email'];
				$lista = $usuario->datosusuario->buscaremail();
				$total = count($lista);
				if($total > 0)
				{
					foreach($lista as $elementoCliente)
					{
						$idusuario = $elementoCliente['idusuario']; 
						$correoRecu= new correoRecuperacion($idusuario);
						$correoRecu->enviar();
						echo 2;
					}
				}
				else
					echo 1;
			}
			else
				echo 0;
	    break;
		case 'cerrarsesion':
			session_start();
			if(isset($_SESSION['idusuario']));
			session_destroy();
			echo 1;
		break;
		case 'vista':
						
			$propiedad = new propiedad();
			$propiedad->listPropiedadJSON($_REQUEST['paginaactual']);
		break;
		case 'vistaordenar':
			$propiedad = new propiedad();
			$propiedad->OrdenarJSON($_REQUEST['valor'],$_REQUEST['pagina']);
		break;
		case 'vistafinder':
			$propiedad = new propiedad();			
			$propiedad->findPropertyJSON($_REQUEST['operacion'],$_REQUEST['inmueble'],$_REQUEST['ciudad'],$_REQUEST['zona'],$_REQUEST['precio'],$_REQUEST['clave'],$_REQUEST['pagina']);
		break;
		case 'enviocontacto':
			
			$mailContacto = new mailContacto();
		
			$mailContacto->nombre=$_REQUEST['nombre'];
			$mailContacto->email=$_REQUEST['email'];
			$mailContacto->telefono = $_REQUEST['telefono'];
			$mailContacto->mensaje=$_REQUEST['mensaje'];
			$mailContacto->ciudad=$_REQUEST['ciudad'];
			
			$mailContacto->generaBody();
					
			$mailContacto->send();
			
		break;

		/*Mailing*/
			case "enviarPlantilla1":
					if(isset($_REQUEST["idcorreo1"]) && isset($_REQUEST["idBoletin"])){
						$tempcorreo1= new tempcorreo1($_REQUEST["idcorreo1"],0,$_REQUEST["idBoletin"]);
						$tempcorreo1->enviar();
						usleep(1000000);
						echo "true";
						break;
					}
					echo "false";

				break;
			case 'enviar':

				if(isset($_FILES['archivo']['name'])){
					if ($_FILES['archivo']['name']!=''){
						$nameP=$_FILES['archivo']['name'];
						$tmpnameP=$_FILES['archivo']['tmp_name'];
					}	
				}
				else{
					$nameP='';
					$tmpnameP='';
				}

				$idcorreo = 0;

				if(isset($_REQUEST["idcorreo1"])){
					if($_REQUEST["idcorreo1"] != 0 && $_REQUEST["idcorreo1"] != ""){
						$idcorreo = $_REQUEST["idcorreo1"];
					}
				}

				$correo1 = new correo1($idcorreo,$nameP,$_REQUEST['titulo'],$_REQUEST['subtitulo'] ,$_REQUEST['desc1'],$_REQUEST['desc2'],$_REQUEST['desc3'],$tmpnameP);


				if($idcorreo != 0){
					$correo1 -> idcorreo1 = $_REQUEST["idcorreo1"];
					$correo1 -> modificaCorreo1();
				}
				else{
					$correo1->insertaCorreo1();
				}

				$idcorreo = $correo1->idcorreo1;
				
				if(isset($_FILES['archivo2']['name'])){
					$tot3 = count($_FILES['archivo2']['name']);
					for($i = 0; $i < $tot3; $i++){
						if ($_FILES['archivo2']['error'][$i] == 0 and $_FILES['archivo2']['name'][$i] != ''){
							$extension=$_FILES['archivo2']['name'][$i];
			         		$name = $correo1->obtenerExtensionArchivo($extension); 
					 		$titulo=$_REQUEST['titulo'];
			            	$tmp_name = $_FILES["archivo2"]["tmp_name"][$i]; 
			            	$correo1->insertarCorreo1img($titulo, $name, $tmp_name);  
						}			
					}
				}

				if(isset($_REQUEST["idcorreo1"])){
					if(isset($_FILES['archivo23']['name'])){
						$tot3 = count($_FILES['archivo23']['name']);
						for($i = 0; $i < $tot3; $i++){
							if ($_FILES['archivo23']['error'][$i] == 0 and $_FILES['archivo23']['name'][$i] != ''){
								$extension=$_FILES['archivo23']['name'][$i];
				         		$name = $correo1->obtenerExtensionArchivo($extension);
				         		$titulo=$_REQUEST['titulo'];
				            	$tmp_name = $_FILES["archivo23"]["tmp_name"][$i]; 
				            	$correo1->modificarCorreo1img($_REQUEST['correo1img'][$i],$titulo,$name, $tmp_name);
							}			
						}	
					}
				}


				if(isset($_FILES['archivo3']['name'])){
					$titulo3=$correo1->obtenerExtensionArchivo($_FILES['archivo3']['name']);
					$ruta3=$_FILES['archivo3']['name'];
					$temporal3=$_FILES['archivo3']['tmp_name'];
					if(isset($_REQUEST["idcorreo1img2"])){
						$correo1 -> modificarCorreo1img2($_REQUEST["idcorreo1img2"],$titulo3,$ruta3,$temporal3);
					}
					else{
						$correo1->insertarCorreo1img2($ruta3, $titulo3, $temporal3);
					}
					
				}

				
				$contador = 0;
				$success = 0;
				if(isset($_REQUEST["correo_prueba"])){
					$correosPrueba = $_REQUEST["correo_prueba"];
					$correoPrueba = "";
					foreach ($correosPrueba as $correo) {
						if($correo != ""){
							$correoPrueba = $correo;
							break;
						}
					}
					if($correoPrueba != ""){
						$tempcorreo1= new tempcorreo1($idcorreo,0,0, $correoPrueba);
						$tempcorreo1->enviar();
						header("Location:mailing.php?c=".$idcorreo."&p=1");
						break;
						exit();
					}

				}

				/*$listboletin = array();
				$boletin= new Boletin();
				$listboletin= $boletin->listarBoletinActivados();
				foreach($listboletin as $elementoboletin)
				{

					$tempcorreo1= new tempcorreo1($idcorreo,0,$elementoboletin -> idBoletin);
					$tempcorreo1->enviar();
					usleep(1000000);
					$contador++;
				}*/
				//header('Location: mailing.php?success=2&cont='.$contador);
				header("Location:mailing.php?c=".$idcorreo."&p=1&opr=ep1");
					
		break;

		case 'eliminarImagenSecundariaCorreo1':
				if(isset($_REQUEST["idcorreo1"]) && isset($_REQUEST["idcorreoimg1"]))
				{
					$correo1 = new correo1($_REQUEST["idcorreo1"]);
					$correo1 -> eliminarCorreo1img($_REQUEST["idcorreoimg1"]);
					echo "true";
				}
				else{
					echo "false";
				}
				break;

		case "enviarPlantilla2":
					if(isset($_REQUEST["idcorreo2"]) && isset($_REQUEST["idBoletin"])){
						$tempcorreo2= new tempcorreo2($_REQUEST["idcorreo2"],0,$_REQUEST["idBoletin"]);
						$tempcorreo2->enviar();
						usleep(1000000);
						echo "true";
						break;
					}
					echo "false";

				break;

		case 'enviar2':

			if(isset($_FILES['archivop2']['name'])){
					if ($_FILES['archivop2']['name']!=''){
						$nameP=$_FILES['archivop2']['name'];
						$tmpnameP=$_FILES['archivop2']['tmp_name'];
					}	
				}
				else{
					$nameP='';
					$tmpnameP='';
				}

			$idcorreo2 = 0;

			if(isset($_REQUEST["idcorreo2"])){
				if($_REQUEST["idcorreo2"] != 0 && $_REQUEST["idcorreo2"] != ""){
					$idcorreo2 = $_REQUEST["idcorreo2"];
				}
			}

			$correo2 = new correo2(0,$nameP,$_REQUEST['titulop2'],$_REQUEST['subtitulop2'],$_REQUEST['desc1p2'],$_REQUEST['desc2p2'],$_REQUEST['desc3p2'],$_REQUEST['desc4p2'],$tmpnameP);
			
			if($idcorreo2 != 0){
				$correo2 -> idcorreo2 = $_REQUEST["idcorreo2"];
				$correo2 -> modificaCorreo2();
			}
			else{
				$correo2->insertaCorreo2();
			}

			$idcorreo2 = $correo2->idcorreo2;
			
			
			
			if(isset($_FILES['archivo2p2']['name'])){
				$tot3 = count($_FILES['archivo2p2']['name']);
				for($i = 0; $i < $tot3; $i++){
					if ($_FILES['archivo2p2']['error'][$i] == 0 and $_FILES['archivo2p2']['name'][$i] != ''){
						$extension=$_FILES['archivo2p2']['name'][$i];
		         		$name = $correo2->obtenerExtensionArchivo($extension); 
				 		$titulo=$_REQUEST['titulop2'];
		            	$tmp_name = $_FILES["archivo2p2"]["tmp_name"][$i]; 
		            	$correo2->insertarCorreo2img($titulo, $name, $tmp_name);  
					}			
				}
			}

			if(isset($_REQUEST["idcorreo2"])){
					if(isset($_FILES['archivo2p23']['name'])){
						$tot3 = count($_FILES['archivo2p23']['name']);
						for($i = 0; $i < $tot3; $i++){
							if ($_FILES['archivo2p23']['error'][$i] == 0 and $_FILES['archivo2p23']['name'][$i] != ''){
								$extension=$_FILES['archivo2p23']['name'][$i];
				         		$name = $correo2->obtenerExtensionArchivo($extension);
				         		$titulo=$_REQUEST['titulo'];
				            	$tmp_name = $_FILES["archivo2p23"]["tmp_name"][$i]; 
				            	$correo2->modificarCorreo2img($_REQUEST['correo2img'][$i],$titulo,$name, $tmp_name);
							}			
						}	
					}
			}


			if(isset($_FILES['archivo3p2']['name'])){
				$titulo3=$correo2->obtenerExtensionArchivo($_FILES['archivo3p2']['name']);
				$ruta3=$_FILES['archivo3p2']['name'];
				$temporal3=$_FILES['archivo3p2']['tmp_name'];
				if(isset($_REQUEST["idcorreo2img2"])){
						$correo2 -> modificarCorreo2img2($_REQUEST["idcorreo2img2"],$titulo3,$ruta3,$temporal3);
					}
					else{
						$correo2->insertarCorreo2img2($ruta3, $titulo3, $temporal3);
					}
			}

			$contador = 0;
			$success = 0;
			if(isset($_REQUEST["correo_prueba"])){
					$correosPrueba = $_REQUEST["correo_prueba"];
					$correoPrueba = "";
					foreach ($correosPrueba as $correo) {
						if($correo != ""){
							$correoPrueba = $correo;
							break;
						}
					}
					if($correoPrueba != ""){
						$tempcorreo2= new tempcorreo2($idcorreo2,0,0, $correoPrueba);
						$tempcorreo2->enviar();
						header("Location:mailing.php?c=".$idcorreo2."&p=2");
						break;
						exit();
					}
			}

			/*$listboletin = array();
			$boletin= new Boletin();
			$listboletin= $boletin->listarBoletinActivados();
			foreach($listboletin as $elementoboletin)
			{
				$tempcorreo2 = new tempcorreo2($idcorreo2,0,$elementoboletin -> idBoletin);
				$tempcorreo2 ->enviar();
				usleep(1000000);
				$contador++;
			}*/
			header("Location:mailing.php?c=".$idcorreo2."&p=2&opr=ep2");

		break;

		case 'eliminarImagenSecundariaCorreo2':
				if(isset($_REQUEST["idcorreo2"]) && isset($_REQUEST["idcorreoimg2"]))
				{
					$correo2 = new correo2($_REQUEST["idcorreo2"]);
					$correo2 -> eliminarCorreo2img($_REQUEST["idcorreoimg2"]);
					echo "true";
				}
				else{
					echo "false";
				}
				break;

		case "enviarPlantilla3":
					if(isset($_REQUEST["idcorreo3"]) && isset($_REQUEST["idBoletin"])){
						$tempcorreo3 = new tempcorreo3($_REQUEST["idcorreo3"],0,$_REQUEST["idBoletin"]);
						$tempcorreo3->enviar();
						usleep(1000000);
						echo "true";
						break;
					}
					echo "false";

				break;

		case 'enviar3':
			if(isset($_FILES['archivop3']['name'])){
					if ($_FILES['archivop3']['name']!=''){
						$nameP=$_FILES['archivop3']['name'];
						$tmpnameP=$_FILES['archivop3']['tmp_name'];
					}	
				}
				else{
					$nameP='';
					$tmpnameP='';
				}

			$idcorreo3 = 0;

			if(isset($_REQUEST["idcorreo3"])){
				if($_REQUEST["idcorreo3"] != 0 && $_REQUEST["idcorreo3"] != ""){
					$idcorreo3 = $_REQUEST["idcorreo3"];
				}
			}

			$paquetesAsociados = array();
			if(isset($_REQUEST["paquetes-select"])){
				foreach ($_REQUEST["paquetes-select"] as $idPaquete) {
					if($idPaquete != 0){
						array_push($paquetesAsociados, $idPaquete);
					}
				}
				
			}

			$correo3 = new correo3(0,$nameP,$_REQUEST['titulop3'], $_REQUEST["link3"],$_REQUEST['subtitulop3'],$_REQUEST['desc1p3'],$tmpnameP, $paquetesAsociados);

			if($idcorreo3 != 0){
				$correo3 -> idcorreo3 = $_REQUEST["idcorreo3"];
				$correo3 -> modificaCorreo3();
			}
			else{
				$correo3 -> insertaCorreo3();
			}
			
			$idcorreo3 = $correo3 -> idcorreo3;
			
			/*if(isset($_FILES['archivo2p3']['name'])){
				$tot3 = count($_FILES['archivo2p3']['name']);
				for($i = 0; $i < $tot3; $i++){
					if ($_FILES['archivo2p3']['error'][$i] == 0 and $_FILES['archivo2p3']['name'][$i] != ''){
						$extension=$_FILES['archivo2p3']['name'][$i];
		         		$name = $correo3->obtenerExtensionArchivo($extension); 
				 		$titulo=$_REQUEST['titulop3'];
		            	$tmp_name = $_FILES["archivo2p3"]["tmp_name"][$i]; 
		            	$correo3->insertarCorreo3img($titulo, $name, $tmp_name);  
					}			
				}
			}*/

			if(isset($_FILES['archivo3p3']['name'])){
				$titulo3=$correo3->obtenerExtensionArchivo($_FILES['archivo3p3']['name']);
				$ruta3=$_FILES['archivo3p3']['name'];
				$temporal3=$_FILES['archivo3p3']['tmp_name'];
				if(isset($_REQUEST["idcorreo3img2"])){
					$correo3-> modificarCorreo3img2($_REQUEST["idcorreo3img2"],$ruta3, $titulo3, $temporal3);
				}
				else{
					$correo3->insertarCorreo3img2($ruta3, $titulo3, $temporal3);
				}
				
			}

			$contador = 0;
			$success = 0;

			if(isset($_REQUEST["correo_prueba"])){
					$correosPrueba = $_REQUEST["correo_prueba"];
					$correoPrueba = "";
					foreach ($correosPrueba as $correo) {
						if($correo != ""){
							$correoPrueba = $correo;
							break;
						}
					}
					if($correoPrueba != ""){
						$tempcorreo3= new tempcorreo3($idcorreo3,0,0, $correoPrueba);
						$tempcorreo3->enviar();
						header("Location:mailing.php?c=".$idcorreo3."&p=3");
						break;
						exit();
					}
			}
					
			/*$listboletin = array();
			$boletin= new Boletin();
			$listboletin= $boletin->listarBoletinActivados();
			foreach($listboletin as $elementoboletin)
			{
				$tempcorreo3= new tempcorreo3($idcorreo3,0,$elementoboletin -> idBoletin);
				echo $elementoboletin -> correo;
				$tempcorreo3->enviar();
				usleep(1000000);
				$contador++;
			}
			*/
			header("Location:mailing.php?c=".$idcorreo3."&p=3&opr=ep3");
					
		break;
		/*Mailing*/
}
?>