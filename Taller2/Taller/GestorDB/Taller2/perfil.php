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

    $error = false;
    $admin = false;

    if(isset($_SESSION['User']))
    {
        if($_SESSION['User'] == "admin")
        {
            $admin = true;
        }

        if(isset($_GET['id']))
        {
            if($_GET['id']==$_SESSION['UserID'] || $admin == true)
            {
                $userID = $_GET['id'];
            }
            else
            {
                $error = true;
                $cadena = "<p>No tienes permiso para acceder a la información de este Usuario</p>";
            }
        }
        else
        {
            $error = true;
            $cadena = "<p>Es necesario agregar un ID para identificar el perfil del usuario</p>";
        }
    }
    else
    {
        $error = true;
        header("Location: Login_F.php");
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Perfil</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">

            <div class="container">
                <h2>Perfil</h2>
            </div>
            <div class="container">
                <?php

                    if($error==false)
                    {
                        //incluir archivo de configuración con usuario y contraseña
                        //dirname: misma carpeta donde estoy
                        include_once '../config.php';

                        //crear Conexión
                        //Variables en archivo config
                        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

                        $cadena ="";

                        $sql = "SELECT Cedula FROM Usuarios Where UserID = '$userID'";
                        $resultado = mysqli_query($con, $sql);
                        $usuario = mysqli_fetch_array($resultado);
                        if($usuario != null)
                        {
                            $sql = "SELECT * FROM Personas Where Cedula = '{$usuario["Cedula"]}'";
                            $resultado = mysqli_query($con, $sql);
                            $persona = mysqli_fetch_array($resultado);
                            if($persona != null)
                            {
                                $cadena.="<p>El usuario con <strong>ID:</strong> $userID y <strong>Cedula:</strong> {$usuario['Cedula']} corresponde a la persona:</p>";
                                $cadena.="<p><strong>Nombre: </strong>{$persona['Nombre']}</p>";
                                $cadena.="<p><strong>Apellido: </strong>{$persona['Apellido']}</p>";
                                $cadena.="<p><strong>Correo Electrónico: </strong>{$persona['Correo']}</p>";
                                $cadena.="<p><strong>Edad: </strong>{$persona['Edad']}</p>";
                                if($admin == true)
                                {
                                    $cadena.="<form action='cambiarRol.php' method='POST'>
                                                <input type='hidden' name='id' id='id' value='$userID'>
                                                <div class='form-group'>
                                                    <label for='Rol'>Rol</label>
                                                    <select class='form-control' name='Rol' id='Rol'>
                                                        <option selected>usuario</option>
                                                        <option>admin</option>
                                                    </select>
                                                </div>                
                                                <button type='submit' class='btn btn-primary'>Guardar</button>
                                                <a href='cambiarRol.php?e=t&id=$userID'><button class='btn btn-primary' type='button'>Eliminar</button></a>
                                            </form>";
                                }
                            }
                            else
                            {
                                $cadena.="<p>No existe una persona con <strong>Cedula:</strong> {$usuario['Cedula']}</p>";
                            }
                        }
                        else
                        {
                            $cadena.="<p>No existe un Usuario con <strong>ID:</strong> $userID</p>";
                        }
                        $cadena .= "<br>";
                        echo $cadena;
                    
                        mysqli_close($con);
                    }
                    else
                    {
                        echo $cadena;
                    }
                ?>
                
            </div>
            <div class="container">
                <a href = "
                <?php
                    if($admin == true)
                    {
                        echo "verUsuarios.php";
                    }
                    else
                    {
                        echo "Login_F.php";
                    }
                ?>
                "><button class="btn btn-primary" type ="button">
                    <?php
                        if($admin == true)
                        {
                            echo "Volver";
                        }
                        else
                        {
                            echo "Salir";
                        }
                    ?>
                </button></a>
            </div>
        </div>
    </body>
</html>