<?php

/*
 * Copyright 2016 NueveBit, todos los derechos reservados.
 */

namespace ConroeSoluciones\CSReporter\Impl\Util;

/**
 * Representación de una URI simple.
 *
 * @author emerino
 */
class URI {

    private $scheme;
    private $host;
    private $path;
    private $params;

    function __construct(URIBuilder $builder) {
        $this->scheme = $builder->getScheme();
        $this->host = $builder->getHost();
        $this->path = $builder->getPath();
        if (strrpos($this->path, "/") !== strlen($this->path) -1) {
            $this->path = $this->path . "/";
        }
        $this->params = $builder->getParams();
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

    function getBase() {
        return $this->scheme . "://" . $this->host;
    }

    public function __toString() {
        $uri = $this->getBase() . $this->path;
        return ($this->params) ? $uri . "?" . http_build_query($this->params, "", "&", PHP_QUERY_RFC3986) : $uri;
    }

}
