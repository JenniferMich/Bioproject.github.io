<?php
	//require_once("../Controlador/conexion.php");
	require_once("C:/xampp/htdocs/appi4/Controlador/conexion.php");
	require_once("C:/xampp/htdocs/appi4/Controlador/controlador.php");
	
	
	class Modelo{
		
		private $conn;
		
		function __construct( $conexion ){
			$this->conn = $conexion;
		}

		function select( $consulta ){ 
		    $this->total_consultas++;
		    $resultado = mysqli_query($this->conn, $consulta);
		    if(!$resultado){ 
		    	$error = 'MySQL Error: ' . mysqli_connect_error();
		    	
		    }
		    return $resultado;
		}
		
		function mostrarTablas( ){
			$sqlTablas = "SELECT TABLE_NAME as 'tabla' FROM INFORMATION_SCHEMA.tables ";
			$sqlTablas .= "WHERE TABLE_SCHEMA='sistema_archivos'";
			//Se ejecuta la consulta
			$resTablas = mysqli_query($this->conn, $sqlTablas);
			if( !$resTablas ){ 
		    	$error = 'MySQL Error: ' . mysqli_connect_error();
		    	$alert = 'danger';
			}
			$resultado = array();
			while($row = mysqli_fetch_array($resTablas))
			{
				$resultado[] = $row['tabla'];
			}
			return $resultado;
		}
		//-----------------------------------------------
		function agregaUsuario( $params ){
			$error = "";
			$valor = "";
			$nombre = $params["nombre"];
			$apellidos = $params["apellidos"];
			$cargo = $params["cargo"];
			$correo = $params["correo"];
			$usuario = $params["usuario"];
			$tipo = $params["tipo"];
			//se recibe la contraseña encriptada
			$pass = $params["contra"];
			$valpass = $params["valc"];


			/*
			if donde se compara que las dos contraseñas que ingreso sean iguales si es asi entra y valida que no se repetido el correo 
			o el usuario y registra al usuario
			*/
			if($pass == $valpass){

				//para hacer una consulta o realizar una accion de sql se deve de crear una variable para guardar la consulta y otra variable para ejecutarla 
				/*se hace una consulta para ver que el correo que ingreso o el usuario ya existen esto porque no pueden existir usuarios o
				correos duplicados 
				*/
				$sqlValidar = "SELECT * FROM usuarios WHERE Correo = '".$correo."'  ";
				//linea para la ejecucion de la consulata
				$resultado = mysqli_query($this->conn, $sqlValidar);

				$sqlValidar2 = "SELECT * FROM usuarios WHERE Usuario = '".$usuario."' ";
				$resultado2 = mysqli_query($this->conn, $sqlValidar2);

				
				//este if evalua que el correo que se quiere registrar ya exista si es asi solo asigna d al error y no hace el registro
				//se cuentan los renglones y si es mayor a 0 es porque encontro un registro igual al usuario o correo
				if((mysqli_num_rows($resultado)!= 0) || (mysqli_num_rows($resultado2)!= 0)) {				
					$error="d";
				}else{
					
					$query = "INSERT INTO usuarios(Nombres, Apellidos, Cargo, Correo, Usuario, Pass, tipo)";
					$query .= " VALUES ('".$nombre."', '".$apellidos."', '".$cargo."', '".$correo."', '".$usuario."' , '".$pass."' , '".$tipo."');";

					if($this->conn->query($query)){
						$valor = $this->conn->affected_rows;		
					}else{
						$error = '[' . $this->conn->error . ']';
					}
										
				}
			
		}else{
			/*si no coinciden las contraseñas estra al else y asigna un no a error para mandarlos al controlador y mandar el mensaje 
			de que no coinciden las contraseñas*/
			$error = "n";
		}
			 
			$resul[] = $valor;
			$resul[] = $error;	
			return $resul;
		}


		function validaUsuario($params){
			$error = "";
			$valor = "";
			$user = $params["user"];//user
			$pass = $params["pass"];//pass

			//$pass = hash("sha256", $cont);
	
			//selec para ver que la contraseña y el usuario existan y coisidan
			$query = "SELECT * FROM usuarios WHERE Usuario = '".$user."' AND Contraseña = '".$pass."';";
	
			$resultado = mysqli_query($this->conn, $query);
			//si se cumple la sentencia de arriba el renglon sera y y eso quiere decir que si exixte el correo y la contraseña y estos coinciden
			if(mysqli_num_rows($resultado)!=0){
				$valor = "Ok";
				//si se cumple crea la variable de sesion 
				@session_start(); 
				$_SESSION["logueado"] = TRUE;

				//se crean las variables de sesion
				while($row = mysqli_fetch_array($resultado)){
					$_SESSION["Usuario"] = $row['Usuario'];
					$_SESSION["id"] = $row['id'];
					$_SESSION["tipo"] = $row['tipo'];
					//optenemos la hora donde se inicio la sesion para poder destruirla en un determinado tiempo
					$_SESSION["tiempo"] = time();
					
				}	
		
			}
			$resul[] = $valor;
			$resul[] = $error;
	
			return $resul;
		}


		function datosPerfil ($id){
			//se usa el id para traernos los datos del id que coincidan al del usuario que se logeo
			$query = "SELECT * FROM usuarios WHERE id = ".$id;
			$resultado = mysqli_query($this->conn, $query);
			if (!$resultado){
				$error = 'MySQL Error: ' . mysqli_connect_error ();
			}
			return $resultado;
		}


    }
    
?>