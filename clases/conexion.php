<?php
class conexion{
	var $host;	var $user;	var $password;	var $bd;	var $conexion;	
		
	function conexion()	
	{	
		$this->host='localhost';		
		$this->user='root';		
		$this->password='root';		
		/*$this->user='root';		
		$this->password='';*/		
		$this->bd='brent_patadeperro';
	}	
		
	function conectar()	
	{	
	$this->conexion=mysql_connect($this->host, $this->user, $this->password);	
	mysql_select_db($this->bd, $this->conexion);	
	}	
		
	function desconectar()	
	{	
	mysql_close($this->conexion);	
	}	
		
	function ejecutar_sentencia($consulta)	
	{	
	$this->conectar();	
	$resultados=mysql_query($consulta, $this->conexion);	
	if(preg_match('/insert/i',$consulta))	
	{	
	$resultados=mysql_insert_id($this->conexion);	
	}	
	$this->desconectar();	
	return $resultados;	
	}
}
?>