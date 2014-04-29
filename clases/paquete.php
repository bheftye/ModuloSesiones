<?php
include_once ('conexion.php');
require_once ('archivo.php');
include_once ('imgpaquete.php');
	class Paquete extends Archivo{
		var $idPaquete;
		var $titulo;
		var $subtitulo;
		var $descripcion;
		var $direccion;
		var $ubicacion;
		var $categoria;
		var $clase;
		var $disponibilidad;
		var $vigencia;
		var $precio;
		var $recomendado;
		var $imgSecundarias;
		var $imgPrincipal;
		var $directorio = '../paquetes/principales/';
		var $status;
		
		function Paquete($idPaquete = 0, $titulo = "",$subtitulo ="", $descripcion = "", $imgPrincipal = "", $direccion ="", $ubicacion = "", $categoria = "", $clase = "", $disponibilidad = "", $clase = "", $vigencia = "", $precio = "", $recomendado = 0, $imgSecundarias = array(), $status = 1){
			$this ->  idPaquete = $idPaquete;
			$this ->  titulo = $titulo;
			$this -> subtitulo = $subtitulo;
			$this ->  descripcion = $descripcion;
			$this -> direccion = $direccion;
			$this ->  ubicacion = $ubicacion;
			$this ->  categoria = $categoria;
			$this ->  clase = $clase;
			$this ->  disponibilidad = $disponibilidad;
			$this ->  vigencia = $vigencia;
			$this ->  precio = $precio;
			$this ->  recomendado = $recomendado;
			$this ->  imgSecundarias = $imgSecundarias;
			$this ->  imgPrincipal = $imgPrincipal;
			$this -> status = $status;
		}

		function insertarPaquete() {
			$fechaCreacion = date("Y-m-d");
			$sql = "INSERT INTO `paquetes`(`titulo`, `subtitulo`, `fecha`, `fecha_modificacion`, `descripcion`, `imagenp`, `direccion`, `ubicacion`, `categoria`, `clase`, `disponibilidad`, `vigencia`, `precio`, `recomendado`) VALUES ('".$this -> titulo."','".$this -> subtitulo."','".$fechaCreacion."','".$fechaCreacion."','".$this -> descripcion."','".$this -> imgPrincipal."','".$this -> direccion."','".$this -> ubicacion."','".$this -> categoria."','".$this -> clase."','".$this -> disponibilidad."','".$this -> vigencia."','".$this -> precio."', ".$this -> recomendado.")";
			$con = new conexion();
			$this -> idPaquete = $con -> ejecutar_sentencia($sql);
			$this -> subir_archivo();
		}

		function modificarPaquete() {
			if ($this -> imgPrincipal != '') {
				$paquete = new Paquete($this -> idPaquete);
				$paquete -> obtenerPaquete();
				$paquete -> ruta_final = $paquete -> directorio. $paquete -> imgPrincipal;
				$paquete -> borrar_archivo();

				$this -> ruta_final = $this -> directorio . $this -> imgPrincipal;
				$sql = ' imagenp=\'' . $this -> imgPrincipal . '\',';
			} else {
				$sql = '';
			}
			
			$fechaModificacion = date("Y-m-d");
			$sql = "UPDATE `paquetes` SET ".$sql." `titulo`= '".$this -> titulo."',`subtitulo`='".$this -> subtitulo."', `fecha_modificacion`='".$fechaModificacion."',`descripcion`='".$this -> descripcion."',`direccion`='".$this -> direccion."',`ubicacion`='".$this -> ubicacion."',`categoria`='".$this -> categoria."',`clase`='".$this -> clase."',`disponibilidad`='".$this -> disponibilidad."',`vigencia`='".$this -> vigencia."',`precio`='".$this -> precio."',`recomendado`= ".$this -> recomendado." WHERE id_paquete = ".$this -> idPaquete." ;";
			$con = new conexion();
			$con -> ejecutar_sentencia($sql);
			$this -> subir_archivo();	
		}

		function eliminarPaquete() {
			$this -> recuperarPaquete();
			$this -> borrar_archivo();
			$this -> eliminarAsociacionesACategorias();
			$sql = "delete from paquetes where id_paquete =" . $this -> idPaquete . ";";
			$con = new conexion();
			$con -> ejecutar_sentencia($sql);
		}

		function desactivaPaquete() {
			$con = new conexion();
			$sql = "update paquetes set status = 0 where id_paquete =" . $this -> idPaquete;
			$con -> ejecutar_sentencia($sql);
		}

		function activaPaquete() {
			$con = new conexion();
			$sql = "update paquetes set status = 1 where id_paquete =" . $this -> idPaquete;
			$con -> ejecutar_sentencia($sql);
		}

		function llenarPaqueteConSusDatos($filaSQL){
			$this ->  idPaquete = $filaSQL["id_paquete"];
			$this ->  titulo = $filaSQL["titulo"];
			$this -> subtitulo = $filaSQL["subtitulo"];
			$this ->  descripcion = htmlspecialchars_decode($filaSQL["descripcion"]);
			$this ->  ubicacion = $filaSQL["ubicacion"];
			$this ->  categoria = $filaSQL["categoria"];
			$this ->  clase = $filaSQL["clase"];
			$this ->  disponibilidad = $filaSQL["disponibilidad"];
			$this ->  vigencia = $filaSQL["vigencia"];
			$this ->  precio = $filaSQL["precio"];
			$this ->  recomendado = $filaSQL["recomendado"];
			$this ->  imgPrincipal = $filaSQL['imagenp'];
			$this -> ruta_final = $this -> directorio . $filaSQL['imagenp'];
			$this -> status = $filaSQL["status"];
		}	

		function listarPaquetesActivos() {
			$resultados = array();
			$sql = "SELECT * FROM paquetes WHERE status = 1 ORDER BY id_paquete DESC";
			$con = new conexion();
			$temporal = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($temporal)) {
				$paquete = new Paquete();
				$paquete -> llenarPaqueteConSusDatos($fila);
				$paquete -> listaImgPaquete();
				array_push($resultados, $paquete);
			}
			mysql_free_result($temporal);
			return $resultados;
		}

		function listarPaquetesPorFecha(){
			$resultados = array();
			$sql = "SELECT * FROM paquetes WHERE status = 1 ORDER BY fecha_modificacion DESC";
			$con = new conexion();
			$temporal = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($temporal)) {
				$paquete = new Paquete();
				$paquete -> llenarPaqueteConSusDatos($fila);
				$paquete -> listaImgPaquete();
				array_push($resultados, $paquete);
			}
			mysql_free_result($temporal);
			return $resultados;
		}

		function listarPaquetesDesactivados() {
			$resultados = array();
			$sql = "SELECT * FROM paquetes WHERE status = 0 ORDER BY id_paquete DESC";
			$con = new conexion();
			$temporal = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($temporal)) {
				$paquete = new Paquete();
				$paquete -> llenarPaqueteConSusDatos($fila);
				$paquete -> listaImgPaquete();
				array_push($resultados, $paquete);
			}
			mysql_free_result($temporal);
			return $resultados;
		}

		function obtenerPaquetesActivosPorCategoria($idCategoria){
			$resultados = array();
			$sql = "SELECT paquetes.id_paquete, titulo, subtitulo, descripcion, ubicacion, categoria, clase, disponibilidad, vigencia, precio, recomendado, imagenp, status FROM paquetes LEFT JOIN paquetes_categorias ON paquetes.id_paquete = paquetes_categorias.id_paquete WHERE id_categoria = ".$idCategoria." and status = 1 ORDER BY paquetes.id_paquete DESC;";
			$con = new conexion();
			$temporal = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($temporal)) {
				$paquete = new Paquete();
				$paquete -> llenarPaqueteConSusDatos($fila);
				$paquete -> listaImgPaquete();
				array_push($resultados, $paquete);
			}
			mysql_free_result($temporal);
			return $resultados;
		}


		function obtenerPaquetesActivosPorCategoriaConLimite($idCategoria, $limite){
			$resultados = array();
			$sql = "SELECT paquetes.id_paquete, titulo, subtitulo, descripcion, ubicacion, categoria, clase, disponibilidad, vigencia, precio, recomendado, imagenp, status FROM paquetes LEFT JOIN paquetes_categorias ON paquetes.id_paquete = paquetes_categorias.id_paquete WHERE id_categoria = ".$idCategoria." and status = 1 ORDER BY paquetes.id_paquete DESC LIMIT 0, ".$limite." ;";
			$con = new conexion();
			$temporal = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($temporal)) {
				$paquete = new Paquete();
				$paquete -> llenarPaqueteConSusDatos($fila);
				$paquete -> listaImgPaquete();
				array_push($resultados, $paquete);
			}
			mysql_free_result($temporal);
			return $resultados;
		}

		function obtenerCategoriasDePaquete(){
			$sql = "SELECT id_categoria FROM paquetes_categorias WHERE id_paquete = ". $this -> idPaquete .";";
			$con = new conexion();
			$categorias = array();
			$resultados = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($resultados)) {
					$categoria = $fila["id_categoria"];
					array_push($categorias, $categoria);
			}
			mysql_free_result($resultados);
			return $categorias;
		}

		function asociaPaqueteACategoria($idCategoria){
			$sql = "INSERT INTO paquetes_categorias (`id_categoria`,`id_paquete`) VALUES('".$idCategoria."','".$this -> idPaquete."')";
			$con = new conexion();
			$con -> ejecutar_sentencia($sql);
		}

		function eliminarAsociacionesACategorias(){
			$sql = "DELETE FROM paquetes_categorias WHERE id_paquete = ".$this -> idPaquete;
			$con = new conexion();
			$con -> ejecutar_sentencia($sql);
		}

		function obtenerPaquete() {
			$sql = "SELECT * FROM paquetes WHERE id_paquete =".$this -> idPaquete.";";
			$con = new conexion();
			$resultados = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($resultados)) {
				$this -> llenarPaqueteConSusDatos($fila);
				$this -> listaImgPaquete();
			}
			mysql_free_result($resultados);
			return;
		}

		function recuperarPaquete() {
			$sql = "SELECT * FROM paquetes WHERE id_paquete =" . $this -> idPaquete . ";";
			$con = new conexion();
			$resultados = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($resultados)) {
				$this -> llenarPaqueteConSusDatos($fila);
				$this -> listaImgPaquete();
			}
			mysql_free_result($resultados);
			return ;
		}

		function listarPaquetes() {
			$resultados = array();
			$sql = "SELECT * FROM paquetes ORDER BY titulo ASC";
			$con = new conexion();
			$temporal = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($temporal)) {
				$paquete = new Paquete();
				$paquete -> llenarPaqueteConSusDatos($fila);
				$paquete -> listaImgPaquete();
				array_push($resultados, $paquete);
			}
			mysql_free_result($temporal);
			return $resultados;
		}

		function buscarPaquete($pedazo) {
			$resultados = array();
			$sql = "SELECT * FROM paquetes WHERE (titulo like '%" . $pedazo . "%') or (subtitulo like '%" . $pedazo . "%') or (precio like '%" . $pedazo . "%') group by titulo";
			$con = new conexion();
			$temporal = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($temporal)) {
				$registro = array();
				$registro["idpaquete"] = $fila["id_paquete"];
				$registro["titulo"] = $fila["titulo"];
				$registro["vigencia"] = $fila["vigencia"];
				$registro["precio"] = $fila["precio"];				
				$registro["status"] = $fila["status"];
				array_push($resultados, $registro);
			}
			echo json_encode($resultados);
		}

		function limitPaquete() {
			$resultados = array();
			$sql = "select * from paquetes";
			$con = new conexion();
			$temporal = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($temporal)) {
				$registro = array();
				$registro["idpaquete"] = $fila["id_paquete"];
				$registro["titulo"] = $fila["titulo"];
				$registro["vigencia"] = $fila["vigencia"];
				$registro["precio"] = $fila["precio"];
				$registro["status"] = $fila["status"];
				array_push($resultados, $registro);
			}
			echo json_encode($resultados);
		}

		//=============MAESTRO DETALLE DE LAS IMAGENES===============
		function listaImgPaquete() {
			$imgpaquetetemp = new ImgSecundariaPaquete(0, $this -> idPaquete, '', '');
			$this -> imgSecundarias = $imgpaquetetemp -> listarImgPaquete();
		}	/*function listaImgRevistaPanel($idrevista)
		 {
		 $imgrevistatemp= new imgrevista(0,$idrevista,'','','');
		 $this->imgrevista=$imgrevistatemp->listarImgRevista();
		 }*/
		
		//insertar_imagen($_REQUEST['titulo'],$_FILES['archivo']['name'],$_FILES['archivo']['tmp_name']);
		function insertarImgPaquete($rut, $temporal) {
			$imgpaquetetemp = new ImgSecundariaPaquete(0, $this -> idPaquete, $rut, $temporal);
			$imgpaquetetemp -> insertaImgPaquete();
		}	//$producto_temporal->modificar_imagen($_REQUEST['id_imagen'],$_REQUEST['titulo'],$_FILES['archivo']['name'],$_FILES['archivo']['tmp_name']);
		
		function modificarImgPaquete($id, $rut, $temporal) {
			$imgpaquetetemp = new ImgSecundariaPaquete($id, $this -> idPaquete, $rut, $temporal);
			$imgpaquetetemp -> modificaImgPaquete();
		}	
		function eliminarImgPaquete($id) {
			$imgpaquetetemp = new ImgSecundariaPaquete($id, $this -> idPaquete, '', '');
			$imgpaquetetemp -> eliminaImgPaquete();
		}	
		function obtenerImgPaquete($id) {
			$imgpaquetetemp = new ImgSecundariaPaquete(0, $id, '', '');
			$imgpaquetetemp -> obtenerImgPaquetefinal();
			return $imgpaquetetemp -> ruta;
		}

}
 ?>