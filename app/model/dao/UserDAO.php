<?php
    class UserDAO {
        private Connection $con;

        public function __construct(Connection $dbcon) {
            $this->con = $dbcon;
        }

        public function insert(User $u) : int {
            $pdo = $this->con->getConnection();
            $stmt = $pdo->prepare("
                INSERT INTO usuarios(nombre, apellido, email)
                    VALUES (?, ?, ?);
            ");

            if (!empty(UserDAO::findByEmail($u->getEmail()))) {
                throw new EmailInUseException("Email en uso en otra cuenta de usuario");
            }

            $stmt->execute([$u->getNombre(), $u->getApellido(), $u->getEmail()]);
            return (int)$pdo->lastInsertId();
        }

        public function find(int $uid) : User | null {
            $pdo = $this->con->getConnection();
            $stmt = $pdo->prepare("
                SELECT *
                    FROM usuarios
                WHERE user_id = ?;
            ");

            $stmt->execute([$uid]);
            return $stmt->fetchObject(User::class);
        }

        public function findByEmail(string $userEmail) : User | null {
            $pdo = $this->con->getConnection();
            $stmt = $pdo->prepare("
                SELECT *
                    FROM usuarios
                WHERE email = ?;
            ");

            $stmt->execute([$userEmail]);
            return $stmt->fetchObject(User::class);
        }

        public function findAll() : array {
            $pdo = $this->con->getConnection();
            $stmt = $pdo->query("
                SELECT *
                    FROM usuarios;
            ");

            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_CLASS, User::class);

            return $users;
        }

        public function update(User $u) {
            $pdo = $this->con->getConnection();
            $stmt = $pdo->prepare("
                UPDATE usuarios
                    SET nombre = :nombre, apellido = :apellido, email = :email
                WHERE id = :id;
            ");

            if (!UserDAO::find($u->getId())) {
                throw new UserNotFoundException("El usuario que tratas de actualizar no existe");
            }

            if (!empty(UserDAO::findByEmail($u->getEmail()))) {
                throw new EmailInUseException("Email en uso en otra cuenta de usuario");
            }

            $stmt->execute([
                ':nombre' => $u->getNombre(),
                ':apellido' => $u->getApellido(),
                ':email' => $u->getEmail(),
                ':id' => $u->getId()
            ]);

        }

        public function delete(int $uid) {
            $pdo = $this->con->getConnection();
            $stmt = $pdo->prepare("
                DELETE FROM usuarios WHERE id = ?;
            ");

            if (!UserDAO::find($uid)) {
                throw new UserNotFoundException("El usuario que tratas de eliminar no existe");
            }

            $stmt->execute([$uid]);
        }
    }
?>