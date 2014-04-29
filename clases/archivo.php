<?php

class Archivo
{
	var $ruta_temporal;
	var $ruta_final;
	
	function Archivo($ruta_temp,$ruta_fin)
	{
		$this->ruta_temporal=$ruta_temp;
		$this->ruta_final=$ruta_fin;
	}
	
	function subir_archivo()
	{
		move_uploaded_file($this->ruta_temporal,$this->ruta_final);
	}
	
	function borrar_archivo()
	{
		if (is_file($this->ruta_final))
		{
			unlink($this->ruta_final);
		}
	}
	
	function reemplaza_archivo()
	{
		$this->borrar_archivo();
		$this->subir->archivo();
	}
	
	function obtenerExtensionArchivo($str)
	{
		$longitud = 8; // Elegimos la longitud de la cadena
		// recortamos la cadena, conseguimos nueva pass
		$aleatorio = substr( md5(microtime()), 1, $longitud);
	 	$extension = explode(".", $str);
		$extensionFinal= end($extension);
		return $aleatorio.'.'.$extensionFinal;
	}

}
?>