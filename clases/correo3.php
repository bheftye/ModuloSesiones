<?php
include_once('conexion.php');
require_once('archivo.php');
include_once('correo3img.php');
include_once('correo3img2.php');

class correo3 extends Archivo
{
	var $idcorreo3;
	var $ruta;
	var $titulo;
	var $link;
	var $subtitulo;
	var $desc1;
	var $correo1img;
	var $correo2img;
	var $directorio='/home1/locker07/public_html/clientes/patadeperro/panel/correos/correo3/';
	var $paquetesAsociados;
	
	function correo3 ($idc3= 0,$rut = '',$tit = '',$link ="",$subt = '',$desc1 = '', $temporal='', $paquetesAsociados = array())
	{
		$this -> idcorreo3 = $idc3;
		if ($rut != '') {
			$this -> ruta = $this -> obtenerExtensionArchivo($rut);
		} else {
			$this -> ruta = '';
		}
		$this -> titulo = $tit;
		$this -> link = $link;
		$this -> subtitulo = $subt;
		$this -> desc1 = $desc1;
		$this -> correo1img = array();
		$this -> correo2img = array();
		$this -> ruta_final = $this -> directorio.$this->ruta;
		$this -> ruta_temporal = $temporal;
		$this -> paquetesAsociados = $paquetesAsociados;
	}
	
	
	
	function insertaCorreo3()
	{
		$sql="insert into correo3 (ruta, titulo,link, subtitulo, desc1) values 
		('".$this -> ruta."',
		'".$this -> titulo."',
		'".$this -> link."',
		'".$this -> subtitulo."',
		'".$this -> desc1."'
		);"; 
		$con= new conexion();
		$this->idcorreo3=$con->ejecutar_sentencia($sql);
		$this -> insertarPaquetesAsociados();
		$this->subir_archivo();
	}
	
	
	function modificaCorreo3()
	{
		if ($this->ruta!='')
		{
			$titulo_temporal=$this->titulo;
			$ruta_temporal=$this->ruta;
			
			$this->recuperaCorreo3();
			$this->borrar_archivo();
			
			$this->titulo=$titulo_temporal;
			$this->ruta=$ruta_temporal;
			
			$this->ruta_final=$this->directorio.$ruta_temporal;
			$sql=' ruta=\''.$this->ruta.'\',';
		}
		else
		{
			$sql='';
		}
		
		// ruta='".$this->ruta."'
		$sql="update correo3 set 
		".$sql."
		titulo='".$this->titulo."', 
		link='".$this->link."', 
		subtitulo='".$this->subtitulo."', 
		desc1='".$this->desc1."'
		where idcorreo3=".$this->idcorreo3.";";
		$con= new conexion();
		
		$con->ejecutar_sentencia($sql);
		$this -> eliminarPaquetesAsociados();
		$this -> insertarPaquetesAsociados();
		$this->subir_archivo();
	}
	
	function eliminaCorreo3()
	{
		$this->obtenerCorreo3();
		$this->borrar_archivo();
		$this -> eliminarPaquetesAsociados();
		
		$sql="delete from correo3 where idcorreo3=".$this->idcorreo3.";";
		$con= new conexion();
		$con->ejecutar_sentencia($sql);
	}
	
	function obtenerCorreo3()
	{
		$sql="select * from correo3 where idcorreo3=".$this->idcorreo3.";";
		$con= new conexion();
		$resultados= $con->ejecutar_sentencia($sql);
		
		while ($fila=mysql_fetch_array($resultados))
		{
			$this->idcorreo3=$fila['idcorreo3'];
			$this->ruta=$fila['ruta'];
			$this->titulo=$fila['titulo'];
			$this->link = $fila["link"];
			$this->subtitulo=$fila['subtitulo'];
			$this->desc1=$fila['desc1'];
			$this->ruta_final=$this->directorio.$fila['ruta'];
			$this -> paquetesAsociados = $this -> obtenerPaquetesAsociados();
		}
	}
	
	function recuperaCorreo3()
	{
		$sql="select idcorreo3, ruta,titulo,link from correo3 where idcorreo3=".$this->idcorreo3.";";
		$con= new conexion();
		$resultados= $con->ejecutar_sentencia($sql);
		
		while ($fila=mysql_fetch_array($resultados))
		{
			$this->idcorreo3=$fila['idcorreo3'];
			$this->ruta=$fila['ruta'];
			$this->titulo=$fila['titulo'];
			$this->link = $fila["link"];
			//$this->urlvideo=$fila['urlvideo'];
			$this->ruta_final=$this->directorio.$fila['ruta'];
			$this -> paquetesAsociados = $this -> obtenerPaquetesAsociados();
		}
	}
	
	function listarCorreo3()
	{
		$resultados=array();
		$sql="select idcorreo3, ruta, titulo, subtitulo, desc1 from correo3";
		$con=new conexion();
		$temporal= $con->ejecutar_sentencia($sql);
		while ($fila=mysql_fetch_array($temporal))
		{
			$registro=array();
			$registro['idcorreo3']=$fila['idcorreo3'];
			$registro['ruta']=$fila['ruta'];
			$registro['titulo']=$fila['titulo'];
			$registro["link"] = $fila["link"];
			$registro['subtitulo']=$fila['subtitulo'];
			$registro['desc1']=$fila['desc1'];
			$correo3 = new correo3($fila['idcorreo3']);
			$registro["paquetes_asociados"] = $correo3 -> obtenerPaquetesAsociados();
			array_push($resultados, $registro);
		}
		mysql_free_result($temporal);
		return $resultados;
	}
	

	function insertarPaquetesAsociados(){
		foreach ($this -> paquetesAsociados as $idPaquete) {
			$sql="INSERT INTO correo3_paquetes (idcorreo3, id_paquete) values 
			('".$this -> idcorreo3."',
			'".$idPaquete."'
			);"; 
			$con= new conexion();
			$con->ejecutar_sentencia($sql);
		}
		return;
	}

	function eliminarPaquetesAsociados(){
		$sql="DELETE FROM correo3_paquetes WHERE idcorreo3 = ".$this -> idcorreo3.";"; 
		$con= new conexion();
		$con->ejecutar_sentencia($sql);
		return;
	}

	function obtenerPaquetesAsociados(){
		$paquetesAsociados=array();
		$sql="SELECT id_paquete from correo3_paquetes WHERE idcorreo3 = ".$this -> idcorreo3.";";
		$con=new conexion();
		$temporal= $con->ejecutar_sentencia($sql);
		while ($fila=mysql_fetch_array($temporal))
		{
			$idPaquete = $fila["id_paquete"];
			array_push($paquetesAsociados, $idPaquete);
		}
		mysql_free_result($temporal);
		return $paquetesAsociados;
	}

	//---------->COMIENZA MAESTRO DETALLE DE IMAGEN2<---------------
		
		function listarCorreo3img()
		{
			$imagencorreo1=new correo3img(0,$this->idcorreo3,'','','');
			$this->correo1img=$imagencorreo1->listarCorreo3img();
		}
	
		//insertar_imagen($_REQUEST['titulo'],$_FILES['archivo']['name'],$_FILES['archivo']['tmp_name']);	
		function insertarCorreo3img($tit,$rut,$temporal)
		{
			$imagencorreo1=new correo3img(0,$this->idcorreo3,$rut,$tit,$temporal);
			$imagencorreo1->insertaCorreo3img();
		}
		//$producto_temporal->modificar_imagen($_REQUEST['id_imagen'],$_REQUEST['titulo'],$_FILES['archivo']['name'],$_FILES['archivo']['tmp_name']);
		function modificarCorreo3img($id,$tit,$rut,$temporal)
		{
			$imagencorreo1=new correo3img($id,$this->idcorreo3,$rut,$tit,$temporal);
			$imagencorreo1->modificaCorreo3img();
		}
		
		function eliminarCorreo3img($id)
		{
			$imagencorreo1=new correo3img($id,$this->idcorreo3,'','','');
			$imagencorreo1->eliminaCorreo3img();
		}
		
		function obtenerCorreo3img($id)
		{
			$imagencorreo1=new correo3img($id,$this->idcorreo3,'','','');
			$imagencorreo1->obtenerCorreo3img();
			return $imagencorreo1;
		}
		
		//---------->COMIENZA MAESTRO DETALLE DE IMAGEN3<---------------
		
		function listarCorreo3img2()
		{
			$imagencorreo2=new correo3img2(0,$this->idcorreo3,'','','');
			$this->correo2img=$imagencorreo2->listarCorreo3img2();
		}
	
		//insertar_imagen($_REQUEST['titulo'],$_FILES['archivo']['name'],$_FILES['archivo']['tmp_name']);	
		function insertarCorreo3img2($tit,$rut,$temporal)
		{
			$imagencorreo2=new correo3img2(0,$this->idcorreo3,$rut,$tit,$temporal);
			$imagencorreo2->insertaCorreo3img2();
		}
		//$producto_temporal->modificar_imagen($_REQUEST['id_imagen'],$_REQUEST['titulo'],$_FILES['archivo']['name'],$_FILES['archivo']['tmp_name']);
		function modificarCorreo3img2($id,$tit,$rut,$temporal)
		{
			$imagencorreo2=new correo3img2($id,$this->idcorreo3,$rut,$tit,$temporal);
			$imagencorreo2->modificaCorreo3img2();
		}
		
		function eliminarCorreo3img2($id)
		{
			$imagencorreo2=new correo3img2($id,$this->idcorreo3,'','','');
			$imagencorreo2->eliminaCorreo3img2();
		}
	
}
?>