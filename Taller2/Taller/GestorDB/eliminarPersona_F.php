
<!--
Antes de mostar esta página se debió ejecutar lo siguiente 
1. crear_db.php
2. crear_tabla.php
-->

<?php
    session_start();
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
                <p>Si desea eliminar una persona, digite en el campo de cedula la cedula de la persona a eliminar</p>
            </div>

            <div class="container">
                <form action="eliminarPersona.php" method="POST">
                    <div class="form-group">
                        <label for="Cedula">Cédula</label>
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
                    <?php
                        function eliminarSessionV($s)
                        {
                            if(isset($_SESSION[$s]))
                            {
                                unset($_SESSION[$s]);
                            } 
                        }

                        eliminarSessionV('errCedula');
                    ?>
                    <button type="submit" class="btn btn-primary">Eliminar</button>
                    <a href = "index.php"><button class="btn btn-primary" type ="button">Volver</button></a>
                </form>
            </div>
        </div>
    </body>
</html>