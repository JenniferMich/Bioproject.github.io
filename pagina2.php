<?php
require_once("C:/xampp/htdocs/appi4/Controlador/controlador.php");
  @session_start();

  //si existe la sesion y el usario es tipo 1 lo manda a la paguina de admin
  if(isset($_SESSION['usuario']) && $_SESSION['tipo']==1){
    header("Location:../admin.php");
  }

  // si solo existe la sesion entra a la paguina que es de usuario
  else if(isset($_SESSION['usuario']) && $_SESSION['tipo']==3){
    $nombreU=$_SESSION['usuario'];
    if((time() - $_SESSION['tiempo']) > 120 ){
      session_destroy();
      echo "<script>alert('Tu sesion expiro, inicia nuevamente');
      window.location.href='../login.html'; 
      </script>";
      
    }else{
        header("Location:../pagina.php");
    }
    
  } 
  else if(isset($_SESSION['usuario']) && $_SESSION['tipo']==2){
    $nombreU=$_SESSION['usuario'];
    if((time() - $_SESSION['tiempo']) > 120 ){
      session_destroy();
      echo "<script>alert('Tu sesion expiro, inicia nuevamente');
      window.location.href='../login.html'; 
      </script>";
      
    }else{
      echo "<script>alert('Bienvenido');
      </script>"; 
    }
    
  }  
    
  else{
    session_destroy();
    echo "<script>alert('no has iniciado sesión ');
    window.location.href='../login.html'; 
    </script>";
  }
 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>hola</h1>
</body>
</html>