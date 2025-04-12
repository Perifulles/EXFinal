<?php
// Función autoload que se ejecuta automáticamente cuando se usa una clase
function autocargador($clase) {
    // Incluye el archivo correspondiente a la clase desde la carpeta 'clases'
    require_once 'clases/' . $clase . '.php';
}

// Registramos nuestra función como autocargador de clases
spl_autoload_register('autocargador');


?>