<?php

namespace ConroeSoluciones\CSReporter;

/**
 * Credenciales de acceso genéricas.
 * TODO: Comprobaciones sobre los datos ingresados.
 *
 * @author emerino
 */
class Credenciales {

    private $usuario;

    private $password;
    
    function __construct($username, $password=null) {
        $this->usuario = $username;
        $this->password = $password;
    }
    function getUsuario() {
        return $this->usuario;
    }

    function getPassword() {
        return $this->password;
    }

}
