<?php
class Model extends Conexion
{

    // ===================== EJERCICIO 2 =====================

    // Función para importar tareas desde un archivo JSON a la base de datos.
    public function import() {
        // Consulta SQL para insertar una tarea en la tabla 'tareas'.
        $query = 'INSERT INTO tareas (titulo, descripcion, fecha_creacion, fecha_vencimiento) VALUES (?, ?, ?, ?);';
        $stmt = $this->getConn()->prepare($query);

        // Cargamos el contenido del archivo JSON.
        $json = file_get_contents('./tareas.json');

        // Decodificamos el JSON en un array de objetos PHP.
        $decode = json_decode($json);

        // Recorremos cada objeto (tarea) del JSON.
        foreach ($decode as $row) {
            // Formateamos las fechas a formato 'Y-m-d'.
            $fechaCreacion = date("Y-m-d", strtotime($row->fecha_creacion));
            $fechaVencimiento = date("Y-m-d", strtotime($row->fecha_vencimiento));

            // Ejecutamos la inserción en la base de datos.
            $stmt->execute([$row->titulo, $row->descripcion, $fechaCreacion, $fechaVencimiento]);
        }
    }

    // Función que elimina todas las tareas de la base de datos.
    public function deleteList() {
        $query = 'DELETE FROM tareas';
        $this->getConn()->query($query);
    }

    // Función para reiniciar la lista de tareas: borra y vuelve a importar.
    public function init() {
        try {
            // Eliminamos todas las tareas.
            $this->deleteList();
        } catch (Exception $e) {
            // Si ocurre un error, mostramos el mensaje y detenemos la ejecución.
            die("Error: " . $e->getMessage());
        }

        // Importamos las tareas desde el archivo JSON.
        $this->import();
    }

    // ===================== EJERCICIO 3 - PRODUCTOS =====================

    // Función que obtiene todos los productos de la base de datos.
    public function getAllProducts() {
        $query = 'SELECT * FROM PRODUCTO';
        $stmt = $this->getConn()->query($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Función que muestra todos los productos en una tabla HTML.
    public function showAllProducts() {
        $result = $this->getAllProducts();

        echo '<table class="table table-striped">';
        echo '<thead><tr><th>Número Producto</th><th>Descripción</th></tr></thead>';
        foreach ($result as $producto) {
            echo '<tr>';
            echo '<td>' . $producto['PROD_NUM'] . '</td>';
            echo '<td>' . $producto['DESCRIPCION'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }

    // ===================== EJERCICIO 3 - EMPLEADOS =====================

    // Función que obtiene información de empleados (número, apellidos, salario, etc.).
    public function getAllEmp() {
        $query = 'SELECT EMP_NO, APELLIDOS, DEPT_NO, SALARIO, FECHA_ALTA FROM EMP';
        $stmt = $this->getConn()->query($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Función que muestra la información de empleados con colores por departamento.
    public function showAllEmp() {
        $result = $this->getAllEmp();

        echo '<table class="table table-striped">';
        echo '<thead><tr><th>Número de Empleado</th><th>Apellido</th><th>Salario</th><th>Fecha de Alta</th><th>Departamento</th></tr></thead>';
        foreach ($result as $row) {
            // Definimos un color según el departamento.
            $id = $row['DEPT_NO'];
            $color = "";
            if ($id == 10) {
                $color = "blue";
            } elseif ($id == 20) {
                $color = "red";
            } elseif ($id == 30) {
                $color = "green";
            }

            // Formateamos el salario y la fecha.
            $salario = number_format($row['SALARIO'], 2, ',', '.') . " €";
            $fechaAlta = date("d/m/Y", strtotime($row['FECHA_ALTA']));

            // Mostramos los datos con el color correspondiente.
            echo '<tr>';
            echo '<td>' . $row['EMP_NO'] . '</td>';
            echo '<td>' . $row['APELLIDOS'] . '</td>';
            echo '<td>' . $salario . '</td>';
            echo '<td>' . $fechaAlta . '</td>';
            echo '<td style="background-color:' . $color . ';">' . $id . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }

    // ===================== EJERCICIO 4 - CLIENTES =====================

    // Función que obtiene todos los clientes, ordenados por nombre (asc o desc).
    public function getAllClients($order) {
        $query = 'SELECT * FROM CLIENTE ORDER BY NOMBRE ' . $order;
        $stmt = $this->getConn()->query($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Función que muestra todos los clientes en una tabla HTML.
    public function showAllClients($order) {
        $result = $this->getAllClients($order);

        echo '<table class="table table-striped">';
        echo '<thead><tr><th>Código Cliente</th><th>Nombre</th><th>Ciudad</th></tr></thead>';
        foreach ($result as $row) {
            echo '<tr>';
            echo '<td>' . $row['CLIENTE_COD'] . '</td>';
            echo '<td>' . $row['NOMBRE'] . '</td>';
            echo '<td>' . $row['CIUDAD'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
}
?>
