<?php

include('conn.php');

// Verificar la accion 
if(isset($_GET['accion'])){

    $accion = $_GET['accion'];

    // Leer los datos de la tabla clientes
    if($accion == 'leer'){

        $sql = 'SELECT * FROM clientes where 1';
        $result = $db->query($sql);

        if($result->num_rows > 0){
            while($fila = $result->fetch_assoc()){
                $items['id'] = $fila['id'];
                $items['nombre'] = $fila['nombre'];
                $items['email'] = $fila['email'];
                $arrClientes[] = $items;
            }
            $response["status"] = "Ok";
            $response["mensaje"] = $arrClientes;

        } else{
            $response["status"] = "Error";
            $response["mensaje"] = "No hay clientes registrados";
        }
        echo json_encode($response);
    }

    // Insertar un nuevo cliente
    if($accion == 'insertar'){

        // Verificar si se proporcionan los datos requeridos
        if(isset($_POST['nombre']) && isset($_POST['email'])){
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];

            // Insertar el cliente en la base de datos
            $sql = "INSERT INTO clientes (nombre, email) VALUES ('$nombre', '$email')";
            if($db->query($sql) === TRUE){
                $response["status"] = "Ok";
                $response["mensaje"] = "Cliente insertado correctamente";
            } else{
                $response["status"] = "Error";
                $response["mensaje"] = "Error al insertar el cliente: " . $db->error;
            }
        } else{
            $response["status"] = "Error";
            $response["mensaje"] = "Faltan datos requeridos para insertar un nuevo cliente";
        }
        echo json_encode($response);
    }

    // Actualizar un cliente existente
    if($accion == 'actualizar'){
        // Verificar si se proporcionan los datos requeridos
        if(isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['email'])){
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];

            // Actualizar el cliente en la base de datos
            $sql = "UPDATE clientes SET nombre='$nombre', email='$email' WHERE id='$id'";
            if($db->query($sql) === TRUE){
                $response["status"] = "Ok";
                $response["mensaje"] = "Cliente actualizado correctamente";
            } else{
                $response["status"] = "Error";
                $response["mensaje"] = "Error al actualizar el cliente: " . $db->error;
            }
        } else{
            $response["status"] = "Error";
            $response["mensaje"] = "Faltan datos requeridos para actualizar un cliente existente";
        }
        echo json_encode($response);
    }

    // Eliminar un cliente existente
    if($accion == 'eliminar'){
        // Verificar si se proporciona el ID del cliente a eliminar
        if(isset($_GET['id'])){
            $id = $_GET['id'];

            // Eliminar el cliente de la base de datos
            $sql = "DELETE FROM clientes WHERE id='$id'";
            if($db->query($sql) === TRUE){
                $response["status"] = "Ok";
                $response["mensaje"] = "Cliente eliminado correctamente";
            } else{
                $response["status"] = "Error";
                $response["mensaje"] = "Error al eliminar el cliente: " . $db->error;
            }
        } else{
            $response["status"] = "Error";
            $response["mensaje"] = "Se debe especificar el ID del cliente a eliminar";
        }
        echo json_encode($response);
    }

    // Leer los autos de un cliente usando JOIN
    if($accion == 'leer_autos_cliente'){
        // Verificar si se proporciona el ID del cliente
        if(isset($_GET['id'])){
            $id_cliente = $_GET['id'];

            // Realizar la consulta usando JOIN
            $sql = "SELECT autos.* FROM autos INNER JOIN clientes ON autos.dueño_id = clientes.id WHERE clientes.id = '$id_cliente'";
            $result = $db->query($sql);

            if($result->num_rows > 0){
                $autos = array();
                while($fila = $result->fetch_assoc()){
                    $autos[] = $fila;
                }
                $response["status"] = "Ok";
                $response["mensaje"] = $autos;
            } else {
                $response["status"] = "Error";
                $response["mensaje"] = "El cliente no tiene autos registrados";
            }
        } else{
            $response["status"] = "Error";
            $response["mensaje"] = "Se debe especificar el ID del cliente";
        }
        echo json_encode($response);
    }

} else {
    $response["status"] = "Error";
    $response["mensaje"] = "No se especificó ninguna acción";
    echo json_encode($response);
}
?>
