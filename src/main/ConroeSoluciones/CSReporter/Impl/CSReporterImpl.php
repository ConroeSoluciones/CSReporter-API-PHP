<?php

/*
 * Copyright 2016 NueveBit, todos los derechos reservados.
 */

namespace CSFacturacion\CSReporter\Impl;

use CSFacturacion\CSReporter\CloseableCSReporter;
use CSFacturacion\CSReporter\ConsultaInvalidaException;
use CSFacturacion\CSReporter\Credenciales;
use CSFacturacion\CSReporter\Impl\Http\UserAgent;
use CSFacturacion\CSReporter\Impl\Util\RequestFactory;
use CSFacturacion\CSReporter\Parametros;

/**
 * Implementación por defecto de un CSReporter.
 *
 * @author emerino
 */
class CSReporterImpl implements CloseableCSReporter {

    const TIME_FORMAT = "%G-%m-%dT%H:%M:%S";

    private $csCredenciales;
    private $userAgent;
    private $requestFactory;

    function __construct($csCredenciales, $csHost = null) {
        $this->csCredenciales = $csCredenciales;
        $this->userAgent = new UserAgent();
        $this->requestFactory = new RequestFactory($csHost);
    }

    private function validarCredenciales() {
        if (!$this->csCredenciales) {
            throw new \Exception("No se han establecido las credenciales "
            . "del contrato");
        }
    }

    public function consultar(Credenciales $credenciales, Parametros $params) {
        $this->validarCredenciales();

        $request = $this->requestFactory->newConsultaRequest($this->csCredenciales, $credenciales, $params);
        $json = $this->userAgent->open($request)->getAsJson();
        $folio = $json["UUID"];

        if (!trim($folio)) {
            $msg = (isset($json["MENSAJE"])) ? $json["MENSAJE"] : "Ocurrió un error desconocido al realizar la consulta.";

            throw new ConsultaInvalidaException($msg);
        }

        return $this->newConsulta($folio);
    }

    public function buscar($folio) {
        $this->validarExistente($folio);

        $consulta = newConsulta($folio);

        // si tiene status REPETIR, iníciala de nuevo
        if ($consulta->isRepetir()) {
            $consulta = $this->repetir($folio);
        }

        return $consulta;
    }

    private function validarExistente($folio) {
        $this->validarCredenciales();

        $statusRequest = $this->requestFactory->newProgresoRequest($folio);
        $responseCode = $this->userAgent->open($statusRequest);

        if ($responseCode !== 200) {
            throw new ConsultaInvalidaException("No existe ninguna consulta "
            . "con el UUID dado.");
        }
    }

    public function repetir($folio) {
        $this->validarExistente($folio);

        $repetirRequest = $this->requestFactory->newRepetirRequest($folio);
        $this->userAgent->open($repetirRequest);

        return $this->newConsulta($folio);
    }

    private function newConsulta($folio) {
        return new ConsultaImpl($folio, $this->userAgent, $this->requestFactory);
    }

    function getCsCredenciales() {
        return $this->csCredenciales;
    }

    public function close() {
        $this->userAgent->close();
    }

}
