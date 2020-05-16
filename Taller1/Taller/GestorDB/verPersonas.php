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
        <title>Vizualizar Personas</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <script>
            function cambiarOrdenC(orden)
            {
                if(orden == "C-Menor-Mayor")
                {
                    var mensaje = "C-Mayor-Menor";
                }
                else
                {
                    var mensaje = "C-Menor-Mayor";
                }
                window.location="verPersonas.php?m="+mensaje;
            }

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
                window.location="verPersonas.php?m="+mensaje;
            }
        </script>
    </head>
    <body>
        <?php
            //incluir archivo de configuración con usuario y contraseña
            //dirname: misma carpeta donde estoy
            include_once dirname(__FILE__) . '/config.php';

            //crear Conexión
            //Variables en archivo config
            $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

            //FUNCIONES PARA REALIZAR FILTRO
            /* function cambiarOrdenC($orden)
            {
                if($orden == "C-Menor-Mayor")
                {
                    $mensaje = "C-Mayor-Menor";
                }
                else
                {
                    $mensaje = "C-Menor-Mayor";
                }
                header("Location: verPersonas.php?m=$mensaje");
            }

            function cambiarOrdenN($orden)
            {
                if($orden == "N-Menor-Mayor")
                {
                    $mensaje = "N-Mayor-Menor";
                }
                else
                {
                    $mensaje = "N-Menor-Mayor";
                }
                header("Location: verPersonas.php?m=$mensaje");
            } */

            $mensaje = "";

            if(isset($_GET['m']))
            {
                $mensaje = $_GET["m"];
                if($mensaje == "C-Mayor-Menor")
                {
                    $sql = "SELECT * FROM Personas ORDER BY Cedula DESC";
                }
                elseif($mensaje == "C-Menor-Mayor")
                {
                    $sql = "SELECT * FROM Personas ORDER BY Cedula ASC";
                }
                elseif($mensaje == "N-Mayor-Menor")
                {
                    $sql = "SELECT * FROM Personas ORDER BY Nombre DESC";
                }
                elseif($mensaje == "N-Menor-Mayor")
                {
                    $sql = "SELECT * FROM Personas ORDER BY Nombre ASC";
                }
                else
                {
                    $sql = "SELECT * FROM Personas";
                }
            }
            else
            {
                $sql = "SELECT * FROM Personas";
            }
            $resultado = mysqli_query($con, $sql);
        ?>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">
            <div class="container">
                <h2>Vizualizar Personas</h2>
            </div>
            <div class="container">
                <p>Si desea cambiar el orden de mayor a menor o de menor a mayor por cédula o por nombre presione sobre la celda Cédula o Nombre</p>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">PID</th>
                            <th scope="col"><a onclick="cambiarOrdenC(<?php echo "'$mensaje'"; ?>)">Cédula</a></th>
                            <th scope="col"><a onclick="cambiarOrdenN(<?php echo "'$mensaje'"; ?>)">Nombre</a></th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Edad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $cadena = "";
                            while($fila = mysqli_fetch_array($resultado))
                            {
                                $cadena.="<tr>";
                                $cadena .= "<th>".$fila['PID']."</th><td>".$fila['Cedula']."</td><td>".$fila['Nombre']."</td><td>".$fila['Apellido']."</td><td>".$fila['Correo']."</td><td>".$fila['Edad']."</td>";
                                $cadena .= "</tr>";
                            }
                            echo $cadena;
                            mysqli_close($con);
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="container">
                <a href = "index.html"><button class="btn btn-primary" type ="button">Volver</button></a>
            </div>
        </div>
    </body>
</html>