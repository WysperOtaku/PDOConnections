<?php

// Errores capa de aplicacion
class EmailInUseException extends DomainException {}
class UserNotFoundException extends DomainException {}

// Errores capa de infraestructura
class InfraestructureException extends RuntimeException {}
class DBErrorException extends InfraestructureException {}

?>