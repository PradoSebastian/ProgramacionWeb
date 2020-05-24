<!--
Antes de mostar esta página se debió ejecutar lo siguiente 
1. crearDb.php en la carpeta anterior
2. crearTabla.php en la carpeta anterior
-->

<?php
    session_start();

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

    function eliminarSessionV($s)
    {
        if(isset($_SESSION[$s]))
        {
            unset($_SESSION[$s]);
        } 
    }

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $error = false;

        if(empty($_POST['NombreUsuario']))
        {
            $_SESSION['errNombreUsuario']="El Nombre de Usuario es obligatorio";
            $error = true;
        }
        else
        {
            $nombreUsuario = limpiar_entrada($_POST['NombreUsuario']);
            $_SESSION['nombreUsuario'] = $nombreUsuario;
            /* if (!preg_match("/^[a-zA-Z0-9_-]*$/",$nombreUsuario))
            {
                $_SESSION['errNombreUsuario'] = "Solo letras, números, '-' o '_'!";
                $error = true;
            }
            else
            {
                
            } */
        }

        if(empty($_POST['Contraseña']))
        {
            $_SESSION['errContraseña']="La contraseña es obligatoria";
            $error = true;
        }
        else
        {
            $contraseña = limpiar_entrada($_POST['Contraseña']);
        }

        if($error == true)
        {
            header("Location: Login_F.php");
        }
        else
        {
            $sql = "SELECT * FROM Usuarios Where NombreUsuario='$nombreUsuario'";
            $resultado = mysqli_query($con, $sql);
            $usuario = mysqli_fetch_array($resultado);
            if($usuario != null)
            {
                if (hash_equals($usuario['Contraseña'], crypt($contraseña, $usuario['Contraseña'])))
                {
                    eliminarSessionV('nombreUsuario');
                    if($usuario['Rol'] == "usuario")
                    {
                        $_SESSION['User']='usuario';
                        header("Location: perfil.php?id=".$usuario['UserID']);
                    }
                    elseif($usuario['Rol'] == "admin")
                    {
                        $_SESSION['User']='admin';
                        header("Location: verUsuarios.php");
                    }
                    $_SESSION['UserID']=$usuario['UserID'];
                }
                else
                {
                    $_SESSION['errContraseña']="Contraseña incorrecta!";
                    header("Location: Login_F.php");
                }
                
            }
            else
            {
                $_SESSION['errNombreUsuario']="No se encontró un usuario con esta información!";
                header("Location: Login_F.php");
            }
        }
    }

?>