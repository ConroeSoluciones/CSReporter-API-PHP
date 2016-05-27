<?php

/*
 * Copyright 2016 NueveBit, todos los derechos reservados.
 */

namespace ConroeSoluciones\CSReporter\Impl\Util;

use ConroeSoluciones\CSReporter\Credenciales;
use ConroeSoluciones\CSReporter\Impl\Http\HttpMethod;
use ConroeSoluciones\CSReporter\Impl\Http\Request;
use ConroeSoluciones\CSReporter\Parametros;
use ConroeSoluciones\CSReporter\StatusCFDI;
use ConroeSoluciones\CSReporter\TipoCFDI;

/**
 * Contiene método de utilidad para crear Requests de CSReporter.
 *
 * @author emerino
 */
class RequestFactory {

    const CS_HOST = "www.csfacturacion.com";

    private $wsHost;
    
    function __construct($wsHost) {
        $this->wsHost = ($wsHost) ? $wsHost : self::CS_HOST;
    }
    
    function getWsHost() {
        return $this->wsHost;
    }


        /**
     * Crea un nuevo Request para realizar una nueva consulta.
     * @param Credenciales $credenciales
     * @param Parametros $params
     * @return \ConroeSoluciones\CSReporter\Impl\Util\Request
     */
    function newConsultaRequest(Credenciales $csCredenciales, Credenciales $credenciales, Parametros $params) {
        $tipoConsulta = ($params->getTipo() === TipoCFDI::EMITIDAS) ? "emitidas" : "recibidas";
        $rfcBusqueda = ($params->getRfcBusqueda()) ? $params->getRfcBusqueda() : "todos";

        $status = null;

        switch ($params->getStatus()) {
            case StatusCFDI::VIGENTE:
                $status = "vigentes";
                break;
            case StatusCFDI::CANCELADO:
                $status = "cancelados";
                break;
            default :
                $status = "todos";
                break;
        }


        $uriBuilder = new URIBuilder();
        $uri = $uriBuilder
                ->scheme("https")
                ->host($this->wsHost)
                ->path("/webservices/csdescargasat")
                ->params(array(
                    "method" => "ConsultaSat",
                    "cRfcContrato" => $csCredenciales->getUsuario(),
                    "cRfc" => $credenciales->getUsuario(),
                    "cPassword" => $credenciales->getPassword(),
                    "cFchI" => $params->getFechaInicio(),
                    "cFchF" => $params->getFechaFin(),
                    "cConsulta" => $tipoConsulta,
                    "cRfcSearch" => $rfcBusqueda,
                    "cServicio" => $params->getServicio(),
                    "cEstatus" => $status
                ))
                ->build();

        return new Request($uri);
    }

    private function newResultadosURI($folio, $path) {
        $uriBuilder = new URIBuilder();
        return $uriBuilder
                -> scheme("https")
                -> host($this->wsHost)
                -> path("/webservices/csdescargasat/resultados/" + $folio + $path)
                -> build();
    }

    /**
     * Crea un nuevo Request para consultar el progreso de la consulta con el
     * folio dado.
     * @param string $folio
     * @return Request para conocer el progreso
     */
    function newProgresoRequest($folio) {
        $uri = self::newResultadosURI($folio, "/progreso");
        return new Request($uri, HttpMethod::POST);
    }

    function newResultadosRequest($folio, $pagina) {
        $uri = self::newResultadosURI($folio, "/" . $pagina);
        return new Request($uri);
    }

    function newRepetirRequest($folio) {
        $uriBuilder = new URIBuilder();
        $uri = $uriBuilder
                ->scheme("https")
                ->host($this->wsHost)
                ->path("/webservices/csdescargasat/repetir")
                ->build();

        return new Request($uri, HttpMethod::POST, array(
            "idConsulta" => $folio
        ));
    }

    function newDescargaRequest($folioConsulta, $folioCFDI) {
        $uriBuilder = new URIBuilder();
        $uri = $uriBuilder
                ->scheme("https")
                ->host($this->wsHost)
                ->path("/webservices/csdescargasat/descargas/" . $folioConsulta . "/" . $folioCFDI)
                ->build();

        return new Request($uri);
    }

    function newResumenRequest($folio) {
        $uri = self::newResultadosURI($folio, "/resumen");
        return new Request($uri);
    }

}
