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
                echo "<br>Imagen Aleatoria:<br><img src=subidos/imagen.png?".date("U").">";
                date_default_timezone_set('America/Bogota');
                echo "<br><br>Fecha de hoy: ".date(DATE_RFC850)."<br>";

                function  crear_imagen()
                {    
                    $alto = rand(200,300);
                    $ancho = rand(200,300);
                    $im = imagecreate($ancho, $alto) or die("Error en la creacion de imagenes");
                    $color_fondo = imagecolorallocate($im, rand(0,255), rand(0,255), rand(0,255));

                    $color1 = imagecolorallocate($im, rand(0,255), rand(0,255), rand(0,255));                  
                    $color2 = imagecolorallocate($im, rand(0,255), rand(0,255), rand(0,255));

                    for ($i=0; $i < rand(1,5) ; $i++) 
                    { 
                        $color1 = imagecolorallocate($im, rand(0,255), rand(0,255), rand(0,255));                  
                        $color2 = imagecolorallocate($im, rand(0,255), rand(0,255), rand(0,255));

                        $x1 = rand(0, $ancho*0.7);
                        $y1 = rand(0, $alto*0.7);

                        $x2 = rand($x1, $ancho);
                        $y2 = rand($y1, $alto);

                        imagefilledrectangle ($im,   $x1,  $y1, $x2, $y2, $color2); //rectangulo (lleno)

                        $x1 = rand(0, $ancho*0.7);
                        $y1 = rand(0, $alto*0.7);

                        $x2 = rand($x1, $ancho);
                        $y2 = rand($y1, $alto);
                        
                        imagerectangle ($im,   $x1,  $y1, $x2, $y2, $color1); //rectangulo (borde)
                    }

                    imagepng($im,"subidos/imagen.png");
                    imagedestroy($im);
                }

            ?>
            <a href = "index.html"><button class="btn btn-primary" type ="button">Volver</button></a>
        </div>

    </body>
</html>