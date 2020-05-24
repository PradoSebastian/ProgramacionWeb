
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

        if(empty($_POST['Nombre']))
        {
            $_SESSION['errNombre']="El Nombre es obligatorio";
            $error = true;
        }
        else
        {
            $nombre = limpiar_entrada($_POST['Nombre']);
            $_SESSION['nombre'] = $nombre;
            if (!preg_match("/^[a-zA-Z ]*$/",$nombre))
            {
                $_SESSION['errNombre'] = "Solo letras y espacios!";
                $error = true;
            }
        }

        if(empty($_POST['Apellido']))
        {
            $_SESSION['errApellido']="El Apellido es obligatorio";
            $error = true;
        }
        else
        {
            $apellido = limpiar_entrada($_POST['Apellido']);
            $_SESSION['apellido'] = $apellido;
            if (!preg_match("/^[a-zA-Z ]*$/",$apellido))
            {
                $_SESSION['errApellido'] = "Solo letras y espacios!";
                $error = true;
            }
        }
        
        if(empty($_POST['Correo']))
        {
            $_SESSION['errCorreo']="El Correo es obligatorio";
            $error = true;
        }
        else
        {
            $correo = limpiar_entrada($_POST['Correo']);
            $_SESSION['correo'] = $correo;
            if (!preg_match("/^[a-zA-Z]([a-zA-Z0-9-_]*[a-zA-Z0-9])?\@[a-zA-Z]([a-zA-Z-_]*[a-zA-Z])?(\.[a-zA-Z]+)+$/",$correo))
            {
                $_SESSION['errCorreo'] = "El usuario del correo solo puede contener letras, números o '_' o '-', no puede empezar con números ni '-' ni '_' y no puede terminar con '-' ni '_'.</p>
                                        <p style='color: red'>Seguido debe tener un '@'.</p><p style='color: red'>Seguido debe estar el nombre del servidor, el cual solo puede contener letras o '_' o '-', 
                                        no puede empezar ni terminar con '-' o '_'.</p><p style='color: red'>Seguido van los dominios, que empieza con un '.' 
                                        seguido de letras (pueden haber varios dominios)!";
                $error = true;
            }
        }
        
        if(empty($_POST['Edad']))
        {
            $_SESSION['errEdad']="La Edad es obligatoria";
            $error = true;
        }
        else
        {
            $edad = limpiar_entrada($_POST['Edad']);
            $_SESSION['edad'] = $edad;
            if (!preg_match("/^(([1-9][0-9]?)|(1[0-1][0-6]))$/",$edad))
            {
                $_SESSION['errEdad'] = "Su edad debe ser un número y debe ser mayor a 0 y menor a 116 años!";
                $error = true;
            }
        }

        if($error == true)
        {
            header("Location: crearPersona_F.php");
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
            eliminarSessionV('nombre');
            eliminarSessionV('apellido');
            eliminarSessionV('correo');
            eliminarSessionV('edad');
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Crear Persona</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">

            <div class="container">
                <h2>Crear o Modificar Persona </h2>
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

                        $sql = "SELECT Cedula FROM Personas Where Cedula='$cedula'";
                        $resultado = mysqli_query($con, $sql);
                        $persona = mysqli_fetch_array($resultado);
                        if($persona != null)
                        {
                            $sql = "UPDATE Personas SET Nombre = '$nombre', Apellido = '$apellido', Correo = '$correo', Edad = $edad WHERE Cedula = '$cedula';";
                            if(mysqli_query($con, $sql))
                            {
                                $cadena .= "<strong>Persona con:</strong><br><br>Cedula: $cedula<br>Nombre: $nombre<br>Apellido: $apellido<br>
                                    Correo Electónico: $correo<br>Edad: $edad<br><br><strong>Actualizada correctamente</strong>";
                            }
                            else
                            {
                                $cadena .= "Error en la Actualización de la persona con cedula $cedula " . mysqli_error($con);
                            }
                        }
                        else
                        {
                            $sql = "INSERT INTO Personas (Cedula,Nombre,Apellido,Correo,Edad) VALUES ('$cedula', '$nombre', '$apellido', '$correo', $edad);";
                            if(mysqli_query($con, $sql))
                            {
                                $cadena .= "<strong>Persona con:</strong><br><br>Cedula: $cedula<br>Nombre: $nombre<br>Apellido: $apellido<br>
                                    Correo Electónico: $correo<br>Edad: $edad<br><br><strong>Creada correctamente</strong>";
                            }
                            else
                            {
                                $cadena .= "Error en la creación de la persona con cedula $cedula " . mysqli_error($con);
                            }
                        }
                        $cadena .= "</p>";
                        echo $cadena;
                    
                        mysqli_close($con);
                    }
                ?>
            </div>
            <div class="container">
                <a href = "crearPersona_F.php"><button class="btn btn-primary" type ="button">Volver</button></a>
            </div>
        </div>
    </body>
</html>