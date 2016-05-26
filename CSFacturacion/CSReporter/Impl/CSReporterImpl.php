<?php

/*
 * Copyright 2016 NueveBit, todos los derechos reservados.
 */

namespace CSFacturacion\CSReporter\Impl;

use CSFacturacion\CSReporter\ConsultaInvalidaException;
use CSFacturacion\CSReporter\Credenciales;
use CSFacturacion\CSReporter\CSReporter;
use CSFacturacion\CSReporter\Impl\Http\UserAgent;
use CSFacturacion\CSReporter\Impl\Util\RequestFactory;
use CSFacturacion\CSReporter\Parametros;

/**
 * Description of CSReporterImpl
 *
 * @author emerino
 */
class CSReporterImpl implements CSReporter {

    const TIME_FORMAT = "%G-%m-%dT%H:%M:%S";

    private $csCredenciales;
    private $userAgent;

    function __construct($csCredenciales) {
        $this->csCredenciales = $csCredenciales;
        $this->userAgent = new UserAgent();
    }

    private function validarCredenciales() {
        if (!$this->csCredenciales) {
            throw new \Exception("No se han establecido las credenciales "
            . "del contrato");
        }
    }

    public function consultar(Credenciales $credenciales, Parametros $params) {
        $this->validarCredenciales();

        $request = RequestFactory::newConsultaRequest($credenciales, $params);
        $json = $this->userAgent->open($request)->getAsJson();
        $folio = $json["UUID"];

        if (!trim($folio)) {
            $msg = (isset($json["MENSAJE"])) ? $json["MENSAJE"] : "Ocurrió un error desconocido al realizar la consulta.";

            throw new ConsultaInvalidaException($msg);
        }

        return new ConsultaImpl($folio, $this->userAgent);
    }

    public function buscar(string $folio) {
        $this->validarExistente($folio);

        $consulta = new ConsultaImpl($folio, $this->userAgent);

        // si tiene status REPETIR, iníciala de nuevo
        if ($consulta->isRepetir()) {
            $consulta = $this->repetir($folio);
        }

        return $consulta;
    }

    private function validarExistente($folio) {
        $this->validarCredenciales();

        $statusRequest = RequestFactory::newProgresoRequest($folio);
        $responseCode = $this->userAgent->open($statusRequest);

        if ($responseCode !== 200) {
            throw new ConsultaInvalidaException("No existe ninguna consulta "
            . "con el UUID dado.");
        }
    }

    public function repetir($folio) {
        $this->validarExistente($folio);

        $repetirRequest = RequestFactory::newRepetirRequest($folio);
        $this->userAgent->open($repetirRequest);

        return new ConsultaImpl($folio, $this->userAgent);
    }

    function getCsCredenciales() {
        return $this->csCredenciales;
    }

}
