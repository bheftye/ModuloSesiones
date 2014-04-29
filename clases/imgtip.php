<?php
include_once('conexion.php');
require_once('archivo.php');
require_once('tip.php');

class ImgSecundariaTip extends Archivo
{
	var $idImgS;
	var $ruta;
	var $idTip;
	var $directorio = '../tips/secundarias/';
	
	function ImgSecundariaTip ($idImgS = 0, $idTip = 0, $rut = "", $temporal = '')
	{
		$this -> idImgS = $idImgS;
		$this -> idTip = $idTip;
		$this -> ruta = $rut;
		
		$this -> ruta_final = $this -> directorio.$rut;
		$this -> ruta_temporal = $temporal;
	}
	
	
	
	function insertaImgTip()
	{
		$sql="insert into tips_imagenes(id_tip, imagen) values (".$this -> idTip.", '".$this -> ruta."');";
		$con = new conexion();
		$con -> ejecutar_sentencia($sql);
		$this -> subir_archivo();
	}
	
	
	function modificaImgTip()
	{
	
		if ($this -> ruta != '')
		{
		
			$ruta_temporal = $this -> ruta;
			
			$this -> recuperaImgTip();
			$this -> borrar_archivo();
			
			$this -> ruta = $ruta_temporal;
			
			$this -> ruta_final = $this -> directorio.$ruta_temporal;
			$sql = ' ,imagen=\''.$this -> ruta.'\'';
		}
		else
		{
			$sql = '';
		}
			
		$sql = "update tips_imagenes set id_tip = ".$this -> idTip." ".$sql."  where id_img = ".$this -> idImgS.";";
		$con = new conexion();
		$con -> ejecutar_sentencia($sql);
		$this -> subir_archivo();
	}
	
	
	function eliminaImgTip()
	{
	
		$this -> recuperaImgTip();
		$this -> borrar_archivo();
		
		$sql = "delete from tips_imagenes where id_img =".$this -> idImgS.";";
		$con = new conexion();
		$con -> ejecutar_sentencia($sql);
	}
	
	function obtenerImgTip()
	{
		$sql = "select id_img, id_tip, imagen from tips_imagenes where id_img =".$this -> idImgS;
		$con = new conexion();
		$resultados = $con -> ejecutar_sentencia($sql);
		
		while ($fila = mysql_fetch_array($resultados))
		{
			$this -> idImgS = $fila['id_img'];
			$this -> idTip = $fila['id_tip'];
			$this -> ruta = $fila['imagen'];
			$this -> ruta_final = $this -> directorio.$fila['imagen'];
		}
	}
	
	function obtenerImgTipfinal()
	{
		$sql = "select imagen from tips_imagenes where id_tip =".$this -> idTip;
		$con = new conexion();
		$resultados = $con -> ejecutar_sentencia($sql);
		
		while ($fila = mysql_fetch_array($resultados))
		{
			$this -> ruta = $fila['imagen'];
			$this -> ruta_final = $this -> directorio.$fila['imagen'];
		}
	}
	
	function recuperaImgTip()
	{
		$sql = "select * from tips_imagenes where id_img=".$this->idImgS;
		$con = new conexion();
		$resultados = $con -> ejecutar_sentencia($sql);
		
		while ($fila = mysql_fetch_array($resultados))
		{
			$this -> idImgS = $fila['id_img'];
			$this -> idTip = $fila['id_tip'];
			$this -> ruta = $fila['imagen'];
			$this -> ruta_final = $this -> directorio.$fila['imagen'];
		
		}
	}
	
	function listarImgTip()
	{
		$resultados = array();
		$sql = "select * from tips_imagenes where id_tip =".$this -> idTip;
		$con = new conexion();
		$temporal = $con -> ejecutar_sentencia($sql);
		while ($fila = mysql_fetch_array($temporal))
		{
			$registro = new ImgSecundariaTip();
			$registro -> idImgS = $fila['id_img'];
			$registro -> idTip = $fila['id_tip'];
			$registro -> ruta = $fila['imagen'];
			array_push($resultados, $registro);
		}
		mysql_free_result($temporal);
		return $resultados;
	}
}
?>