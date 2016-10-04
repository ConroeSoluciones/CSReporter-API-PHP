<?php

/*
 * Copyright 2016 NueveBit, todos los derechos reservados.
 */

namespace ConroeSoluciones\CSReporter\Impl\Http;

class HttpMethod {

    const GET = "GET";
    const POST = "POST";

}

/**
 * Simplificación de una petición HTTP.
 *
 * @author emerino
 */
class Request {

    private $uri;
    private $method;
    private $entity;
    private $acceptMediaType;

    function __construct($uri, $method = HttpMethod::GET, $entity = null) {
        $this->uri = $uri;
        $this->method = $method;
        $this->entity = $entity; // for post requests
    }

    function setAcceptMediaType($mediaType) {
        $this->acceptMediaType = $mediaType;
        return $this;
    }

    function getAcceptMediaType() {
        return $this->acceptMediaType;
    }

    function getURI() {
        return $this->uri;
    }

    function getMethod() {
        return $this->method;
    }

    function getEntity() {
        return $this->entity;
    }

}
