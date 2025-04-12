<?php
class Model extends Conexion
{
    // EJERCICIO 2

    /**
     * Importa los datos del archivo JSON 'tareas.json' y los inserta en la base de datos.
     * Convierte las fechas al formato 'Y-m-d' antes de insertarlas.
     */
    public function import(){
        // Consulta SQL con parámetros preparados para insertar tareas
        $query = 'INSERT INTO tareas (titulo, descripcion, fecha_creacion, fecha_vencimiento) VALUES (?, ?, ?, ?);';
        $stmt = $this->getConn()->prepare($query);

        // Lee el contenido del archivo JSON y lo decodifica como objeto PHP
        $json = file_get_contents('./tareas.json');
        $decode = json_decode($json);

        // Recorre cada elemento del JSON y lo inserta en la base de datos
        foreach ($decode as $row){
            // Convierte las fechas al formato adecuado para MySQL
            $fechaCreacion = date("Y-m-d", strtotime($row->fecha_creacion));
            $fechaVencimiento = date("Y-m-d", strtotime($row->fecha_vencimiento));

            // Ejecuta la consulta preparada con los datos de cada tarea
            $stmt->execute([
                $row->titulo,
                $row->descripcion,
                $fechaCreacion,
                $fechaVencimiento
            ]);
        }
    }

    /**
     * Elimina todas las filas de la tabla 'tareas'.
     * Se usa normalmente antes de volver a importar datos.
     */
    public function deleteList(){
        $query = 'DELETE FROM tareas';
        $this->getConn()->query($query);
    }

    /**
     * Inicializa el sistema de tareas:
     * Primero elimina todos los registros de tareas y luego importa nuevos datos del JSON.
     */
    public function init(){
        try {
            $this->deleteList(); // Borra las tareas existentes
        } catch(Exception $e) {
            // Si hay un error al borrar, se muestra el mensaje y se detiene la ejecución
            die("Error: " . $e->getMessage());
        }

        $this->import(); // Importa nuevas tareas
    }


    // EJERCICIO 3

    /**
     * Recupera todos los registros de la tabla 'tareas' y los devuelve en forma de array asociativo.
     * @return array
     */
    public function getAllProducts(){
        $query = 'SELECT * FROM tareas';
        $stmt = $this->getConn()->query($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Muestra una tabla HTML con los campos ID, título y vencimiento de cada tarea.
     * Usa los datos obtenidos de la función getAllProducts().
     */
    public function showAllProducts(){
        $result = $this->getAllProducts();

        echo '<table class="greenTable">';
        echo '<thead><tr><th>ID</th><th>Título</th><th>Vencimiento</th></tr></thead>';

        // Recorre cada fila del resultado y la muestra en la tabla HTML
        foreach ($result as $row){
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['titulo'] . '</td>';
            echo '<td>' . $row['fecha_vencimiento'] . '</td>';
            echo '</tr>';
        }

        echo '</table>';
    }
}
