<?php

    //incluir archivo de configuración con usuario y contraseña
    //dirname: misma carpeta donde estoy
    include_once dirname(__FILE__) . '/config.php';

    //crear Conexión
    //Variables en archivo config
    $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

    if(mysqli_connect_errno())
    {
        echo "Error en la conexión: ". mysqli_connect_error();
    }
    else
    {
        $sql = "CREATE TABLE Personas(
            PID INT NOT NULL AUTO_INCREMENT,
            PRIMARY KEY(PID),
            Cedula CHAR(30),
            Nombre CHAR(30), 
            Apellido CHAR(30),
            Correo CHAR(30),
            Edad INT)";
        /* $sql = "DROP TABLE PERSONAS"; */
        if(mysqli_query($con, $sql))
        {
            echo "Tabla Personas creada correctamente";
        }
        else
        {
            echo "Error en la creacion " . mysqli_error($con);
        }
    }
    mysqli_close($con);

?>