<?php

    @session_start();
    require_once("../Modelo/modelo.php");

    //se crea una variable que recibira la contraseña que se ingreso en el formulario con el metodo POST
    $contraseña = $_POST ['contraseña'];
    //se crea una nueva variable para encritar la contraseña que se guardo el la variable de arriba
    $contra = hash("sha512", $contraseña);

    /*se hace el mismo paso de arriba pero con la contraseña que puso el campo para validar para compararlas 
    y si coinciden hacer el insert a la BD
    */

    $valCon = $_POST['valcontraseña'];

    $valC = hash("sha512", $valCon);
    $tipo_usuario=$_POST ['cargo'];

    if($tipo_usuario==2){
        $nombre_cargo = "Vendedor";
    }elseif($tipo_usuario==3){
        $nombre_cargo = "Técnico";
    }

    $params = array (
        "nombre" => $_POST ['nombre'],
        "apellidos" => $_POST ['apellidos'],
        "cargo" => $nombre_cargo,
        "correo" => $_POST ['correo'],
        "usuario" => $_POST ['usuario'],
        //se guada la variable con la contraseña encritada en el arreglo para madarla al modelo 
        "contra" => $contra,
        "valc" => $valC,
        "tipo"=>$_POST ['cargo'],
           
    );
// print_r($params)


    	//instancia y conexion bd
        $db = Database::getInstance();
        $conn = $db->getConnection();
        $sesion = new Modelo($conn);
        
        //llamar a la funcion 'agregausuario'
        list ($valor, $error) = $sesion->agregaUsuario( $params );
        if ( empty( $valor ) ){
            
            if($error == "d"){
                echo "<script>alert('Usuario duplicado, vuelva a intentar');
                history.go(-1);
                </script>";
                 
            //history.go(-1); si te da un error te regresa al formulario para que se corriga pero los campos no se borran

           //si error el igual a no las contraseñas no coinciden y debe corregirlas e ingresarlas nuevamente para registrarse
            }else if($error == "n"){
                echo "<script>alert('Las contraseñas no coinciden, revisalas');
                history.go(-1);
                </script>";
            }
            else{
                echo "<script>alert('Ocurrió un error al hacer el registro');
                window.location.href='../Vista/registro.html';
                history.go(-1);
                </script>";   			
            }
                           
        } else {
            echo "<script>alert('Su usuario fue registrado exitosamente');
            window.location.href='../Vista/login.html';
            </script>";
        }
?>
