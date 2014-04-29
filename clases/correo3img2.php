<?php
include_once('conexion.php');
require_once('archivo.php');
require_once('correo3.php');

class correo3img2 extends Archivo
	{
	var $idcorreo3img2;
	var $titulo;
	var $ruta;
	var $idcorreo3;
	var $directorio='/home1/locker07/public_html/clientes/patadeperro/panel/correos/correo3/correo2img/';
	
	function correo3img2 ($idcoimg3,$idc3,$rut,$tit,$temporal='')
	{
		$this->idcorreo3img2=$idcoimg3;
		$this->idcorreo3=$idc3;
		$this->ruta=$rut;
		$this->titulo=$tit;
		
		$this->ruta_final=$this->directorio.$rut;
		$this->ruta_temporal=$temporal;
	}
	
	
	
	function insertaCorreo3img2()
	{
		$sql="insert into correo3img2(idcorreo3,ruta,titulo) values (".$this->idcorreo3.",'".$this->ruta."','".$this->titulo."');";
		//echo $sql; 
		$con= new conexion();
		$con->ejecutar_sentencia($sql);
		
		$this->subir_archivo();	
	}
	
	
	function modificaCorreo3img2()
	{
		if ($this->ruta!='')
		{
			$titulo_temporal=$this->titulo;
			$ruta_temporal=$this->ruta;
			
			$this->recuperaCorreo3img2();
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

		$sql="update correo3img2 set idcorreo3=".$this->idcorreo3." ".$sql." ,titulo='".$this->titulo."' where idcorreo3img2=".$this->idcorreo3img2.";";
		//echo $sql;
		$con= new conexion();
		$con->ejecutar_sentencia($sql);
		$this->subir_archivo();
	}
	
	
	function eliminaCorreo3img2()
	{
		$this->recuperaCorreo3img2();
		$this->borrar_archivo();
		
		$sql="delete from correo3img2 where idcorreo3img2=".$this->idcorreo3img2.";";
		$con= new conexion();
		$con->ejecutar_sentencia($sql);
	}
	
	function obtenerCorreo3img2()
	{
		$sql="select idcorreo3img2,idcorreo3, ruta,titulo from correo3img2 where idcorreo3img2=".$this->idcorreo3img2;
		$con= new conexion();
		$resultados= $con->ejecutar_sentencia($sql);
		
		while ($fila=mysql_fetch_array($resultados))
		{
			$this->idcorreo3img2=$fila['idcorreo3img2'];
			$this->idcorreo3=$fila['idcorreo3'];
			$this->ruta=$fila['ruta'];
			$this->titulo=$fila['titulo'];
			$this->ruta_final=$this->directorio.$fila['ruta'];
		}
	}
	
	function obtenerCorreo3img2final()
	{
		$sql="select ruta from correo3img2 where idcorreo3=".$this->idcorreo3;
		$con= new conexion();
		$resultados= $con->ejecutar_sentencia($sql);
		while ($fila=mysql_fetch_array($resultados))
		{
			$this->ruta=$fila['ruta'];
			$this->ruta_final=$this->directorio.$fila['ruta'];
		}
	}
	
	function recuperaCorreo3img2()
	{
		$sql="select idcorreo3img2,idcorreo3, ruta,titulo from correo3img2 where idcorreo3img2=".$this->idcorreo3img2;
		$con= new conexion();
		$resultados= $con->ejecutar_sentencia($sql);
		
		while ($fila=mysql_fetch_array($resultados))
		{
			$this->idcorreo3img2=$fila['idcorreo3img2'];
			$this->idcorreo3=$fila['idcorreo3'];
			$this->ruta=$fila['ruta'];
			$this->titulo=$fila['titulo'];
			$this->ruta_final=$this->directorio.$fila['ruta'];
		}
	}
	
	function listarCorreo3img2()
	{
		$resultados=array();
		$sql="select idcorreo3img2, idcorreo3, ruta, titulo from correo3img2 where idcorreo3=".$this->idcorreo3.";";
		$con=new conexion();
		$temporal= $con->ejecutar_sentencia($sql);
		while ($fila=mysql_fetch_array($temporal))
		{
			$registro=array();
			$registro['idcorreo3img2']=$fila['idcorreo3img2'];
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