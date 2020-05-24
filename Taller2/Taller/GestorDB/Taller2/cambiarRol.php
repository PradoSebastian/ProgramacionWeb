<!--
Antes de mostar esta página se debió ejecutar lo siguiente 
1. crearDb.php en la carpeta anterior
2. crearTabla.php en la carpeta anterior
-->

<?php

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

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cambiar Rol</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">

            <div class="container">
                <h2>Cambiar Rol o Eliminar </h2>
            </div>
            <div class="container">
                <?php

                    if(isset($_GET['e']))
                    {
                        if($_GET['e'] == "t" && isset($_GET['id']))
                        {
                            $cadena ="<p>";

                            $id = $_GET['id'];

                            $sql = "SELECT * FROM Usuarios Where UserID='$id'";
                            $resultado = mysqli_query($con, $sql);
                            $usuario = mysqli_fetch_array($resultado);
                            if($usuario != null)
                            {
                                $sql = "DELETE FROM Usuarios WHERE UserID = '$id';";
                                if(mysqli_query($con, $sql))
                                {                            
                                    $cadena .= "<strong>Usuario con:</strong><br><br>Id: $id<br><br><strong>Eliminado correctamente</strong>";
                                }
                                else
                                {
                                    $cadena .= "Error en la Eliminación del Usuario con id $id " . mysqli_error($con);
                                }
                            }
                            else
                            {
                                $cadena .= "El usuario con id $id no existe";
                            }
                            $cadena .= "</p>";
                            echo $cadena;
                            
                        }
                        else
                        {
                            header("Location: verUsuarios.php");
                        }
                    }
                    else
                    {
                        if($_SERVER["REQUEST_METHOD"] == "POST")
                        {
                            $cadena ="<p>";

                            $id = $_POST['id'];

                            $sql = "SELECT * FROM Usuarios Where UserID='$id'";
                            $resultado = mysqli_query($con, $sql);
                            $usuario = mysqli_fetch_array($resultado);
                            if($usuario != null)
                            {
                                $sql = "UPDATE Usuarios SET Rol ='{$_POST['Rol']}' WHERE UserID = '$id';";
                                if(mysqli_query($con, $sql))
                                {
                                    $cadena .= "<strong>El Rol del Usuario con:</strong><br><br>Id: $id<br><br><strong>Ha sido modificado correctamente</strong>";
                                }
                                else
                                {
                                    $cadena .= "Error en la Actualización del Usuario con id: $id " . mysqli_error($con);
                                }
                            }
                            else
                            {
                                $cadena .= "El usuario con id $id no existe";
                            }
                            $cadena .= "</p>";
                            echo $cadena;
                        }
                        else
                        {
                            header("Location: verUsuarios.php");
                        }
                    }
                    mysqli_close($con);
                ?>
            </div>
            <div class="container">
                <a href = "verUsuarios.php"><button class="btn btn-primary" type ="button">Volver</button></a>
            </div>
        </div>
    </body>
</html>