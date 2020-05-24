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

    if(isset($_SESSION['User']))
    {
        if($_SESSION['User'] == "usuario")
        {
            $error = true;
            header("Location: perfil.php?id=".$_SESSION['UserID']);
        }
    }
    else
    {
        $error = true;
        header("Location: Login_F.php");
    }

    $resultado = null;
    if($error == false)
    {
        //incluir archivo de configuración con usuario y contraseña
        //dirname: misma carpeta donde estoy
        include_once '../config.php';

        //crear Conexión
        //Variables en archivo config
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

        $mensaje = "";

        if(isset($_GET['m']))
        {
            $mensaje = $_GET["m"];

            if($mensaje == "N-Mayor-Menor")
            {
                $sql = "SELECT * FROM Usuarios WHERE Rol = 'usuario' ORDER BY NombreUsuario DESC";
            }
            elseif($mensaje == "N-Menor-Mayor")
            {
                $sql = "SELECT * FROM Usuarios WHERE Rol = 'usuario' ORDER BY NombreUsuario ASC";
            }
            else
            {
                $sql = "SELECT * FROM Usuarios WHERE Rol = 'usuario'";
            }
        }
        else
        {
            $sql = "SELECT * FROM Usuarios WHERE Rol = 'usuario'";
        }
        $resultado = mysqli_query($con, $sql);
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Visualizar Usuarios</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <script>

            function cambiarOrdenN(orden)
            {
                if(orden == "N-Menor-Mayor")
                {
                    var mensaje = "N-Mayor-Menor";
                }
                else
                {
                    var mensaje = "N-Menor-Mayor";
                }
                window.location="verUsuarios.php?m="+mensaje;
            }
        </script>
    </head>
    <body>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">
            <div class="container">
                <h2>Visualizar Usuarios</h2>
            </div>
            <div class="container">
                <p>Si desea cambiar el orden de mayor a menor o de menor a mayor por nombre presione sobre la celda Nombre de Usuario</p>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"><a onclick="cambiarOrdenN(<?php echo "'$mensaje'"; ?>)">Nombre de Usuario</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $cadena = "";
                            while($fila = mysqli_fetch_array($resultado))
                            {
                                $cadena.="<tr>";
                                $cadena .= "<td><a href='perfil.php?id=".$fila['UserID']."'>".$fila['NombreUsuario']."</a></td>";
                                $cadena .= "</tr>";
                            }
                            echo $cadena;
                            mysqli_close($con);
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="container">
                <a href = "Login_F.php"><button class="btn btn-primary" type ="button">Salir</button></a>
            </div>
        </div>
    </body>
</html>