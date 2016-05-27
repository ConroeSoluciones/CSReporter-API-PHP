<?php

namespace CSFacturacion\CSReporter;

/*
 * Copyright 2016 NueveBit, todos los derechos reservados.
 */

/**
 * Builder para crear instancias de Parametros.
 *
 * @author emerino
 */
class ParametrosBuilder {

    private $rfcBusqueda;
    private $fechaInicio;
    private $fechaFin;
    private $status;
    private $tipo;
    private $servicio = Servicio::CSDESCARGASAT;

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

    function rfcBusqueda(RFC $rfc) {
        $this->rfcBusqueda = $rfc;
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

    function servicio($servicio) {
        $this->servicio = $servicio;
        return $this;
    }

    function build() {
        return new Parametros($this);       
    }

    function getServicio() {
        return $this->servicio;
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

}
