<?php
class Conexion
{
    // Atributos privados para almacenar los datos de conexión
    private $host;
    private $userName;
    private $password;
    private $db;
    private $conn;

    // Nombre del archivo de configuración
    private $configFile = "conf.json";
    
    // Constructor: llama a la función connect automáticamente al crear el objeto
    public function __construct()
    {
        $this->connect();
    }

    // Destructor: cierra la conexión automáticamente al destruir el objeto
    public function __destruct()
    {
        $this->conn = null;
    }

    // Método que realiza la conexión a la base de datos
    public function connect()
    {
        // Comprobamos que existe el archivo de configuración
        if (!file_exists($this->configFile)) {
            die("Unable to open file!");
        }

        // Leemos y decodificamos el contenido JSON
        $configData = file_get_contents($this->configFile);
        $config = json_decode($configData, true);

        // Guardamos los valores del archivo en las variables de clase
        $this->host = $config['host'];
        $this->userName = $config['userName'];
        $this->password = $config['password'];
        $this->db = $config['db'];

        // Creamos el DSN (Data Source Name) para PDO
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4";

        // Intentamos conectarnos con PDO
        try {
            $this->conn = new PDO($dsn, $this->userName, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Si falla, mostramos un mensaje de error
            die("Connection failed: " . $e->getMessage());
        }
    }

    // Getter para obtener el objeto PDO desde fuera de la clase
    public function getConn()
    {
        return $this->conn;
    }
}
