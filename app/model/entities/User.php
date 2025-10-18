<?php
    class User {
        private int $id;
        private string $nombre;
        private string $apellido;
        private string $email;

        public function __construct(?int $id_user, string $nombre_user, string $apellido_user, string $email_user) 
        {   
            if (!empty($id_user)) $this->id = $id_user;
            $this->nombre = $nombre_user;
            $this->apellido = $apellido_user;
            if (preg_match("/^[\w.-]+@[\w.-]+\.[a-z]{2,}$/i", $email_user)) {
                $this->email = $email_user;
            }
            else{
                throw new InvalidArgumentException("Email invalid");
            }
        }

        public function getId() {
            return $this->id;
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