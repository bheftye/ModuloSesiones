<?php
function __autoload($nombre_clase) {
	$nombre_clase = strtolower($nombre_clase);
    include 'clases/'.$nombre_clase .'.php';
}

$operaciones=$_REQUEST['operaciones'];
switch($operaciones){
	case 'agregarpaquete':
		if(isset($_FILES['archivo']['name'])){
			$nameP=$_FILES['archivo']['name'];
			$tmpnameP=$_FILES['archivo']['tmp_name'];
		}
		else{
			$nameP="";
			$tmpnameP="";
		}

		$titulo = $_REQUEST["titulo"];
		$subtitulo = $_REQUEST["subtitulo"];
		$descripcion = htmlspecialchars($_REQUEST["descripcion"], ENT_QUOTES);
		$direccion = $_REQUEST["direccion"];
		$ubicacion = $_REQUEST["ubicacion"];
		$categoria = $_REQUEST["categoria"];
		$clase = $_REQUEST["clase"];
		$disponibilidad = $_REQUEST["disponibilidad"];
		$vigencia = $_REQUEST["vigencia"];
		$precio = $_REQUEST["precio"];
		$recomendar = isset($_POST['recomendar']) && $_POST['recomendar']  ? "1" : "0";
		$status = 1;
		$categorias = $_REQUEST['categorias'];


		$paquete = new Paquete();
		$paquete -> titulo = $titulo;
		$paquete -> subtitulo  = $subtitulo;
		$paquete -> descripcion = $descripcion;
		$paquete -> direccion = $direccion;
		$paquete -> ubicacion = $ubicacion;
		$paquete -> categoria = $categoria;
		$paquete -> clase = $clase;
		$paquete -> disponibilidad = $disponibilidad;
		$paquete -> vigencia = $vigencia;
		$paquete -> precio = $precio;
		$paquete -> recomendado = $recomendar;
		$paquete -> status = $status;
		$paquete -> imgPrincipal = $paquete -> obtenerExtensionArchivo($nameP);
		$paquete -> ruta_temporal = $tmpnameP;
		$paquete -> ruta_final = $paquete -> directorio. $paquete -> imgPrincipal;
		
		$paquete->insertarPaquete();

		foreach ($categorias as $idCategoria) {
			$paquete -> asociaPaqueteACategoria($idCategoria);
		}

		if (isset($_FILES['archivo2']['name'][0])) {
			if ($_FILES['archivo2']['name'][0]!=''){
		 		$tot2 = count($_FILES["archivo2"]["size"]);
         		for ($i = 0; $i < $tot2; $i++){
         			$extension=$_FILES['archivo2']['name'][$i];
         			$name = $paquete->obtenerExtensionArchivo($extension); 
		 			$titulo=$_REQUEST['titulo'];
            		$tmp_name = $_FILES["archivo2"]["tmp_name"][$i]; 
            		$paquete->insertarImgPaquete($name,$tmp_name);       
            	}
			}
		}        
		header('location: listpaquete.php');
	break;
	case 'modificarpaquete':
		if(isset($_FILES['archivo']['name'][0])){
			if ($_FILES['archivo']['name'][0]!=''){
				$nameP=$_FILES['archivo']['name'];
				$tmpnameP=$_FILES['archivo']['tmp_name'];
			}	
		}
		else{
			$nameP='';
			$tmpnameP='';
		}
		$idPaquete = $_REQUEST["idpaquete"];
		$titulo = $_REQUEST["titulo"];
		$subtitulo = $_REQUEST["subtitulo"];
		$descripcion = htmlspecialchars($_REQUEST["descripcion"], ENT_QUOTES);
		$direccion = $_REQUEST["direccion"];
		$ubicacion = $_REQUEST["ubicacion"];
		$categoria = $_REQUEST["categoria"];
		$clase = $_REQUEST["clase"];
		$disponibilidad = $_REQUEST["disponibilidad"];
		$vigencia = $_REQUEST["vigencia"];
		$precio = $_REQUEST["precio"];
		$recomendar = isset($_POST['recomendar']) && $_POST['recomendar']  ? "1" : "0";
		$status = 1;
		$categorias = $_REQUEST['categorias'];


		$paquete = new Paquete();
		if($nameP != ""){
			$nameP = $paquete -> obtenerExtensionArchivo($nameP);
		}
		$paquete -> idPaquete = $idPaquete;
		$paquete -> titulo = $titulo;
		$paquete -> subtitulo  = $subtitulo;
		$paquete -> descripcion = $descripcion;
		$paquete -> direccion = $direccion;
		$paquete -> ubicacion = $ubicacion;
		$paquete -> categoria = $categoria;
		$paquete -> clase = $clase;
		$paquete -> disponibilidad = $disponibilidad;
		$paquete -> vigencia = $vigencia;
		$paquete -> precio = $precio;
		$paquete -> recomendado = $recomendar;
		$paquete -> status = $status;
		$paquete -> imgPrincipal = $nameP;
		$paquete -> ruta_temporal = $tmpnameP;
		$paquete -> ruta_final = $paquete -> directorio. $paquete -> imgPrincipal;

		$paquete->modificarPaquete();
		$paquete -> eliminarAsociacionesACategorias();
		foreach ($categorias as $idCategoria) {
			$paquete -> asociaPaqueteACategoria($idCategoria);
		}
		
		if (isset($_FILES['archivo2']['name'][0])) {
			if ($_FILES['archivo2']['name'][0]!=''){
		 		$tot2 = count($_FILES["archivo2"]["size"]);
         		for ($i = 0; $i < $tot2; $i++){
         			$extension=$_FILES['archivo2']['name'][$i];
         			$name = $paquete->obtenerExtensionArchivo($extension); 
            		$tmp_name = $_FILES["archivo2"]["tmp_name"][$i]; 
            		$paquete->insertarImgPaquete($name,$tmp_name);       
            	}
			}
		}
		if(isset($_FILES['archivo3']['name'])){
			$tot3 = count($_FILES['archivo3']['name']);
			for($i = 0; $i < $tot3; $i++){
				if ($_FILES['archivo3']['error'][$i] == 0 and $_FILES['archivo3']['name'][$i] != ''){
					$extension=$_FILES['archivo3']['name'][$i];
	         		$name = $paquete->obtenerExtensionArchivo($extension); 
	            	$tmp_name = $_FILES["archivo3"]["tmp_name"][$i]; 
	            	$paquete->modificarImgPaquete($_REQUEST['idImgS'][$i], $name, $tmp_name);  
				}			
			}	
		}
		header('location: listpaquete.php');
		break;
		case 'eliminarImgPaquete':
			$paquete = new Paquete();
			$paquete->eliminarImgPaquete($_REQUEST['idImg2']);
		break;
		case 'operapaquete':
			if(isset($_REQUEST['idpaquete'])){
				$select=$_REQUEST['operador'];
				$imgp=0;
				if ($select == 'Eliminar'){
					foreach ($_REQUEST['idpaquete'] as $elementoPaquete) {
						$paquete = new Paquete();
						$paquete -> idPaquete = $elementoPaquete;
						$paquete->listaImgPaquete();
						foreach ($paquete->imgSecundarias as $elementoImgP) {
							$idImgS = $elementoImgP -> idImgS;
							$paquete->eliminarImgPaquete($idImgS);
							$imgp ++;
						}
						$paquete->eliminarPaquete();
					}
					header('location: listpaquete.php?imgp='.$imgp);
				}
				if ($select == 'Mostrar'){
					foreach ($_REQUEST['idpaquete'] as $elementoPaquete) {
						$paquete = new Paquete();
						$paquete -> idPaquete=$elementoPaquete;						
						$paquete->activaPaquete();
					}
					header('location: listpaquete.php');
				}
				if ($select == 'No Mostrar'){
					foreach ($_REQUEST['idpaquete'] as $elementoPaquete) {
						$paquete = new Paquete();
						$paquete -> idPaquete = $elementoPaquete;						
						$paquete -> desactivaPaquete();
					}
					header('location: listpaquete.php');
				}			
			}
			else {
				header('location: listpaquete.php');
			}
		break;
		
		case 'activapaquete':
			 $paquete = new Paquete();
			 $paquete->idPaquete = $_REQUEST['id'];
			 $paquete->activaPaquete();
		break;
		case 'desactivapaquete':
			 $paquete = new Paquete();
			 $paquete->idPaquete = $_REQUEST['id'];
			 $paquete->desactivaPaquete();
		break;
		case 'buscarpaquete':
			 $paquete = new Paquete();
			 $paquete->buscarPaquete($_REQUEST['cadena']);
		break;
		case 'listapaquete':
			 $paquete = new Paquete();
			 $paquete->limitPaquete();
		break;


		case 'agregartip':
		if(isset($_FILES['archivo']['name'])){
			$nameP=$_FILES['archivo']['name'];
			$tmpnameP=$_FILES['archivo']['tmp_name'];
		}
		else{
			$nameP="";
			$tmpnameP="";
		}

		$titulo = $_REQUEST["titulo"];
		$subtitulo = $_REQUEST["subtitulo"];
		$descripcion = htmlspecialchars($_REQUEST["descripcion"], ENT_QUOTES);
		$status = 1;

		$tip = new Tip();
		$tip -> titulo = $titulo;
		$tip -> subtitulo  = $subtitulo;
		$tip -> descripcion = $descripcion;
		$tip -> status = $status;
		$tip -> imgPrincipal = $tip -> obtenerExtensionArchivo($nameP);
		$tip -> ruta_temporal = $tmpnameP;
		$tip -> ruta_final = $tip -> directorio. $tip -> imgPrincipal;
		
		$tip->insertarTip();

		if (isset($_FILES['archivo2']['name'][0])) {
			if ($_FILES['archivo2']['name'][0]!=''){
		 		$tot2 = count($_FILES["archivo2"]["size"]);
         		for ($i = 0; $i < $tot2; $i++){
         			$extension=$_FILES['archivo2']['name'][$i];
         			$name = $tip->obtenerExtensionArchivo($extension); 
            		$tmp_name = $_FILES["archivo2"]["tmp_name"][$i]; 
            		$tip->insertarImgTip($name,$tmp_name);       
            	}
			}
		}        
		header('location: listtip.php');
	break;
	case 'modificartip':
		if(isset($_FILES['archivo']['name'][0])){
			if ($_FILES['archivo']['name'][0]!=''){
				$nameP=$_FILES['archivo']['name'];
				$tmpnameP=$_FILES['archivo']['tmp_name'];
			}	
		}
		else{
			$nameP='';
			$tmpnameP='';
		}
		$idTip = $_REQUEST["idtip"];
		$titulo = $_REQUEST["titulo"];
		$subtitulo = $_REQUEST["subtitulo"];
		$descripcion = htmlspecialchars($_REQUEST["descripcion"], ENT_QUOTES);
		$status = 1;


		$tip = new Tip();
		if($nameP != ""){
			$nameP = $tip -> obtenerExtensionArchivo($nameP);
		}
		$tip -> idTip = $idTip;
		$tip -> titulo = $titulo;
		$tip -> subtitulo  = $subtitulo;
		$tip -> descripcion = $descripcion;
		$tip -> status = $status;
		$tip -> imgPrincipal = $nameP;
		$tip -> ruta_temporal = $tmpnameP;
		$tip -> ruta_final = $tip -> directorio. $tip -> imgPrincipal;

		$tip->modificarTip();
		
		if (isset($_FILES['archivo2']['name'][0])) {
			if ($_FILES['archivo2']['name'][0]!=''){
		 		$tot2 = count($_FILES["archivo2"]["size"]);
         		for ($i = 0; $i < $tot2; $i++){
         			$extension=$_FILES['archivo2']['name'][$i];
         			$name = $tip->obtenerExtensionArchivo($extension); 
            		$tmp_name = $_FILES["archivo2"]["tmp_name"][$i]; 
            		$tip->insertarImgTip($name,$tmp_name);       
            	}
			}
		}
		if(isset($_FILES['archivo3']['name'])){
			$tot3 = count($_FILES['archivo3']['name']);
			for($i = 0; $i < $tot3; $i++){
				if ($_FILES['archivo3']['error'][$i] == 0 and $_FILES['archivo3']['name'][$i] != ''){
					$extension=$_FILES['archivo3']['name'][$i];
	         		$name = $tip->obtenerExtensionArchivo($extension); 
	            	$tmp_name = $_FILES["archivo3"]["tmp_name"][$i]; 
	            	$tip->modificarImgTip($_REQUEST['idImgS'][$i], $name, $tmp_name);  
				}			
			}	
		}
		header('location: listtip.php');
		break;
		case 'eliminarImgTip':
			$tip = new Tip();
			$tip->eliminarImgTip($_REQUEST['idImg2']);
		break;
		case 'operatip':
			if(isset($_REQUEST['idtip'])){
				$select=$_REQUEST['operador'];
				$imgp=0;
				if ($select == 'Eliminar'){
					foreach ($_REQUEST['idtip'] as $elementoTip) {
						$tip = new Tip();
						$tip -> idTip = $elementoTip;
						$tip->listaImgTip();
						foreach ($tip->imgSecundarias as $elementoImgP) {
							$idImgS = $elementoImgP -> idImgS;
							$tip->eliminarImgTip($idImgS);
							$imgp ++;
						}
						$tip->eliminarTip();
					}
					header('location: listtip.php?imgp='.$imgp);
				}
				if ($select == 'Mostrar'){
					foreach ($_REQUEST['idtip'] as $elementoTip) {
						$tip = new Tip();
						$tip -> idTip=$elementoTip;						
						$tip->activaTip();
					}
					header('location: listtip.php');
				}
				if ($select == 'No Mostrar'){
					foreach ($_REQUEST['idtip'] as $elementoTip) {
						$tip = new Tip();
						$tip -> idTip = $elementoTip;						
						$tip -> desactivaTip();
					}
					header('location: listtip.php');
				}			
			}
			else {
				header('location: listtip.php');
			}
		break;
		
		case 'activatip':
			 $tip = new Tip();
			 $tip->idTip = $_REQUEST['id'];
			 $tip->activaTip();
		break;
		case 'desactivatip':
			 $tip = new Tip();
			 $tip->idTip = $_REQUEST['id'];
			 $tip->desactivaTip();
		break;
		case 'buscartip':
			 $tip = new Tip();
			 $tip->buscarTip($_REQUEST['cadena']);
		break;
		case 'listatip':
			 $tip = new Tip();
			 $tip->limitTip();
		break;

		case 'agregarpromocion':
		if(isset($_FILES['archivo']['name'])){
			$nameP=$_FILES['archivo']['name'];
			$tmpnameP=$_FILES['archivo']['tmp_name'];
		}
		else{
			$nameP="";
			$tmpnameP="";
		}

		$titulo = $_REQUEST["titulo"];
		$status = 1;

		$promocion = new Promocion();
		$promocion -> titulo = $titulo;
		$promocion -> status = $status;
		$promocion -> imgPrincipal = $promocion -> obtenerExtensionArchivo($nameP);
		$promocion -> ruta_temporal = $tmpnameP;
		$promocion -> ruta_final = $promocion -> directorio. $promocion -> imgPrincipal;
		
		$promocion->insertarPromocion();
		header('location: listpromocion.php');
	break;
	case 'modificarpromocion':
		if(isset($_FILES['archivo']['name'][0])){
			if ($_FILES['archivo']['name'][0]!=''){
				$nameP=$_FILES['archivo']['name'];
				$tmpnameP=$_FILES['archivo']['tmp_name'];
			}	
		}
		else{
			$nameP='';
			$tmpnameP='';
		}
		$idPromocion = $_REQUEST["idpromocion"];
		$titulo = $_REQUEST["titulo"];
		$status = 1;


		$promocion = new Promocion();
		if($nameP != ""){
			$nameP = $promocion -> obtenerExtensionArchivo($nameP);
		}
		$promocion -> idPromocion = $idPromocion;
		$promocion -> titulo = $titulo;
		$promocion -> status = $status;
		$promocion -> imgPrincipal = $nameP;
		$promocion -> ruta_temporal = $tmpnameP;
		$promocion -> ruta_final = $promocion -> directorio. $promocion -> imgPrincipal;

		$promocion->modificarPromocion();
		
		header('location: listpromocion.php');
		break;
		case 'eliminarImgPromocion':
			$promocion = new Promocion();
			$promocion->eliminarImgPromocion($_REQUEST['idImg2']);
		break;
		case 'operapromocion':
			if(isset($_REQUEST['idpromocion'])){
				$select=$_REQUEST['operador'];
				$imgp=0;
				if ($select == 'Eliminar'){
					foreach ($_REQUEST['idpromocion'] as $elementoPromocion) {
						$promocion = new Promocion();
						$promocion -> idPromocion = $elementoPromocion;						
						$promocion->eliminarPromocion();
					}
					header('location: listpromocion.php?imgp='.$imgp);
				}
				if ($select == 'Mostrar'){
					foreach ($_REQUEST['idpromocion'] as $elementoPromocion) {
						$promocion = new Promocion();
						$promocion -> idPromocion=$elementoPromocion;						
						$promocion->activaPromocion();
					}
					header('location: listpromocion.php');
				}
				if ($select == 'No Mostrar'){
					foreach ($_REQUEST['idpromocion'] as $elementoPromocion) {
						$promocion = new Promocion();
						$promocion -> idPromocion = $elementoPromocion;						
						$promocion -> desactivaPromocion();
					}
					header('location: listpromocion.php');
				}			
			}
			else {
				header('location: listpromocion.php');
			}
		break;
		
		case 'activapromocion':
			 $promocion = new Promocion();
			 $promocion->idPromocion = $_REQUEST['id'];
			 $promocion->activaPromocion();
		break;
		case 'desactivapromocion':
			 $promocion = new Promocion();
			 $promocion->idPromocion = $_REQUEST['id'];
			 $promocion->desactivaPromocion();
		break;
		case 'buscarpromocion':
			 $promocion = new Promocion();
			 $promocion->buscarPromocion($_REQUEST['cadena']);
		break;
		case 'listapromocion':
			 $promocion = new Promocion();
			 $promocion->limitPromocion();
		break;



	case 'agregarboletin':

		$correo = $_REQUEST["correo"];
		$status = 1;

		$boletin = new Boletin();
		$boletin -> correo = $correo;
		$boletin -> status = $status;
		
		$boletin->insertarBoletin();
		header('location: listboletin.php');
	break;
	case 'modificarboletin':
		
		$idboletin = $_REQUEST["idboletin"];
		$correo = $_REQUEST["correo"];
		$status = 1;


		$boletin = new Boletin();
		$boletin -> idBoletin = $idboletin;
		$boletin -> correo = $correo;
		$boletin -> status = $status;

		$boletin->modificarBoletin();
		
		header('location: listboletin.php');
		break;
		case 'operaboletin':
			if(isset($_REQUEST['idboletin'])){
				$select=$_REQUEST['operador'];
				$imgp=0;
				if ($select == 'Eliminar'){
					foreach ($_REQUEST['idboletin'] as $elementoboletin) {
						$boletin = new Boletin();
						$boletin -> idBoletin = $elementoboletin;						
						$boletin->eliminarBoletin();
					}
					header('location: listboletin.php?imgp='.$imgp);
				}
				if ($select == 'Mostrar'){
					foreach ($_REQUEST['idboletin'] as $elementoboletin) {
						$boletin = new Boletin();
						$boletin -> idBoletin=$elementoboletin;						
						$boletin->activarBoletin();
					}
					header('location: listboletin.php');
				}
				if ($select == 'No Mostrar'){
					foreach ($_REQUEST['idboletin'] as $elementoboletin) {
						$boletin = new Boletin();
						$boletin -> idBoletin = $elementoboletin;						
						$boletin -> desactivarBoletin();
					}
					header('location: listboletin.php');
				}			
			}
			else {
				header('location: listboletin.php');
			}
		break;
		
		case 'activaboletin':
			 $boletin = new Boletin();
			 $boletin->idBoletin = $_REQUEST['id'];
			 $boletin->activarBoletin();
		break;
		case 'desactivaboletin':
			 $boletin = new Boletin();
			 $boletin->idBoletin = $_REQUEST['id'];
			 $boletin->desactivarBoletin();
		break;
		case 'buscarboletin':
			 $boletin = new Boletin();
			 $boletin->buscarBoletin($_REQUEST['cadena']);
		break;
		case 'listaboletin':
			 $boletin = new Boletin();
			 $boletin->listarBoletinAjax();
		break;
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



		/*SLIDE*/
		case 'agregarslide':
		if(isset($_FILES['archivo']['name'])){
			$nameP=$_FILES['archivo']['name'];
			$tmpnameP=$_FILES['archivo']['tmp_name'];
		}
		else{
			$nameP="";
			$tmpnameP="";
		}

		$titulo = $_REQUEST["titulo"];
		$status = 1;

		$slide = new Slide();
		$slide -> titulo = $titulo;
		$slide -> status = $status;
		$slide -> imgPrincipal = $slide -> obtenerExtensionArchivo($nameP);
		$slide -> ruta_temporal = $tmpnameP;
		$slide -> ruta_final = $slide -> directorio. $slide -> imgPrincipal;
		
		$slide->insertarSlide();
		header('location: listslide.php');
	break;
	case 'modificarslide':
		if(isset($_FILES['archivo']['name'][0])){
			if ($_FILES['archivo']['name'][0]!=''){
				$nameP=$_FILES['archivo']['name'];
				$tmpnameP=$_FILES['archivo']['tmp_name'];
			}	
		}
		else{
			$nameP='';
			$tmpnameP='';
		}
		$idSlide = $_REQUEST["idslide"];
		$titulo = $_REQUEST["titulo"];
		$status = 1;


		$slide = new Slide();
		if($nameP != ""){
			$nameP = $slide -> obtenerExtensionArchivo($nameP);
		}
		$slide -> idSlide = $idSlide;
		$slide -> titulo = $titulo;
		$slide -> status = $status;
		$slide -> imgPrincipal = $nameP;
		$slide -> ruta_temporal = $tmpnameP;
		$slide -> ruta_final = $slide -> directorio. $slide -> imgPrincipal;

		$slide->modificarSlide();
		
		header('location: listslide.php');
		break;
		case 'eliminarImgSlide':
			$slide = new Slide();
			$slide->eliminarImgSlide($_REQUEST['idImg2']);
		break;
		case 'operaslide':
			if(isset($_REQUEST['idslide'])){
				$select=$_REQUEST['operador'];
				$imgp=0;
				if ($select == 'Eliminar'){
					foreach ($_REQUEST['idslide'] as $elementoSlide) {
						$slide = new Slide();
						$slide -> idSlide = $elementoSlide;						
						$slide->eliminarSlide();
					}
					header('location: listslide.php?imgp='.$imgp);
				}
				if ($select == 'Mostrar'){
					foreach ($_REQUEST['idslide'] as $elementoSlide) {
						$slide = new Slide();
						$slide -> idSlide=$elementoSlide;						
						$slide->activaSlide();
					}
					header('location: listslide.php');
				}
				if ($select == 'No Mostrar'){
					foreach ($_REQUEST['idslide'] as $elementoSlide) {
						$slide = new Slide();
						$slide -> idSlide = $elementoSlide;						
						$slide -> desactivaSlide();
					}
					header('location: listslide.php');
				}			
			}
			else {
				header('location: listslide.php');
			}
		break;
		
		case 'activaslide':
			 $slide = new Slide();
			 $slide->idSlide = $_REQUEST['id'];
			 $slide->activaSlide();
		break;
		case 'desactivaslide':
			 $slide = new Slide();
			 $slide->idSlide = $_REQUEST['id'];
			 $slide->desactivaSlide();
		break;
		case 'buscarslide':
			 $slide = new Slide();
			 $slide->buscarSlide($_REQUEST['cadena']);
		break;
		case 'listaslide':
			 $slide = new Slide();
			 $slide->limitSlide();
		break;

		/*SLIDE*/

		case 'agregarusuario':
			$usuario= new usuario($_REQUEST['idusuario'], $_REQUEST['nomuser'], $_REQUEST['pass'],$_REQUEST['status'],$_REQUEST['tipo']);
			$usuario->inserta_usuario();
			$usuario->insertar_datos_usuario($_REQUEST['nombre'], $_REQUEST['email'], $_REQUEST['telefono']);
			header('Location: listusuarios.php');
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