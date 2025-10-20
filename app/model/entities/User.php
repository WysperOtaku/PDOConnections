<?php
    class User {
        private int $user_id;
        private string $nombre;
        private string $apellido;
        private string $email;

        public function __construct() {}

        public function init(?int $id, string $nombre, string $apellido, string $email): void {
            if (!empty($id)) $this->user_id = $id;
            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->email = $email;
        }

        public function getId() {
            return $this->user_id;
        }

        public function getNombre() {
            return $this->nombre;
        }

        public function getApellido() {
            return $this->apellido;
        }

        public function getEmail() {
            return $this->email;
        }
    }
?>