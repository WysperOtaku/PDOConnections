<?php
    class Connection {
        private $pdo;

        public function __construct($dbname ,$username, $passwd) {
            try{
                $dsn = `mysql:host=localhost;dbname={$dbname};charset=utf8mb4`;
                $this->pdo = new PDO($dsn, $username, $passwd, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);

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
                $this->pdo = new PDO($dsn, $username, $passwd, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);

            } catch (Exception $e) {
                throw new PDOException("Conexion a la BBDD fallida");
            }
        }
    }
?>  