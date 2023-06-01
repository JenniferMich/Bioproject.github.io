<?php
    include_once 'database.php';

    session_start();

    if(isset($_GET['cerrar_sesion'])){
        session_unset();

        session_destroy();
    }

    if(isset ($_SESSION['Rol'])){
        switch($_SESSION['Rol']){
            case 1:
                header('location: admin.php');
            break;

            case 2:
                header('location: vendedor.php');
            break;

            case 3:
                header('location: tecnico.php');
            break;

            default:
        }
    } 

    if(isset($_POST['Username']) && isset($_POST['Password'])){

        $Username = $_POST['Username'];
        $Password = $_POST['Password'];

        $db = new Database();
        $query = $db->connect()->prepare('SELECT*FROM Usuarios WHERE Username = :Username AND Password = :Password');
        $query->execute(['Username' => $Username, 'Password' => $Password]);

        $row = $query->fetch(PDO::FETCH_NUM);
        if($row == true){
            //Validar el rol
            $Rol = $row[3];
            $_SESSION['Rol'] = $Rol;

            switch($_SESSION['Rol']){
                case 1:
                    header('location: admin.php');
                break;
    
                case 2:
                    header('location: tecnico.php');
                break;
    
                case 3:
                    header('location: vendedor.php');
                break;
    
                default:
            }
        }else{
            //no existe el usuario
            echo "El usuario o contraseña son incorrectos";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="#" method="POST">
       Username: <br/><input type="text" name="username"><br/>
       Password: <br/><input type="text" name="password"><br/>
       <input type="submit" value= "Iniciar sesión">
    </form>
</body>
</html>