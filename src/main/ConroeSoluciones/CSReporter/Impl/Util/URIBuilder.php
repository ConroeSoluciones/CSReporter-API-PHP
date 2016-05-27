<?php

namespace ConroeSoluciones\CSReporter\Impl\Util;

/*
 * Copyright 2016 NueveBit, todos los derechos reservados.
 */

/**
 * Simplifica la creaciónde URIs.
 *
 * @author emerino
 */
class URIBuilder {

    private $scheme;
    private $host;
    private $path;
    private $params;

    function scheme($scheme) {
        $this->scheme = $scheme;
        return $this;
    }

    function host($host) {
        $this->host = $host;
        return $this;
    }

    function path($path) {
        $this->path = $path;
        return $this;
    }

    function params($params) {
        $this->params = $params;
        return $this;
    }

    function build() {
        $uri = new URI($this);
        echo $uri;
        return $uri;
    }
    function getScheme() {
        return $this->scheme;
    }

    function getHost() {
        return $this->host;
    }

    function getPath() {
        return $this->path;
    }

    function getParams() {
        return $this->params;
    }


}
