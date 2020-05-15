<!DOCTYPE html>
<!--
Antes de mostar esta página se debió ejecutar lo siguiente 
1. crearDb.php
2. crearTabla.php
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Gestor de Archivos</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">
            <h2>Gestor de Archivos</h2>
            <?php
                $str_pagina = "<p>";
                if ($_FILES["arch"]["error"] > 0){
                    $str_pagina.="Error: " . $_FILES["arch"]["error"] . "<br>";
                }
                else  {
                    $str_pagina.= "Nombre: " . $_FILES["arch"] ["name"] . "<br>";
                    $str_pagina.= "Tipo: " . $_FILES["arch"]["type"] . "<br>";
                    $str_pagina.= "Tamaño: " . ($_FILES["arch"]["size"] / 1024) . " kB<br>";
                }
                
                if (!file_exists('subidos/')) 
                {
                    mkdir('subidos/',0777,true);
                }
                move_uploaded_file($_FILES["arch"]["tmp_name"],"subidos/".$_FILES["arch"]["name"]);
                $str_pagina.=  "<strong>Guardado en: " . "subidos/" . $_FILES["arch"]["name"]."</strong><br>";
                echo $str_pagina;

                crear_imagen();
                echo "<img src=subidos/imagen.png?".date("U").">";
                echo "</br>".date(DATE_RFC2822)."</br>";

                function  crear_imagen(){
                        $im = imagecreate(200, 200) or die("Error en la creacion de imagenes");
                        $color_fondo = imagecolorallocate($im, 255, 255, 0);   // amarillo

                        $rojo = imagecolorallocate($im, 255, 0, 0);                  // rojo
                        $azul = imagecolorallocate($im, 0, 0, 255);                 // azul
                        imagerectangle ($im,   5,  10, 195, 50, $rojo); //rectangulo (borde)
                        imagefilledrectangle ($im,   5,  100, 195, 140, $azul); //rectangulo (lleno)

                        imagepng($im,"subidos/imagen.png");
                        imagedestroy($im);
                }

            ?>
            <a href = "index.html"><button class="btn btn-primary" type ="button">Volver</button></a>
        </div>

    </body>
</html>