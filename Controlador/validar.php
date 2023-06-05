<?php
    @session_start();
    require_once("../Modelo/modelo.php");

    $cont = $_POST['Contraseña'];

    $pass = hash("sha512", $cont);



    $params = array (
        "user"=>$_POST['Usuario'],
        "pass"=>$pass,
    );

    //print_r ($params); die ();  

    //instacia y coneccion bd

    $db = Database::getInstance(); //bd
    $conn = $db->getConnection();   //bd
    $sesion = new Modelo($conn);

    //llamar a la funcion validaUsuario
    list ($valor, $error) = $sesion->validaUsuario( $params );
    if ( empty($valor)){
        echo "<script>alert('El usuario o la contraseña son incorrectos');
        window.location.href='../Vista/login.html';
        </script>";
    } 
    else{
        
        header("location:../Vista/pagina.html/pagina.php");
        
    }
?>