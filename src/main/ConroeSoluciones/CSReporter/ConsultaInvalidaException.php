<?php

namespace CSFacturacion\CSReporter;

/*
 * Copyright 2016 NueveBit, todos los derechos reservados.
 */

/**
 * Description of ConsultaInvalida
 *
 * @author emerino
 */
class ConsultaInvalidaException extends \Exception {

    public function __construct($message, $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    // representación de cadena personalizada del objeto
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}
