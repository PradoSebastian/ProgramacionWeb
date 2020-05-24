
<?php
    session_start();
?>

<!DOCTYPE html>
<!--
Antes de mostar esta página se debió ejecutar lo siguiente 
1. crearDb.php
2. crearTabla.php
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
                <p>Si desea modificar una persona, digite en el campo de cedula la cedula de la persona a modificar</p>
            </div>

            <div class="container">
                <p>Los campos con "*" son obligatorios</p>
            </div>

            <div class="container">
                <form action="crearPersona.php" method="POST">
                    <div class="form-group">
                        <label for="Cedula">Cédula *</label>
                        <input class="form-control" type="text" name="Cedula" id="Cedula"
                        
                            <?php
                                if(isset($_SESSION['cedula']))
                                {
                                    echo "value='{$_SESSION['cedula']}'";
                                }     
                            ?>

                        >
                        <?php
                            if(isset($_SESSION['errCedula']))
                            {
                                echo "<p style='color: red'>{$_SESSION['errCedula']}</p>"; 
                            }                        
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="Nombre">Nombre *</label>
                        <input class="form-control" type="text" name="Nombre" id="Nombre"
                        
                            <?php
                                if(isset($_SESSION['nombre']))
                                {
                                    echo "value='{$_SESSION['nombre']}'";
                                }     
                            ?>

                        >
                        <?php
                            if(isset($_SESSION['errNombre']))
                            {
                                echo "<p style='color: red'>{$_SESSION['errNombre']}</p>"; 
                            }                        
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="Apellido">Apellido *</label>
                        <input class="form-control" type="text" name="Apellido" id="Apellido"
                        
                            <?php
                                if(isset($_SESSION['apellido']))
                                {
                                    echo "value='{$_SESSION['apellido']}'";
                                }     
                            ?>
                        
                        >
                        <?php
                            if(isset($_SESSION['errApellido']))
                            {
                                echo "<p style='color: red'>{$_SESSION['errApellido']}</p>"; 
                            }                        
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="Correo">Correo Electrónico *</label>
                        <input class="form-control" type="text" name="Correo" id="Correo"
                        
                            <?php
                                if(isset($_SESSION['correo']))
                                {
                                    echo "value='{$_SESSION['correo']}'";
                                }     
                            ?>

                        >
                        <?php
                            if(isset($_SESSION['errCorreo']))
                            {
                                echo "<p style='color: red'>{$_SESSION['errCorreo']}</p>"; 
                            }                        
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="Edad">Edad *</label>
                        <input class="form-control" type="text" name="Edad" id="Edad"
                        
                            <?php
                                if(isset($_SESSION['edad']))
                                {
                                    echo "value='{$_SESSION['edad']}'";
                                }     
                            ?>
                        
                        >
                        <?php
                            if(isset($_SESSION['errEdad']))
                            {
                                echo "<p style='color: red'>{$_SESSION['errEdad']}</p>"; 
                            }                        
                        ?>
                    </div>
                    <?php
                        function eliminarSessionV($s)
                        {
                            if(isset($_SESSION[$s]))
                            {
                                unset($_SESSION[$s]);
                            } 
                        }

                        eliminarSessionV('errCedula');
                        eliminarSessionV('errNombre');
                        eliminarSessionV('errApellido');
                        eliminarSessionV('errCorreo');
                        eliminarSessionV('errEdad');
                    ?>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                    <a href = "index.php"><button class="btn btn-primary" type ="button">Volver</button></a>
                </form>
            </div>
        </div>
    </body>
</html>