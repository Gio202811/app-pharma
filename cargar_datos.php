<?php
    require_once 'conexion.php';

    if (!isset($_POST['datos'])) {
        echo json_encode(["error" => "No se recibieron parámetros"]);
        exit;
    }

    $datos = $_POST['datos'];
    $res = [];

    switch($datos) {
        case 'categories':
        case 'categorias':
            $stmt = $conn->prepare('SELECT * FROM categorias');
            $stmt->execute();
            $result = $stmt->get_result();
            break;
        case 'medicamentos':
            if (isset($_POST['id_categoria'])) {
                $id_categoria = $_POST['id_categoria'];
                $stmt = $conn->prepare('SELECT * FROM medicamentos WHERE id_categoria = ?');
                $stmt->bind_param('i', $id_categoria);
            } else {
                $stmt = $conn->prepare('SELECT * FROM medicamentos WHERE 1 = 0');
            }
            $stmt->execute();
            $result = $stmt->get_result();
            break;
        case 'lotes':
            if (isset($_POST['id_medicamento'])) {
                $id_medicamento = $_POST['id_medicamento'];
                $stmt = $conn->prepare('SELECT * FROM lotes WHERE codigo_medicamento = ?');
                $stmt->bind_param('s', $id_medicamento);
            } else {
                $stmt = $conn->prepare('SELECT * FROM lotes WHERE 1 = 0');
            }
            $stmt->execute();
            $result = $stmt->get_result();
            break;
    }
    if (isset($result)) {
        foreach($result as $row) {
            $res[] = $row;
        }
    } 
    echo json_encode($res);
?>