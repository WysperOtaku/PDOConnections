<?php
    class UserDAO {
        private Connection $con;

        public function __construct(Connection $dbcon) {
            $this->con = $dbcon;
        }

        public function insert(User $u) : int {
            try{
                $pdo = $this->con->getConnection();
                $stmt = $pdo->prepare("
                    INSERT INTO usuarios(nombre, apellido, email)
                        VALUES (?, ?, ?);
                ");

                $stmt->execute([$u->getNombre(), $u->getApellido(), $u->getEmail()]);
                return (int)$pdo->lastInsertId();
            } catch (PDOException $e) {
                throw new DBErrorException("Error insertando usuario: " . $e->getMessage());
            }
        }

        public function find(int $uid) : User | null {
            try {
                $pdo = $this->con->getConnection();
                $stmt = $pdo->prepare("
                    SELECT *
                        FROM usuarios
                    WHERE user_id = ?;
                ");

                $stmt->execute([$uid]);
                $r = $stmt->fetchObject(User::class);
                if ($r) return $r;
                else return null;
            } catch (PDOException $e) {
                throw new DBErrorException("Error encontrando usuario: " . $e->getMessage());
            }
        }

        public function findByEmail(string $userEmail) : User | null {
            try {
                $pdo = $this->con->getConnection();
                $stmt = $pdo->prepare("
                    SELECT *
                        FROM usuarios
                    WHERE email = ?;
                ");

                $stmt->execute([$userEmail]);
                $r = $stmt->fetchObject(User::class);
                if ($r) return $r;
                else return null;
            } catch(PDOException $e) {
                throw new DBErrorException("Error encontrando usuario: " . $e->getMessage());
            }
        }

        public function findAll() : array | null {
            try {
                $pdo = $this->con->getConnection();
                $stmt = $pdo->query("
                    SELECT *
                        FROM usuarios;
                ");

                $stmt->execute();
                $users = $stmt->fetchAll(PDO::FETCH_CLASS, User::class);
                if ($users) return $users;
                else return null;
            } catch (PDOException $e) {
                throw new DBErrorException("No se ha podido consultar usuarios: " . $e->getMessage());
            }
        }

        public function update(User $u) {
            try {
                $pdo = $this->con->getConnection();
                $stmt = $pdo->prepare("
                    UPDATE usuarios
                        SET nombre = :nombre, apellido = :apellido, email = :email
                    WHERE user_id = :id;
                ");
                $stmt->execute([
                    ':nombre' => $u->getNombre(),
                    ':apellido' => $u->getApellido(),
                    ':email' => $u->getEmail(),
                    ':id' => $u->getId()
                ]);
            } catch (PDOException $e) {
                throw new DBErrorException("Error actualizando usuario: " . $e->getMessage());
            }
        }

        public function delete(int $uid) {
            try {
                $pdo = $this->con->getConnection();
                $stmt = $pdo->prepare("
                    DELETE FROM usuarios WHERE user_id = ?;
                ");
                $stmt->execute([$uid]);
            } catch(PDOException $e) {
                throw new DBErrorException("Error tratando de eliminar usuario: " . $e->getMessage());
            }
        }
    }
?>