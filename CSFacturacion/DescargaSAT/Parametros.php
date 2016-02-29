<?php

/**
 * Clase que define los parámetros de búsqueda disponibles en el WS, a través
 * de una API fluida.
 *
 * @author emerino
 */
class Parametros {

    const STATUS_VIGENTE = "VIGENTE";

    const STATUS_CANCELADO = "CANCELADO";

    const TIPO_EMITIDAS = "INGRESO";

    const TIPO_RECIBIDAS = "EGRESO";

    private $rfcEmisor;

    private $rfcReceptor;

    private $fechaInicio;

    private $fechaFin;

    private $status;

    private $tipo;

    /**
     * Crea una nueva instancia
     */
    function __construct() {
        
        // puede no especificarse, en ese caso se tomará la fecha actual
        $this->fechaFin = strftime("%G-%m-%dT%H:%M:%S", time());

        // todas por defecto
        $this->status = null;
        $this->tipo = null;
    }

    function rfcEmisor($rfc) {
        $this->rfcEmisor = $rfc;
        return $this;
    }

    function rfcReceptor($rfc) {
        $this->rfcReceptor = $rfc;
        return $this;
    }

    function fechaInicio($fecha) {
        $this->fechaInicio = $fecha;
        return $this;
    }

    function fechaFin($fecha) {
        $this->fechaFin = $fecha;
        return $this;
    }

    function status($status) {
        $this->status = $status;
        return $this;
    }
    
    function tipo($tipo) {
        $this->tipo = $tipo;
        return $this;
    }
    
    function getRfcEmisor() {
        return $this->rfcEmisor;
    }

    function getRfcReceptor() {
        return $this->rfcReceptor;
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


}
