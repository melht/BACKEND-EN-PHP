<?php

$db_host = 'localhost';
$db_username = 'me';
$db_password = '12345';
$db_database = 'venta_autos';

$db = new mysqli($db_host, $db_username, $db_password, $db_database);
// Para que pueda aceptar letras de español
mysqli_query($db, "SET NAMES 'utf8'");

if($db->connect_errno > 0){
    die('No es posible conectarse a la base de datos ['.$db->connect_error.']');
}