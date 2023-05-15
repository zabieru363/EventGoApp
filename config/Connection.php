<?php
    require_once("DB.php");
    /**
     * Clase de acceso a datos.
     * @author Javier López
     * @version 1.0
     */
    class Connection
    {
        # Propiedades privadas de clase
        private static $instance;
        private $sgbd = SGBD;
        private $server = HOST;
        private $user = USER;
        private $password = DB_PASSWORD;
        protected $db_name;
        public $rows;  // Array de filas con el resultado de la consulta select
        private $connection;

        /**
         * Constructor que permite crear instancias de esta
         * clase para crear conexiones a una bd.
         * @param string $db_name El nombre de la base de datos.
         */
        private function __construct(string $db_name)
        {
            $this->db_name = $db_name;
        }

        /**
         * Método estático que obtiene la conexión de la base
         * de datos por medio de un singleton solo permite
         * crear una instancia del objeto.
         * @param string $db_name El nombre de la base de datos.
         */
        public static function getInstance()
        {
            if(self::$instance === null)
            {
                self::$instance = new Connection(DB_NAME);
            }

            return self::$instance;
        }

        /**
         * Método que abre la conexión a la base de datos utilizando PDO.
         */
        private function connect():void
        {
            try
            {
                $this->connection = new PDO("$this->sgbd:host=$this->server;dbname=$this->db_name",$this->user,$this->password); 
                $this->connection ->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
                $this->connection ->exec("set names utf8mb4");
            }
            catch(PDOException $e)
            {
                echo "Error al conectarse a la base de datos " . $e->getMessage();
            }
        }

        /**
         * Método para cerrar la conexión
         */
        private function close():void
        {
            $this->connection = NULL;
        }

        /**
         * Método para hacer consultas simples (INSERT INTO, UPDATE y DELETE)
         * @param string La consulta a la base de datos.
         * @param array El array de los parametros de la consulta
         * preparada sql.
         * @return bool True si la consulta tuvo exito, false si no es así.
         */
        public function execute_query(string $query, array $param):bool
        {
            $status = false;

            // Conectamos con la base de datos
            $this->connect();

            $statement = $this->connection->prepare($query);
            
            if(!$statement->execute($param))
            {
                echo "Error al ejecutar la consulta" . "<br>";
                echo $query;
                echo $this->connection->errorInfo();
                echo $this->connection->errorCode();
            }
            else
            {
                $status = true;
            }

            // Cerramos la conexión
            $this->close();

            return $status;
        }

        /**
         * Método para hacer consultas simples (INSERT INTO, UPDATE y DELETE).
         * Hace lo mismo que execute_query pero devuelve el último id insertado
         * @param string La consulta a la base de datos.
         * @param array El array de los parametros de la consulta
         * preparada sql.
         * @return mixed El último id insertado
         */
        public function execute_query_id(string $query, array $param)
        {
            // Conectamos con la base de datos
            $this->connect();

            $statement = $this->connection->prepare($query);
            
            if(!$statement->execute($param))
            {
                echo "Error al ejecutar la consulta" . "<br>";
                echo $query;
                echo $this->connection->errorInfo();
                echo $this->connection->errorCode();
            }
            else
            {
                $id = $this->connection->lastInsertId();
            }

            // Cerramos la conexión
            $this->close();

            return $id;
        }

        /**
         * Método para hacer consultas que devuelven datos (Consultas SELECT)
         * @param string La consulta a la base de datos.
         * @param array El array de los parametros de la consulta
         * preparada sql.
         */
        public function execute_select(string $query, array $param):void
        {
            $this->connect();

            /* Se vacia el array de las filas de
            consultas anteriores */
            $this->rows = [];

            $statement = $this->connection->prepare($query);

            if($statement->execute($param))
            {
                $this->rows = $statement->fetchAll(PDO::FETCH_ASSOC);
            }
            else
            {
                echo "Error al ejecutar la consulta" . "<br>";
            }

            $this->close();
        }
    }
?>