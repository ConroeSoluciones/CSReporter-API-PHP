<?php

/*
 * Copyright 2016 NueveBit, todos los derechos reservados.
 */

/**
 * Description of RFC
 *
 * @author emerino
 */
class RFC {

    private $valor;

    function __construct($valor) {
        $this->valor = $valor;
    }
    
    public function __toString() {
         return $this->valor;      
    }

}
