<?php
include_once('conexion.php');
require_once('archivo.php');
require_once('correo3.php');

class correo3img extends Archivo
	{
	var $idcorreoimg3;
	var $titulo;
	var $ruta;
	var $idcorreo3;
	var $directorio='../correos/correo3/correo1img/';
	
	function correo3img ($idcoimg3,$idc3,$rut,$tit,$temporal='')
	{
		$this->idcorreoimg3=$idcoimg3;
		$this->idcorreo3=$idc3;
		$this->ruta=$rut;
		$this->titulo=$tit;
		
		$this->ruta_final=$this->directorio.$rut;
		$this->ruta_temporal=$temporal;
	}
	
	
	
	function insertaCorreo3img()
	{
	$sql="insert into correo3img(idcorreo3,ruta,titulo) values (".$this->idcorreo3.",'".$this->ruta."','".$this->titulo."');"; 
	$con= new conexion();
	$con->ejecutar_sentencia($sql);
	$this->subir_archivo();
	
	}

	function modificaCorreo3img()
	{
		if ($this->ruta!='')
		{
			$titulo_temporal=$this->titulo;
			$ruta_temporal=$this->ruta;
			
			$this->recuperaCorreo3img();
			$this->borrar_archivo();
			
			$this->titulo=$titulo_temporal;
			$this->ruta=$ruta_temporal;
			
			$this->ruta_final=$this->directorio.$ruta_temporal;
			$sql=' ,ruta=\''.$this->ruta.'\'';
		}
		else
		{
			$sql='';
		}
		
		$sql="update correo3img set idcorreo3=".$this->idcorreo3." ".$sql." ,titulo='".$this->titulo."' where idcorreoimg3=".$this->idcorreoimg3.";";
		$con= new conexion();
		$con->ejecutar_sentencia($sql);
		$this->subir_archivo();
	}
	
	
	function eliminaCorreo3img()
	{
		$this->recuperaCorreo3img();
		$this->borrar_archivo();
		
		$sql="delete from correo3img where idcorreoimg3=".$this->idcorreoimg3.";";
		$con= new conexion();
		$con->ejecutar_sentencia($sql);
	}
	
	function obtenerCorreo3img()
	{
		$sql="select idcorreoimg3,idcorreo3, ruta,titulo from correo3img where idcorreoimg3=".$this->idcorreoimg3;
		$con= new conexion();
		$resultados= $con->ejecutar_sentencia($sql);
		
		while ($fila=mysql_fetch_array($resultados))
		{
			$this->idcorreoimg3=$fila['idcorreoimg3'];
			$this->idcorreo3=$fila['idcorreo3'];
			$this->ruta=$fila['ruta'];
			$this->titulo=$fila['titulo'];
			$this->ruta_final=$this->directorio.$fila['ruta'];
		}
	}
	
	function obtenerCorreo3imgfinal()
	{
		$sql="select ruta from correo3img where idcorreo3=".$this->idcorreo3;
		$con= new conexion();
		$resultados= $con->ejecutar_sentencia($sql);
		
		while ($fila=mysql_fetch_array($resultados))
		{
			$this->ruta=$fila['ruta'];
			$this->ruta_final=$this->directorio.$fila['ruta'];
		}
	}
	
	function recuperaCorreo3img()
	{
		$sql="select idcorreoimg3,idcorreo3, ruta,titulo from correo3img where idcorreoimg3=".$this->idcorreoimg3;
		$con= new conexion();
		$resultados= $con->ejecutar_sentencia($sql);
		
		while ($fila=mysql_fetch_array($resultados))
		{
			$this->idcorreoimg3=$fila['idcorreoimg3'];
			$this->idcorreo3=$fila['idcorreo3'];
			$this->ruta=$fila['ruta'];
			$this->titulo=$fila['titulo'];
			$this->ruta_final=$this->directorio.$fila['ruta'];
		}
	}
	
	function listarCorreo3img()
	{
		$resultados=array();
		$sql="select idcorreoimg3, idcorreo3, ruta, titulo from correo3img where idcorreo3=".$this->idcorreo3.";";
		$con=new conexion();
		$temporal= $con->ejecutar_sentencia($sql);
		while ($fila=mysql_fetch_array($temporal))
		{
			$registro=array();
			$registro['idcorreoimg3']=$fila['idcorreoimg3'];
			$registro['idcorreo3']=$fila['idcorreo3'];
			$registro['ruta']=$fila['ruta'];
			$registro['titulo']=$fila['titulo'];
			array_push($resultados, $registro);
		}
		mysql_free_result($temporal);
		return $resultados;
	}
}
?>