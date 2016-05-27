<?php

/*
 * Copyright 2016 NueveBit, todos los derechos reservados.
 */

namespace ConroeSoluciones\CSReporter\Impl;

use ConroeSoluciones\CSReporter\Consulta;
use ConroeSoluciones\CSReporter\Impl\Http\UserAgent;
use ConroeSoluciones\CSReporter\Impl\Util\RequestFactory;
use ConroeSoluciones\CSReporter\StatusConsulta;
use Exception;

/**
 * Implementación por defecto de una ConroeSoluciones\CSReporter\Consulta;
 *
 * @author emerino
 */
class ConsultaImpl implements Consulta {

    private $userAgent;
    private $folio;
    private $totalResultados = -1;
    private $paginas = -1;
    private $requestFactory;

    function __construct($folio, UserAgent $userAgent, RequestFactory $requestFactory) {
        $this->userAgent = $userAgent;
        $this->folio = $folio;
        $this->requestFactory = $requestFactory;
    }

    public function getCFDI($folio) {
        
    }

    public function getCFDIXML($folio) {
        $this->validarTerminada();

        $request = RequestFactoryDescargaRequest($this->folio, $folio);
        return $this->userAgent->open($request)->getRawResponse();
    }

    private function validarTerminada() {
        if (!$this->isTerminada()) {
            throw new Exception("La consulta no ha terminado");
        }
    }

    public function getFolio() {
        return $this->folio;
    }

    public function getPaginas() {
        if ($this->paginas === -1) {
            $this->validarTerminada();
            $resumen = $this->getResumen();

            $this->paginas = $resumen->paginas;
        }

        return $this->paginas;
    }

    private function getResumen() {
        $request = $this->requestFactory->newResumenRequest($this->folio);
        $response = $this->userAgent->open($request);
        return $response->getAsJson();
    }

    public function getResultados($pagina) {
        $this->validarTerminada();

        $request = $this->requestFactory->newResultadosRequest($this->folio, $pagina);
        return $this->userAgent->open($request)->getAsJson();
    }

    public function getStatus() {
        $statusRequest = $this->requestFactory->newProgresoRequest($this->folio);
        $response = $this->userAgent->open($statusRequest);
        $json = $response->getAsJson();

        return $json->estado;
    }

    public function getTotalResultados() {
        if ($this->totalResultados === -1) {

            $this->validarTerminada();
            $resumen = $this->getResumen();
            $this->totalResultados = $resumen->total;
        }

        return $this->totalResultados;
    }

    public function isFallo() {
        $status = $this->getStatus();
        return (strpos($status, "FALLO") === 0);
    }

    public function isRepetir() {
        return $this->getStatus() === StatusConsulta::REPETIR;
    }

    public function isTerminada() {
        $status = $this->getStatus();
        return (strpos($status, "COMPLETADO") === 0) || $this->isFallo();
    }

}
