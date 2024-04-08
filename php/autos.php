<?php

include('conn.php');

// Verificar la accion
if(isset($_GET['accion'])){
    $accion = $_GET['accion'];

    // Leer los datos de la tabla autos
    if($accion == 'leer'){
        $sql = 'SELECT * FROM autos where 1';
        $result = $db->query($sql);

        if($result->num_rows > 0){
            $autos = array();
            while($fila = $result->fetch_assoc()){
                $autos[] = $fila;
            }
            $response["status"] = "Ok";
            $response["mensaje"] = $autos;
        } else{
            $response["status"] = "Error";
            $response["mensaje"] = "No hay autos registrados";
        }
        echo json_encode($response);
    }

    // Insertar un nuevo auto
    if($accion == 'insertar'){
        // Verificar si se proporcionan los datos requeridos
        if(isset($_POST['marca']) && isset($_POST['modelo']) && isset($_POST['año']) && isset($_POST['no_serie']) && isset($_POST['dueño_id'])){
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $año = $_POST['año'];
            $no_serie = $_POST['no_serie'];
            $dueño_id = $_POST['dueño_id'];

            // Insertar el auto en la base de datos
            $sql = "INSERT INTO autos (marca, modelo, año, no_serie, dueño_id) VALUES ('$marca', '$modelo', '$año', '$no_serie', '$dueño_id')";
            if($db->query($sql) === TRUE){
                $response["status"] = "Ok";
                $response["mensaje"] = "Auto insertado correctamente";
            } else{
                $response["status"] = "Error";
                $response["mensaje"] = "Error al insertar el auto: " . $db->error;
            }
        } else{
            $response["status"] = "Error";
            $response["mensaje"] = "Faltan datos requeridos para insertar un nuevo auto";
        }
        echo json_encode($response);
    }

    // Actualizar un auto existente
    if($accion == 'actualizar'){
        // Verificar si se proporcionan los datos requeridos
        if(isset($_POST['id']) && isset($_POST['marca']) && isset($_POST['modelo']) && isset($_POST['año']) && isset($_POST['no_serie']) && isset($_POST['dueño_id'])){
            $id = $_POST['id'];
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $año = $_POST['año'];
            $no_serie = $_POST['no_serie'];
            $dueño_id = $_POST['dueño_id'];

            // Actualizar el auto en la base de datos
            $sql = "UPDATE autos SET marca='$marca', modelo='$modelo', año='$año', no_serie='$no_serie', dueño_id='$dueño_id' WHERE id='$id'";
            if($db->query($sql) === TRUE){
                $response["status"] = "Ok";
                $response["mensaje"] = "Auto actualizado correctamente";
            } else{
                $response["status"] = "Error";
                $response["mensaje"] = "Error al actualizar el auto: " . $db->error;
            }
        } else{
            $response["status"] = "Error";
            $response["mensaje"] = "Faltan datos requeridos para actualizar un auto existente";
        }
        echo json_encode($response);
    }

    // Eliminar un auto existente
    if($accion == 'eliminar'){
        // Verificar si se proporciona el ID del auto a eliminar
        if(isset($_GET['id'])){
            $id = $_GET['id'];

            // Eliminar el auto de la base de datos
            $sql = "DELETE FROM autos WHERE id='$id'";
            if($db->query($sql) === TRUE){
                $response["status"] = "Ok";
                $response["mensaje"] = "Auto eliminado correctamente";
            } else{
                $response["status"] = "Error";
                $response["mensaje"] = "Error al eliminar el auto: " . $db->error;
            }
        } else{
            $response["status"] = "Error";
            $response["mensaje"] = "Se debe especificar el ID del auto a eliminar";
        }
        echo json_encode($response);
    }

} else {
    $response["status"] = "Error";
    $response["mensaje"] = "No se especificó ninguna acción";
    echo json_encode($response);
}
?>
