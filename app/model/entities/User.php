<?php
    class User {
        private int $user_id;
        private string $nombre;
        private string $apellido;
        private string $email;

        public function __construct(?int $id_user, string $nombre_user, string $apellido_user, string $email_user) 
        {   
            if (!empty($id_user)) $this->user_id = $id_user;
            $this->nombre = $nombre_user;
            $this->apellido = $apellido_user;
            $this->email = $email_user;
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