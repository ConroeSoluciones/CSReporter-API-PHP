<?php

namespace CSFacturacion\CSReporter\Impl\Util;

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
        // TODO: Validar
        $uri = $this->scheme . "://" . $this->host . $this->path;
        return ($this->params) ? $uri . "?" . http_build_query($this->params, "", "&", PHP_QUERY_RFC3986) : $uri;
    }

}
