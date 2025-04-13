<?php
class Model extends Conexion
{

    //EJ2
    public function import(){

        $query = 'insert into tareas 
        ( titulo, descripcion, fecha_creacion, fecha_vencimiento) values (?,?,?,?);';
        $stmt = $this->getConn()->prepare($query);


        $json = file_get_contents('./tareas.json');
        $decode = json_decode($json);
        foreach ($decode as $row){
            $fechaCreacion = date("Y-m-d", strtotime($row->fecha_creacion));
            $fechaVencimiento = date("Y-m-d", strtotime($row->fecha_vencimiento));
            $stmt->execute([$row->titulo,$row->descripcion,$fechaCreacion,$fechaVencimiento]);
  
        }
    }

    public function deleteList(){

        $query = 'Delete from tareas';
        $this->getConn()->query($query);
    }

    public function init(){
        try{ $this->deleteList();}
        catch(Exception $e){
            die("Error: " . $e->getMessage());
        }

        $this->import();
    }


    //EJ3
    public function getAllProducts(){

        $query = 'SELECT * FROM tareas';
        $stmt = $this->getConn()->query($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function showAllProducts(){
        $result = $this->getAllProducts();

        echo '<table class="greenTable">';
        echo '<thead><tr><th>ID</th><th>Título</th><th>Descripción</th><th>Fecha_Creación</th><th>Fecha_Vencimiento</th></tr></thead>';
        foreach ($result as $row){
            echo '<td>';
            echo $row['id'];
            echo '<td>';
            echo $row['titulo'];
            echo '<td>';
            echo $row['descripcion'];
            echo '<td>';
            echo $row['fecha_creacion'];
            echo '<td>';
            echo $row['fecha_vencimiento'];
            echo '<tr>';
        }
        echo '</table>';
    }





}