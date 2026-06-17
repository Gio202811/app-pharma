<?php
require_once 'conexion.php';
$accion = $_POST['accion'] ?? '';
switch($accion){
    case 'agregar_categoria':
        $nombre = $_POST['nombre_categoria'];
        $stmt = $conn->prepare(
            "INSERT INTO categorias(nombre_categoria, items)
            VALUES(?, 0)"
        );
        $stmt->execute([$nombre]);
        echo "ok";
    break;
    case 'editar_categoria':
        $nombre = $_POST['nombre_categoria'];
        $id_categoria = $_POST['id_categoria'];
        $stmt = $conn->prepare("
            UPDATE categorias 
            SET nombre_categoria = ? 
            WHERE id_categoria = ?
        ");
        $stmt->execute([$nombre, $id_categoria]);
        echo "ok";
    break;    
    case 'agregar_medicamento':
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre_comercial'];
        $forma = $_POST['forma'];
        $concentracion = $_POST['concentracion'];
        $receta = $_POST['receta'];
        $id_categoria = $_POST['id_categoria'];       
        $stmt = $conn->prepare("
            INSERT INTO medicamentos
            (codigo, nombre_comercial, forma, concentracion, receta, id_categoria)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$codigo, $nombre, $forma, $concentracion, $receta, $id_categoria]);        
        $stmt2 = $conn->prepare("
            UPDATE categorias
            SET items = items + 1
            WHERE id_categoria = ?
        ");
        $stmt2->execute([$id_categoria]);
        echo "ok";
    break;
    case 'editar_medicamento':
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre_comercial'];
        $forma = $_POST['forma'];
        $concentracion = $_POST['concentracion'];
        $receta = $_POST['receta'];
        $id_original = $_POST['id_original']; // Código anterior antes de editar por si cambió
        $stmt = $conn->prepare("
            UPDATE medicamentos 
            SET codigo = ?, nombre_comercial = ?, forma = ?, concentracion = ?, receta = ? 
            WHERE codigo = ?
        ");
        $stmt->execute([$codigo, $nombre, $forma, $concentracion, $receta, $id_original]);
        echo "ok";
    break;    
    case 'agregar_lote':
        $numero = $_POST['numero_lote'];
        $ingreso = $_POST['ingreso'];
        $caducidad = $_POST['caducidad'];
        $stock = $_POST['stock'];
        $ubicacion = $_POST['ubicacion'];
        $compra = $_POST['precio_compra'];
        $venta = $_POST['precio_venta'];
        $estado = $_POST['estado'];
        $codigo = $_POST['codigo_medicamento'];    
        $stmt = $conn->prepare("
            INSERT INTO lotes (numero_lote, ingreso, caducidad, stock, ubicacion, precio_compra, precio_venta, estado, codigo_medicamento)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$numero, $ingreso, $caducidad, $stock, $ubicacion, $compra, $venta, $estado, $codigo]);
        echo "ok";
    break;
    case 'editar_lote':
        $id_lote = $_POST['id_lote'];
        $numero = $_POST['numero_lote'];
        $ingreso = $_POST['ingreso'];
        $caducidad = $_POST['caducidad'];
        $stock = $_POST['stock'];
        $ubicacion = $_POST['ubicacion'];
        $compra = $_POST['precio_compra'];
        $venta = $_POST['precio_venta'];
        $estado = $_POST['estado'];
        $stmt = $conn->prepare("
            UPDATE lotes 
            SET numero_lote = ?, ingreso = ?, caducidad = ?, stock = ?, ubicacion = ?, precio_compra = ?, precio_venta = ?, estado = ? 
            WHERE id_lote = ?
        ");
        $stmt->execute([$numero, $ingreso, $caducidad, $stock, $ubicacion, $compra, $venta, $estado, $id_lote]);
        echo "ok";
    break;   
    case 'eliminar_categoria':
        $id = $_POST['id'];
        $stmt = $conn->prepare("
            DELETE FROM categorias
            WHERE id_categoria = ?
        ");
        $stmt->execute([$id]);
        echo "ok";
    break;
   case 'eliminar_medicamento':
        $codigo = $_POST['codigo'];
        $stmtBuscar = $conn->prepare("
            SELECT id_categoria
            FROM medicamentos
            WHERE codigo = ?
        ");
        $stmtBuscar->execute([$codigo]);
        $resultado = $stmtBuscar->get_result();
        if($fila = $resultado->fetch_assoc()){
            $idCategoria = $fila['id_categoria'];
            $stmtActualizar = $conn->prepare("
                UPDATE categorias
                SET items = items - 1
                WHERE id_categoria = ?
            ");
            $stmtActualizar->execute([$idCategoria]);
        }
        $stmt = $conn->prepare("
            DELETE FROM medicamentos
            WHERE codigo = ?
        ");
        $stmt->execute([$codigo]);
        echo "ok";
    break;
    case 'eliminar_lote':
        $id = $_POST['id'];
        $stmt = $conn->prepare("
            DELETE FROM lotes
            WHERE id_lote = ?
        ");
        $stmt->execute([$id]);
        echo "ok";
    break;
}
$conn->close();
?>