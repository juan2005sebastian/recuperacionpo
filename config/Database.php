<?php
// Acá voy a definir la clase Database para manejar la conexión a la base de datos
class Database {
    // Acá defino las variables estáticas con los datos de la conexión
    private static $dbHost = "localhost"; 
    private static $dbName = "computronic"; 
    private static $dbUser = "root"; 
    private static $dbPass = "Juan"; 
    private static $connection = null; 

    // Acá creo un método estático para conectarme a la base de datos
    public static function connect() {
        // Primero verifico si la conexión ya está establecida
        if (self::$connection === null) {
            try {
                // Si no hay conexión, creo una nueva usando PDO
                self::$connection = new PDO(
                    "mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName . ";charset=utf8", 
                    self::$dbUser, // Usuario de la base de datos
                    self::$dbPass, // Contraseña de la base de datos
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //aca se activan los errores como excepciones para capturarlos mejor
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC 
                    ]
                );
            } catch (PDOException $e) {
                // Si hay un error en la conexión, muestro el mensaje y detengo el script
                die("Error en la conexión: " . $e->getMessage());
            }
        }
        // Retorno la conexión para que pueda ser usada en otros archivos
        return self::$connection;
    }
}
?>
