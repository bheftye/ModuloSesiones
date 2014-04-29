<?php
include_once ('conexion.php');
require_once ('archivo.php');
	class Promocion extends archivo{
		var $idPromocion;
		var $titulo;
		var $imgPrincipal;
		var $directorio = '../promociones/principales/';
		var $status;
		
		function Promocion($idPromocion = 0, $titulo ="", $imgPrincipal = "", $status = 1){
			$this -> idPromocion = $idPromocion;
			$this -> titulo = $titulo;
			$this -> imgPrincipal = $imgPrincipal;
			$this -> status = $status;
		}

		function insertarPromocion() {
			$sql = "INSERT INTO promociones (titulo, imagenp, status) VALUES('".$this -> titulo."', '".$this -> imgPrincipal."', ".$this -> status.")";
			$con = new conexion();
			$this -> idPromocion = $con -> ejecutar_sentencia($sql);
			$this -> subir_archivo();
		}

		function modificarPromocion() {
			if ($this -> imgPrincipal != '') {
				$promocion = new Promocion($this -> idPromocion);
				$promocion -> obtenerPromocion();
				$promocion -> ruta_final = $promocion -> directorio. $promocion -> imgPrincipal;
				$promocion -> borrar_archivo();

				$this -> ruta_final = $this -> directorio . $this -> imgPrincipal;
				$sql = ' imagenp=\'' . $this -> imgPrincipal . '\',';
			} else {
				$sql = '';
			}
			
			$sql = "UPDATE `promociones` SET ".$sql." `titulo`='".$this -> titulo."'  WHERE id_promocion = ".$this -> idPromocion;
			$con = new conexion();
			$con -> ejecutar_sentencia($sql);
			$this -> subir_archivo();	
		}

		function eliminarPromocion() {
			$this -> recuperarPromocion();
			$this -> borrar_archivo();
			$sql = "DELETE FROM `promociones` WHERE id_promocion =" . $this -> idPromocion . ";";
			$con = new conexion();
			$con -> ejecutar_sentencia($sql);
		}

		function desactivaPromocion() {
			$con = new conexion();
			$sql = "UPDATE promociones SET status = 0 WHERE id_promocion =" . $this -> idPromocion;
			$con -> ejecutar_sentencia($sql);
		}

		function activaPromocion() {
			$con = new conexion();
			$sql = "UPDATE promociones SET status = 1 WHERE id_promocion =" . $this -> idPromocion;
			$con -> ejecutar_sentencia($sql);
		}

		function llenarPromocionConSusDatos($filaSQL){
			$this ->  idPromocion = $filaSQL["id_promocion"];
			$this ->  titulo = $filaSQL["titulo"];
			$this ->  imgPrincipal = $filaSQL['imagenp'];
			$this -> ruta_final = $this -> directorio . $filaSQL['imagenp'];
			$this -> status = $filaSQL["status"];
		}

		function listarPromocionesActivos() {
			$resultados = array();
			$sql = "SELECT * FROM promociones WHERE status = 1 ORDER BY titulo ASC";
			$con = new conexion();
			$temporal = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($temporal)) {
				$promocion = new Promocion();
				$promocion -> llenarPromocionConSusDatos($fila);
				array_push($resultados, $promocion);
			}
			mysql_free_result($temporal);
			return $resultados;
		}

		function listarPromocionesDesactivados() {
			$resultados = array();
			$sql = "SELECT * FROM promociones WHERE status = 0 ORDER BY titulo ASC";
			$con = new conexion();
			$temporal = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($temporal)) {
				$promocion = new Promocion();
				$promocion -> llenarPromocionConSusDatos($fila);
				array_push($resultados, $promocion);
			}
			mysql_free_result($temporal);
			return $resultados;
		}


		function obtenerPromocion() {
			$sql = "SELECT * FROM promociones WHERE id_promocion =".$this -> idPromocion.";";
			$con = new conexion();
			$resultados = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($resultados)) {
				$this -> llenarPromocionConSusDatos($fila);
			}
			mysql_free_result($resultados);
			return;
		}

		function recuperarPromocion() {
			$sql = "SELECT * FROM promociones WHERE id_promocion =" . $this -> idPromocion . ";";
			$con = new conexion();
			$resultados = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($resultados)) {
				$this -> llenarPromocionConSusDatos($fila);
			}
			mysql_free_result($resultados);
			return ;
		}

		function listarPromociones() {
			$resultados = array();
			$sql = "SELECT * FROM promociones ORDER BY titulo ASC";
			$con = new conexion();
			$temporal = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($temporal)) {
				$promocion = new Promocion();
				$promocion -> llenarPromocionConSusDatos($fila);
				array_push($resultados, $promocion);
			}
			mysql_free_result($temporal);
			return $resultados;
		}

		function buscarPromocion($pedazo) {
			$resultados = array();
			$sql = "SELECT * FROM promociones WHERE (titulo like '%" . $pedazo . "%') group by titulo";
			$con = new conexion();
			$temporal = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($temporal)) {
				$registro = array();
				$registro["idpromocion"] = $fila["id_promocion"];
				$registro["titulo"] = $fila["titulo"];
				$registro["status"] = $fila["status"];
				array_push($resultados, $registro);
			}
			echo json_encode($resultados);
		}

		function limitPromocion() {
			$resultados = array();
			$sql = "SELECT * FROM promociones";
			$con = new conexion();
			$temporal = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($temporal)) {
				$registro = array();
				$registro["idpromocion"] = $fila["id_promocion"];
				$registro["titulo"] = $fila["titulo"];
				$registro["status"] = $fila["status"];
				array_push($resultados, $registro);
			}
			echo json_encode($resultados);
		}
		
	}
	
?>