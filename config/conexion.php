<?php

class Conexion
{

    static function conectar()
    {
        $mysqli = new mysqli("localhost", "root", "", "controlhorario2");
        $mysqli->set_charset("utf8");

        if ($mysqli->connect_errno) {
            echo "Error al conectar";
        } else {
            return $mysqli;
        }
    }
}
