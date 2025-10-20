<?php

Class UserService {
    private UserDAO $dao;
    private Connection $con;

    public function __construct(UserDAO $dao, Connection $con) {
        $this->dao = $dao;
        $this->con = $con;
    }

    public function createUser(string $nombre, string $apellido, string $email) {
        // Mini verificaciones del input
        if (!preg_match("/^[\w.-]+@[\w.-]+\.[a-z]{2,}$/i", $email) || ($nombre == '' || $apellido == '')) {
            throw new DomainException("Valores entrados no validos");
        }

        $this->tx(function() use ($nombre, $apellido, $email) {
            $exists = $this->dao->findByEmail($email);

            if ($exists) throw new EmailInUseException("Email ya en uso");

            $usuario = new User(null, $nombre, $apellido, $email);
            $this->dao->insert($usuario);
        });
    }

    public function searchUser(int $uid): User | null {
        return $this->tx(function() use ($uid) {
            $result = $this->dao->find($uid);
            return $result;
        });
    }

    public function searchAllUsers(): array | null {
        return $this->tx(function() {
            $result = $this->dao->findAll();
            return $result;
        });
    }

    public function updateUser(int $uid, string $nombre, string $apellido, string $email) {
        // Mini verificaciones del input
        if (!preg_match("/^[\w.-]+@[\w.-]+\.[a-z]{2,}$/i", $email) || ($nombre == '' || $apellido == '')) {
            throw new DomainException("Valores entrados no validos");
        }
        $this->tx(function() use ($uid, $nombre, $apellido, $email) {
            $u_exists = $this->dao->find($uid);
            if (!$u_exists) throw new UserNotFoundException("El usuario que intentas actualizar no se ha encontrado");

            $e_exists = $this->dao->findByEmail($email);
            if ($e_exists) throw new EmailInUseException("El email al que quieres cambiar ya esta en uso");

            $new_user_info = new User($uid, $nombre, $apellido, $email);
            $this->dao->update($new_user_info);
        });
    }

    public function deleteUser(int $uid) {
        $this->tx(function() use ($uid) {
            $u_exists = $this->dao->find($uid);
            if (!$u_exists) throw new UserNotFoundException("El usuario que intentas eliminar no se ha encontrado");
            
            $this->dao->delete($uid);
        });
    }

    public function tx(callable $fn) {
        try {
            $pdo = $this->con->getConnection();
            $pdo->beginTransaction();
            $result = $fn();
            $pdo->commit();
            return $result;
        } catch (Exception $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            throw $e;
        }
    }
}

?>