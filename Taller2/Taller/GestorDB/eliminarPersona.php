<!--
Antes de mostar esta página se debió ejecutar lo siguiente 
1. crear_db.php
2. crear_tabla.php
-->
<?php
    session_start();

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
        }

        if($error == true)
        {
            header("Location: eliminarPersona_F.php");
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
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Eliminar Persona</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">

            <div class="container">
                <h2>Eliminar Persona </h2>
            </div>
            <div class="container">
                <?php

                    if($error==false)
                    {   
                         //incluir archivo de configuración con usuario y contraseña
                        //dirname: misma carpeta donde estoy
                        include_once dirname(__FILE__) . '/config.php';

                        //crear Conexión
                        //Variables en archivo config
                        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

                        $cadena ="<p>";

                        $cedula = $_POST['Cedula'];

                        $sql = "SELECT * FROM Personas Where Cedula='$cedula'";
                        $resultado = mysqli_query($con, $sql);
                        $persona = mysqli_fetch_array($resultado);
                        if($persona != null)
                        {
                            $nombre = $persona['Nombre'];
                            $apellido = $persona['Apellido'];
                            $correo = $persona['Correo'];
                            $edad = $persona['Edad'];

                            $sql = "DELETE FROM Personas WHERE Cedula = '$cedula';";
                            if(mysqli_query($con, $sql))
                            {                            
                                $cadena .= "<strong>Persona con:</strong><br><br>Cedula: $cedula<br>Nombre: $nombre<br>Apellido: $apellido<br>
                                    Correo Electónico: $correo<br>Edad: $edad<br><br><strong>Eliminada correctamente</strong>";
                            }
                            else
                            {
                                $cadena .= "Error en la Eliminación de la persona con cedula $cedula " . mysqli_error($con);
                            }
                        }
                        else
                        {
                            $cadena .= "La persona con cedula $cedula no existe";
                        }
                        $cadena .= "</p>";
                        echo $cadena;
                        
                        mysqli_close($con);
                    }
                ?>
            </div>
            <div class="container">
                <a href = "eliminarPersona_F.php"><button class="btn btn-primary" type ="button">Volver</button></a>
            </div>
        </div>
    </body>
</html>