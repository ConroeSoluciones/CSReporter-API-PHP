<?php

namespace CSFacturacion\CSReporter;

/**
 * 'Enum' para los posibles status de un CFDI.
 *
 * @author emerino
 */
class StatusCFDI {

    const VIGENTE = "VIGENTE";
    const CANCELADO = "CANCELADO";
    const TODOS = "TODOS";

}

/**
 * 'Enum' para representar los tipos de un comprobante.
 *
 * @author emerino
 */
class TipoCFDI {

    const EMITIDAS = "EMITIDAS";
    const RECIBIDAS = "RECIBIDAS";

}

class Servicio {

    const CSREPORTER = 8;
    const CSDESCARGASAT = 11;

}

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
