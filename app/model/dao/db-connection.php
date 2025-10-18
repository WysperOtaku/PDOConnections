<?php
    class Connection {
        private $pdo;

        public function __construct($dbname ,$username, $passwd) {
            try{
                $dsn = `mysql:host=localhost;dbname={$dbname};charset=utf8mb4`;
                $this->pdo = new PDO($dsn, $username, $passwd);

            } catch (Exception $e) {
                throw new PDOException("Conexion a la BBDD fallida");
            }
        }

        public function getConnection() : PDO {
            return $this->pdo;
        }

        public function close() : void {
            $this->pdo = null;
        }

        public function connect($dbname ,$username, $passwd) {
            try{
                $dsn = `mysql:host=localhost;dbname={$dbname};charset=utf8mb4`;
                $this->pdo = new PDO($dsn, $username, $passwd);

            } catch (Exception $e) {
                throw new PDOException("Conexion a la BBDD fallida");
            }
        }
    }
?>  