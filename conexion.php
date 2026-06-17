<?php
    $host = "localhost";
    $user = "root";
    $pass = "root";
    $db = "farmaceuticadb";

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) 
        die('conexión fallida: ' . $conn->connect_error);

?>