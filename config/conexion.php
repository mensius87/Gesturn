<?php
// Conexion.php

// Incluir el archivo con las variables de entorno
include('variables_entorno.php');

class Conexion
{
    static function conectar()
    {
        // Utilizar las variables de entorno para las credenciales
        $host = getenv("DB_HOST");
        $usuario = getenv("DB_USER");
        $contraseña = getenv("DB_PASSWORD");
        $base_datos = getenv("DB_NAME");

        $mysqli = new mysqli($host, $usuario, $contraseña, $base_datos);
        $mysqli->set_charset("utf8");

        if ($mysqli->connect_errno) {
            echo "Error al conectar";
        } else {
            return $mysqli;
        }
    }
}
?>
