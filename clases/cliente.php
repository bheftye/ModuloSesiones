<?php
//Aqui inlcuyo a la clase conexion para poder trabajar con mysql
include_once('conexion.php');

//Aqui le asigno nombre a mi clase
class cliente
{
		

	//Aquí declaro mis variables para esta clase
	var $idusuariocliente;
	var $password;
	var $nombre;
	var $apellido;
	var $edad;
	var $email;
	var $estado;
	var $ciudad;
	var $comentario;
	var $ocupacion;
	var $curso;
	var $status;
	var $token;
	var $nomestado;
	
	/*Aquí creo a mi metodo contructor para la clase el cual debera llamarse igual que la clase dentro de este metodo declaro las variables que va a recibir, se pueden llamar igual que    las variables declaradas arriba o se le puede llamar diferente]*/	
	function cliente($idusuariocliente = 0, $pass = '', $nombre = '', $apellido = '', $edad = '', $correo = '',$estado = '', $ciudad = '', $comentario = '', $ocupacion = '', $curso = '', $status = 0)
	{
		//Aquí asigno los datos recibidos en el metodo constructor a su variable conrrespondiente
		$this->idusuariocliente=$idusuariocliente;
		$this->password=$pass;
		$this->nombre=$nombre;
		$this->apellido=$apellido;
		$this->edad = $edad;			
		$this->email=$correo;
		$this->estado=$estado;
		$this->ciudad=$ciudad;
		$this->comentario=$comentario;
		$this->ocupacion = $ocupacion;
		$this->curso = $curso;
		$this->status=$status;
	}
	
	//Este metodo es el encargado de agregar en la base de datos	
	function agregarCliente()
	{
		//Aqui instancio a la clase conexion
		$con= new conexion();
		//Aqui guardo en una variable la sentencia
		$sql="INSERT INTO cliente(password,nombre,apellido,edad,email,`estado`,`ciudad`,comentario,ocupacion,curso,status,token) 
		values 
		(MD5('".$this->password."'),
		'".htmlspecialchars($this -> nombre, ENT_QUOTES)."',
		'".htmlspecialchars($this -> apellido, ENT_QUOTES)."',
		'".htmlspecialchars($this -> edad, ENT_QUOTES)."',
		'".htmlspecialchars($this -> email, ENT_QUOTES)."',
		'".$this->estado."',
		'".$this->ciudad."',
		'".htmlspecialchars($this -> comentario, ENT_QUOTES)."',
		'".htmlspecialchars($this -> ocupacion, ENT_QUOTES)."',
		'".htmlspecialchars($this -> curso, ENT_QUOTES)."',
		0,
		MD5('".$this->email."'))";
		//echo $sql;
		//Aquí llamo al metodo ejecutar sentencia de la clase conxion la cual me pide un dato que es la consulta
		return $this->idusuariocliente=$con->ejecutar_sentencia($sql);
	}
	
	function modificarCliente()
	{
		$pedazo="";
		$pedazo2='';
		if($this->email != '')
			$pedazo2="email='".$this->email."',";
		if ($this->password!='')   
			$pedazo="password=MD5('".$this->password."'),";
		$con= new conexion();
		$sql="UPDATE cliente SET 
		".$pedazo." 
		".$pedazo2."
		nombre='".htmlspecialchars($this -> nombre, ENT_QUOTES)."', 
		apellido='".htmlspecialchars($this -> apellido, ENT_QUOTES)."',
		edad='".htmlspecialchars($this -> edad, ENT_QUOTES)."',
		`estado`='".$this->estado."', 
		`ciudad`='".$this->ciudad."',
		comentario='".htmlspecialchars($this -> comentario, ENT_QUOTES)."',
		ocupacion='".htmlspecialchars($this -> ocupacion, ENT_QUOTES)."',
		curso='".htmlspecialchars($this -> curso, ENT_QUOTES)."'
		WHERE idusuariocliente='".$this->idusuariocliente."';";
		//Aquí llamo al metodo ejecutar sentencia de la clase conxion la cual me pide un dato que es la consulta
		return $con->ejecutar_sentencia($sql);
	}
	
	function modficarClientePass()
	{
		$con = new conexion();
		$sql= "UPDATE cliente SET password=MD5('".$this->password."') WHERE idusuariocliente='".$this->idusuariocliente."';";
		$con->ejecutar_sentencia($sql);
	}
	
	function eliminarCliente()
	{
		$con= new conexion();
		$sql="DELETE FROM cliente WHERE idusuariocliente='".$this->idusuariocliente."';";
		return $con->ejecutar_sentencia($sql);
	}
	//Esta funcion es la que obtiene los datos que estan en la base de datos	
	function obtenerCliente()
	{
		//Aqui instancio a la clase conexion
		$con = new conexion();
		//Aqui esta la consulta que obtiene los datos de la base de datos
		$sql="SELECT * from usuariocliente WHERE idusuariocliente='".$this->idusuariocliente."';";
		//Aqui se guarda en la variable registro lo que nos va a arrojar el metodo ejecutar_sentencia de la clase conexion
		$registro=$con->ejecutar_sentencia($sql);
		/*Aqui con el metodo mysql_fetch_array el cual recupera una fila de resultados como un array asociativo, el cual por medio de un while asociamos los registros 
		de la fila con su variable correspondiente*/
		
		while($fila = mysql_fetch_array($registro))
		{
			$this->idusuariocliente=$fila['idusuariocliente'];
			$this->password=$fila['password'];
			$this->nombre=$fila['nombre'];
			$this->apellido=$fila['apellido'];
			$this->edad = $fila['edad'];							
			$this->email=$fila['email'];
			$this->estado=$fila['estado'];
			$this->ciudad=$fila['ciudad'];
			$this->comentario=$fila['comentario'];
			$this->ocupacion = $fila['ocupacion'];
			$this->curso = $fila['curso'];		
			$this->status=$fila['status'];
			$this->token=$fila['token'];
		}
		//liberará toda la memoria asociada con el identificador del resultado
		mysql_free_result($registro);
	}
	
	function obtenerClientemail()
	{
		//Aqui instancio a la clase conexion
		$con = new conexion();
		//Aqui esta la consulta que obtiene los datos de la base de datos
		$sql="SELECT idusuariocliente,password,nombre,apellido,email from usuariocliente WHERE idusuariocliente='".$this->idusuariocliente."';";
		//Aqui se guarda en la variable registro lo que nos va a arrojar el metodo ejecutar_sentencia de la clase conexion
		$registro=$con->ejecutar_sentencia($sql);
		/*Aqui con el metodo mysql_fetch_array el cual recupera una fila de resultados como un array asociativo, el cual por medio de un while asociamos los registros 
		de la fila con su variable correspondiente*/
		
		while($fila = mysql_fetch_array($registro))
		{
			$this->idusuariocliente=$fila['idusuariocliente'];
			$this->password=$fila['password'];
			$this->nombre=$fila['nombre'];
			$this->apellido=$fila['apellido'];				
			$this->email=$fila['email'];
		}
		//liberará toda la memoria asociada con el identificador del resultado
		mysql_free_result($registro);
	}
	
	function obtenerClienteToken()
	{
		$con = new conexion();
		$sql = "SELECT idusuariocliente FROM cliente WHERE token='".$this->token."'";
		$registro = $con -> ejecutar_sentencia($sql);
		while($fila = mysql_fetch_array($registro))
		{
			$this -> idusuariocliente = $fila['idusuariocliente'];
		}
		mysql_free_result($registro);
	}
	
	function obtenerMailCliente()
	{
		//Aqui instancio a la clase conexion
		$con = new conexion();
		//Aqui esta la consulta que obtiene los datos de la base de datos
		$sql="SELECT idusuariocliente,email from usuariocliente WHERE idusuariocliente='".$this->idusuariocliente."';";
		//Aqui se guarda en la variable registro lo que nos va a arrojar el metodo ejecutar_sentencia de la clase conexion
		$registro=$con->ejecutar_sentencia($sql);
		/*Aqui con el metodo mysql_fetch_array el cual recupera una fila de resultados como un array asociativo, el cual por medio de un while asociamos los registros 
		de la fila con su variable correspondiente*/
		
		while($fila = mysql_fetch_array($registro))
		{
			$this->idusuariocliente=$fila['idusuariocliente'];			
			$this->email=$fila['email'];
		}
		//liberará toda la memoria asociada con el identificador del resultado
		mysql_free_result($registro);
	}
	
	function VerficarDisponibilidadEmail($email)
	{
		$conexion=new conexion();
		$sql="SELECT email FROM cliente where email='".$email."'";
		$result=$conexion->ejecutar_sentencia($sql);
		$resultados=array();
		while ($row=mysql_fetch_array($result))
		{
			$registro=array();
			$registro['email']=$row['email'];
			array_push($resultados,$registro);
		}
		mysql_free_result($result);
		return $resultados;
	}
	
	function listaEstados()
	{
		$conexion= new conexion();
		$sql="select id, nombre from estados";
		$result=$conexion->ejecutar_sentencia($sql);
		$resultados=array();
		while ($row=mysql_fetch_array($result))
		{
			$registro=array();
			$registro['id']=$row['id'];
			$registro['nombre']=$row['nombre'];
			array_push($resultados,$registro);
		}
		mysql_free_result($result);
		return $resultados;
	}
	
	function ObtenerEstados($idestado)
	{
		$conexion= new conexion();
		$sql="select id, nombre from estados where id=".$idestado;
		$result=$conexion->ejecutar_sentencia($sql);
		while($fila = mysql_fetch_array($result))
		{
			$this->estado=$fila['nombre'];
		}
		//liberará toda la memoria asociada con el identificador del resultado
		mysql_free_result($result);
	}
	
	function listarestadosxcliente()
	{
		$conexion= new conexion();
		$sql="select idusuariocliente, estado, estados.nombre from usuariocliente, estados where cliente.estado = estados.id group by estado";
		$result=$conexion->ejecutar_sentencia($sql);
		$resultados=array();
		while ($row=mysql_fetch_array($result))
		{
			$registro=array();
			$registro['idusuariocliente']=$row['idusuariocliente'];
			$registro['estado']=$row['estado'];
			$registro['nombre']=$row['nombre'];
			array_push($resultados,$registro);
		}
		mysql_free_result($result);
		return $resultados;
	}

/*----------------------------------------------------------------------
		INICIA METODOS PARA EL PANEL FILTROS Y CAMBIOS DE ESTATUS
-----------------------------------------------------------------------*/
	
	function ActivarCliente()
	{
		$con= new conexion();
		$sql="update cliente set status=1 where idusuariocliente=".$this->idusuariocliente;
		return $con->ejecutar_sentencia($sql);
	}
	
	function ActivarClienteToken()
	{
		$con= new conexion();
		$sql="update cliente set status=1 where token='".$this->token."'";
		return $con->ejecutar_sentencia($sql);
	}
	
	function DesactivarCliente()
	{
		$con= new conexion();
		$sql="update cliente set status=0 where idusuariocliente=".$this->idusuariocliente;
		return $con->ejecutar_sentencia($sql);
	}
		
	function listaClientes()
	{
		$conexion=new conexion();
		$sql="SELECT * FROM cliente";
		$result=$conexion->ejecutar_sentencia($sql);
		$resultados=array();
		while ($row=mysql_fetch_array($result))
		{
			$registro=array();
			$registro['idusuariocliente']=$row['idusuariocliente'];			
			$registro['password']=$row['password'];
			$registro['nombre']=$row['nombre'];
			$registro['apellido']=$row['apellido'];
			$registro['edad']=$row['edad'];
			$registro['email']=$row['email'];
			$registro['estado']=$row['estado'];
			$registro['ciudad']=$row['ciudad'];			
			$registro['status']=$row['status'];
			array_push($resultados,$registro);
		}
		mysql_free_result($result);
		return $resultados;
	}
	
	function listaDatosUsuarioActivas()
	{
		$conexion=new conexion();
		$sql="SELECT * FROM cliente where status=1";
		$result=$conexion->ejecutar_sentencia($sql);
		$resultados=array();
		while ($row=mysql_fetch_array($result))
		{
			$registro=array();
			$registro['idusuariocliente']=$row['idusuariocliente'];			
			$registro['password']=$row['password'];
			$registro['nombre']=$row['nombre'];
			$registro['apellido']=$row['apellido'];
			$registro['edad']=$row['edad'];
			$registro['email']=$row['email'];
			$registro['estado']=$row['estado'];
			$registro['ciudad']=$row['ciudad'];				
			$registro['status']=$row['status'];
			array_push($resultados,$registro);
		}
		mysql_free_result($result);
		return $resultados;
	}
	
	function listaDatosUsuarioDesactivadas()
	{
		$conexion=new conexion();
		$sql="SELECT * FROM cliente where status=0";
		$result=$conexion->ejecutar_sentencia($sql);
		$resultados=array();
		while ($row=mysql_fetch_array($result))
		{
			$registro=array();
			$registro['idusuariocliente']=$row['idusuariocliente'];			
			$registro['password']=$row['password'];
			$registro['nombre']=$row['nombre'];
			$registro['apellido']=$row['apellido'];
			$registro['edad']=$row['edad'];
			$registro['email']=$row['email'];
			$registro['estado']=$row['estado'];
			$registro['ciudad']=$row['ciudad'];				
			$registro['status']=$row['status'];
			array_push($resultados,$registro);
		}
		mysql_free_result($result);
		return $resultados;
	}
	
	function listaClienteBusqueda($pedazo)
	{
		$conexion=new conexion();
		$sql="SELECT * FROM cliente where (nombre like '%".$pedazo."%') or (apellido like '%".$pedazo."%') or (email like '%".$pedazo."%')";
		$result=$conexion->ejecutar_sentencia($sql);
		$resultados=array();
		while ($row=mysql_fetch_array($result))
		{
			$registro=array();
			$registro['idusuariocliente']=$row['idusuariocliente'];			
			$registro['password']=$row['password'];
			$registro['nombre']=$row['nombre'];
			$registro['apellido']=$row['apellido'];
			$registro['edad']=$row['edad'];
			$registro['email']=$row['email'];
			$registro['estado']=$row['estado'];
			$registro['ciudad']=$row['ciudad'];				
			$registro['status']=$row['status'];
			array_push($resultados,$registro);
		}
		echo json_encode($resultados);
	}
	function listaClienteAjax()
	{
		$conexion=new conexion();
		$sql="SELECT * FROM cliente";
		$result=$conexion->ejecutar_sentencia($sql);
		$resultados=array();
		while ($row=mysql_fetch_array($result))
		{
			$registro=array();
			$registro['idusuariocliente']=$row['idusuariocliente'];			
			$registro['password']=$row['password'];
			$registro['nombre']=$row['nombre'];
			$registro['apellido']=$row['apellido'];
			$registro['edad']=$row['edad'];
			$registro['email']=$row['email'];
			$registro['estado']=$row['estado'];
			$registro['ciudad']=$row['ciudad'];			
			$registro['status']=$row['status'];
			array_push($resultados,$registro);
		}
		echo json_encode($resultados);
	}
	
	function listaDatosUsuarioLimitAjax($limit)
	{
		if ($limit!='')
		{
			$conexion=new conexion();
			$sql="SELECT * FROM usuariocliente limit ".$limit."";
			$result=$conexion->ejecutar_sentencia($sql);
			$resultados=array();
			while ($row=mysql_fetch_array($result))
			{
				$registro=array();
				$registro['idusuariocliente']=$row['idusuariocliente'];			
				$registro['password']=$row['password'];
				$registro['nombre']=$row['nombre'];
				$registro['apellido']=$row['apellido'];
				$registro['edad']=$row['edad'];
				$registro['email']=$row['email'];
				$registro['estado']=$row['estado'];
			$registro['ciudad']=$row['ciudad'];			
				$registro['status']=$row['status'];
				array_push($resultados,$registro);
			}
			echo json_encode($resultados);
		}
	}
	function login()
	{
		$conexion=new conexion();
		$sql="select idusuariocliente,nombre, apellido from usuariocliente where email='".$this->email."' and password=MD5('".$this->password."') and status=1";
		$resultado=$conexion->ejecutar_sentencia($sql);
		while($fila =mysql_fetch_array($resultado))
		{
			$this->idusuariocliente=$fila['idusuariocliente'];
			$this->nombre=$fila['nombre'];
			$this->apellido=$fila['apellido'];
		}
	}
		function buscaremail()
		{
			$conexion=new conexion();
			$sql="SELECT idusuariocliente FROM cliente where email='".$this->email."'";
			$result=$conexion->ejecutar_sentencia($sql);
			$resultados=array();
			while ($row=mysql_fetch_array($result))
			{
				$registro=array();
				$registro['idusuariocliente']=$row['idusuariocliente'];
				array_push($resultados,$registro);
			}
			mysql_free_result($result);
			return $resultados;
		}

		
	function obtenestadoxcliente($idestado)
	{
		$conexion=new conexion();
		$sql="SELECT idusuariocliente FROM cliente where estado=".$idestado." and status=1";
		$result=$conexion->ejecutar_sentencia($sql);
		$resultados=array();
		while ($row=mysql_fetch_array($result))
		{
			$registro=array();
			$registro['idusuariocliente']=$row['idusuariocliente'];
			array_push($resultados,$registro);
		}
		mysql_free_result($result);
		return $resultados;
	}
	
	function getEmail($email)
	{
		$conexion=new conexion();
		$sql="SELECT * FROM cliente where email='".$email."'";
		$result=$conexion->ejecutar_sentencia($sql);
		$resultado = mysql_numrows($result);
		if ($resultado > 0){
			return true;
		}
		else{
			return false;
		}

	}
}
?>