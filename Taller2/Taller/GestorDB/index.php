<!--
Antes de mostar esta página se debió ejecutar lo siguiente 
1. crear_db.php
2. crear_tabla.php
-->
<?php
    session_start();
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
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Gestor Tabla Personas</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">
            <div class="container">
                <h2>Bienvenido al gestor de la tabla Personas </h2>
            </div>
            <div class="container">
                <a href="verPersonas.php"><button type="button" class="btn btn-primary">Visualizar Personas</button></a>
                <a href="crearPersona_F.php"><button type="button" class="btn btn-primary">Crear o Modificar Persona</button></a>
                <a href="eliminarPersona_F.php"><button type="button" class="btn btn-primary">Eliminar Persona</button></a>
                <a href="Taller2/Login_F.php"><button type="button" class="btn btn-primary">Taller 2</button></a>
                <a href="../index.html"><button type="button" class="btn btn-primary">Volver</button></a>
            </div>
        </div>

    </body>
</html>