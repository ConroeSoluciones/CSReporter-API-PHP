<?php

namespace ConroeSoluciones\CSReporter;

/**
 * Clase que define los parámetros de búsqueda disponibles en el WS. Sólo
 * lectura, para construir instancias, utilizar un ParametrosBuilder.
 *
 * @author emerino
 */
class Parametros {

    private $rfcBusqueda;
    private $fechaFin;
    private $status;
    private $tipo;
    private $servicio;

    function __construct(ParametrosBuilder $builder) {
        $this->rfcBusqueda = $builder->getRfcBusqueda();
        $this->fechaFin = $builder->getFechaFin();
        $this->fechaInicio = $builder->getFechaInicio();
        $this->status = $builder->getStatus();
        $this->tipo = $builder->getTipo();
        $this->servicio = $builder->getServicio();
    }

    function getRfcBusqueda() {
        return $this->rfcBusqueda;
    }

    function getFechaInicio() {
        return $this->fechaInicio;
    }

    function getFechaFin() {
        return $this->fechaFin;
    }

    function getStatus() {
        return $this->status;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getServicio() {
        return $this->servicio;
    }

}
