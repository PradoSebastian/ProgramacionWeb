<!DOCTYPE html>
<!--
Antes de mostar esta página se debió ejecutar lo siguiente 
1. crear_db.php
2. crear_tabla.php
3. insertar_personas.php 
-->
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

                    //incluir archivo de configuración con usuario y contraseña
                    //dirname: misma carpeta donde estoy
                    include_once dirname(__FILE__) . '/config.php';

                    //crear Conexión
                    //Variables en archivo config
                    $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

                    $cadena ="<p>";

                    $cedula = $_POST['Cedula'];
                    $nombre = $_POST['Nombre'];
                    $apellido = $_POST['Apellido'];
                    $correo = $_POST['Correo'];
                    $edad = $_POST['Edad'];

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
                ?>
            </div>
            <div class="container">
                <a href = "crearPersona.html"><button class="btn btn-primary" type ="button">Volver</button></a>
            </div>
        </div>
    </body>
</html>