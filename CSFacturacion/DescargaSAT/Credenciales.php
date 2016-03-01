<?php

/**
 * Credenciales de acceso genéricas.
 *
 * @author emerino
 */
class Credenciales {

    private $username;

    private $password;
    
    function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }
    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

}
