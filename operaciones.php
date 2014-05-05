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
		if(isset( $_REQUEST['usuario'])){
			$usuario = new usuario(0, $_REQUEST['usuario'],$_REQUEST["correo"] ,$_REQUEST['pass'],1,$_REQUEST["question_txt"], $_REQUEST["answer_txt"], $_REQUEST["name_txt"], $_REQUEST["last_name_txt"]);
			$usuasiosEncontrados= $usuario->VerficarDisponibilidadUsuarioEmail();
			$total=count($usuasiosEncontrados);
			if($total == 0){
				$usuario -> inserta_usuario();
				header('Location: index.php');
			}
			else{
				header('Location: index.php?er=usuario%20no%20disponible');
			}
		}
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
		
		case 'verificarusuario':
			if($_REQUEST['username']!=''){
				$total=0;
				
			}
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
		
		case 'enviocontacto':
			
			$mailContacto = new mailContacto();
		
			$mailContacto->nombre=$_REQUEST['nombre'];
			$mailContacto->email=$_REQUEST['email'];
			$mailContacto->telefono = $_REQUEST['telefono'];
			$mailContacto->mensaje=$_REQUEST['mensaje'];
			
			$mailContacto->generaBody();
					
			$mailContacto->send();
			
		break;

		
}
?>