<?php

/*
 * Copyright 2016 NueveBit, todos los derechos reservados.
 */

namespace CSFacturacion\CSReporter\Impl\Http;

/**
 * Simplificación de una respuesta HTTP.
 *
 * @author emerino
 */
class Response {

    private $rawResponse;

    private $code;

    function __construct($rawResponse, $code) {
        $this->rawResponse = $rawResponse;
        $this->code = $code;
    }

    function getAsJson() {
        return json_decode($this->rawResponse);
    }

    function getRawResponse() {
        return $this->rawResponse;
    }

    function getCode() {
        return $this->code;
    }

}
