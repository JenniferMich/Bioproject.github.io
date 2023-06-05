<?php
    require_once("C:/xampp/htdocs/appi4/Modelo/modelo.php");
	
	function instancia( ){
		$db=Database::getInstance();
		$conn = $db->getConnection();
		$MySQL = new Modelo($conn);
		return $MySQL;
	}

	function perfil($id){

		$MySQL = instancia();
		$query = $MySQL->datosPerfil($id);
		
		$nombre = $apellidos = $cargo = $correo = $usuario = $contraseña = null;

		foreach($query as $filas)  {
			$nombre = $filas['nombre'];
			$apellidos = $filas['apellidos'];
			$cargo = $filas['cargo'];
			$correo = $filas['correo'];
			$usuario = $filas['usuario'];
			$contraseña = $filas['contraseña'];

		}
		$result[] = $nombre;
		$result[] = $apellidos;
		$result[] = $cargo;
		$result[] = $correo;
		$result[] = $usuario;
		$result[] = $contraseña;

		return $result;
	}

?>