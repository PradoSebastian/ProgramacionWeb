<!--
Antes de mostar esta página se debió ejecutar lo siguiente 
1. crearDb.php en la carpeta anterior
2. crearTabla.php en la carpeta anterior
-->

<?php
    session_start();

    if(isset($_COOKIE['visitas']))
    {
        setcookie('visitas', $_COOKIE['visitas']+1, time()+3600);   
    }
    else
    {
        setcookie('visitas',1, time()+3600);
    }

    //incluir archivo de configuración con usuario y contraseña
    //dirname: misma carpeta donde estoy
    include_once '../config.php';

    //crear Conexión
    //Variables en archivo config
    $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

    function limpiar_entrada($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $error = false;
        if(empty($_POST['Cedula']))
        {
            $_SESSION['errCedula']="La cédula es obligatoria";
            $error = true;
        }
        else
        {
            $cedula = limpiar_entrada($_POST['Cedula']);
            $_SESSION['cedula'] = $cedula;
            if (!preg_match("/^[0-9]*$/",$cedula))
            {
                $_SESSION['errCedula'] = "Solo números!";
                $error = true;
            }
            else
            {
                $sql = "SELECT * FROM Personas Where Cedula='$cedula'";
                $resultado = mysqli_query($con, $sql);
                $persona = mysqli_fetch_array($resultado);
                if($persona == null)
                {
                    $_SESSION['errCedula'] = "No existe una persona con esa cedula!";
                    $error = true;
                }
            }
        }

        if(empty($_POST['NombreUsuario']))
        {
            $_SESSION['errNombreUsuario']="El Nombre de Usuario es obligatorio";
            $error = true;
        }
        else
        {
            $nombreUsuario = limpiar_entrada($_POST['NombreUsuario']);
            $_SESSION['nombreUsuario'] = $nombreUsuario;
            if (!preg_match("/^[a-zA-Z0-9_-]*$/",$nombreUsuario))
            {
                $_SESSION['errNombreUsuario'] = "Solo letras, números, '-' o '_'!";
                $error = true;
            }
            else
            {
                $sql = "SELECT * FROM Usuarios Where NombreUsuario='$nombreUsuario'";
                $resultado = mysqli_query($con, $sql);
                $aux = mysqli_fetch_array($resultado);
                if($aux != null)
                {
                    $_SESSION['errNombreUsuario'] = "Ya existe un Usuario con este nombre!";
                    $error = true;
                }
            }
        }

        if(empty($_POST['Contraseña']))
        {
            $_SESSION['errContraseña']="La contraseña es obligatoria";
            $error = true;
        }
        else
        {
            $contraseña = limpiar_entrada($_POST['Contraseña']);
            $_SESSION['contraseña'] = $contraseña;
        }

        if($error == true)
        {
            header("Location: Registro_F.php");
        }
        else
        {
            function eliminarSessionV($s)
            {
                if(isset($_SESSION[$s]))
                {
                    unset($_SESSION[$s]);
                } 
            }

            eliminarSessionV('cedula');
            eliminarSessionV('nombreUsuario');
            eliminarSessionV('contraseña');
        }
    }
    else
    {
        $error = true;
        header("Location: Registro_F.php");
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Registro</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">

            <div class="container">
                <h2>Registrarse </h2>
            </div>
            <div class="container">
                <?php

                    if($error==false)
                    {
                        $cadena ="<p>";

                        if (CRYPT_SHA512 == 1) 
                        {
                            $contraseña = crypt($contraseña, '$6$rounds=5000$usesomesillystringforsaltforexamplelapujamijo$');

                            $sql = "SELECT * FROM Usuarios";
                            $resultado = mysqli_query($con, $sql);
                            $user = mysqli_fetch_array($resultado);
                            if($user == null)
                            {
                                $rol = "admin";
                            }
                            else
                            {
                                $rol = "usuario";
                            }
                            
                            $sql = "INSERT INTO Usuarios (NombreUsuario,Rol,Contraseña,Cedula) VALUES ('$nombreUsuario', '$rol', '$contraseña', '$cedula');";
                            if(mysqli_query($con, $sql))
                            {
                                $cadena .= "<strong>Usuario con:</strong><br><br>Cedula: $cedula<br>Nombre de Usuario: $nombreUsuario<br>Rol: $rol<br>
                                    <br><strong>Creada correctamente</strong>";
                            }
                            else
                            {
                                $cadena .= "Error en la creación del Usuario con cedula $cedula y nombre de usuario $nombreUsuario " . mysqli_error($con);
                            }

                            $cadena .= "</p>";
                            echo $cadena;
                        }
                        else
                        {
                            $cadena.= "Error en la encriptación de la contraseña con CRYPT_SHA512</p>";
                            echo $cadena;
                        }
                    }
                    mysqli_close($con);
                ?>
            </div>
            <div class="container">
                <a href = "Registro_F.php"><button class="btn btn-primary" type ="button">Volver</button></a>
                <a href = "Login_F.php"><button class="btn btn-primary" type ="button">Iniciar Sesión</button></a>
            </div>
        </div>
    </body>
</html>