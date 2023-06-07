<?php
require_once("C:/wamp/www/appi4/Controlador/controlador.php");
  @session_start();

  //si existe la sesion y el usurio es tipo 2 entra 
  if(isset($_SESSION['usuario']) && $_SESSION['tipo']==1){
    echo "<script>alert('Hola Admin'); 
    </script>";
  //si solo existe la sesion lo redirige la paguina de usuarios 
  }
  else if(isset($_SESSION['usuario']) && $_SESSION['tipo']==2){
    echo "<script>alert('pagina solo para administradores');
    window.location.href='pagina.php'; 
    </script>";
  

    //si no destrulle la sesion
  }else if(isset($_SESSION['usuario']) && $_SESSION['tipo']==3){
    echo "<script>alert('pagina solo para administradores');
    window.location.href='pagina2.php'; 
    </script>";
  

    //si no destrulle la sesion
  }else{
    session_destroy();
    echo "<script>alert('no has iniciado sesión ');
    window.location.href='login.html'; 
    </script>";
  }
  //:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitio Admin</title>
</head>
<body>
    <h1>
        Hola admin 
        <?php
            echo $_SESSION['usuario'];
            echo $_SESSION['tiempo'];
            echo $_SESSION['cerrar'];
        ?>
    </h1>
    
</body>
</html>