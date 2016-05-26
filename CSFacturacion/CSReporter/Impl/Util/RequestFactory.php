<?php

/*
 * Copyright 2016 NueveBit, todos los derechos reservados.
 */

namespace CSFacturacion\CSReporter\Impl\Util;

use CSFacturacion\CSReporter\Credenciales;
use CSFacturacion\CSReporter\Impl\Http\HttpMethod;
use CSFacturacion\CSReporter\Impl\Http\Request;
use CSFacturacion\CSReporter\Parametros;
use CSFacturacion\CSReporter\StatusCFDI;
use CSFacturacion\CSReporter\TipoCFDI;

/**
 * Contiene método de utilidad para crear Requests de CSReporter.
 *
 * @author emerino
 */
class RequestFactory {

    const CS_HOST = "csfacturacion.com";

    /**
     * Crea un nuevo Request para realizar una nueva consulta.
     * @param Credenciales $credenciales
     * @param Parametros $params
     * @return \CSFacturacion\CSReporter\Impl\Util\Request
     */
    static function newConsultaRequest(Credenciales $credenciales, Parametros $params) {
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
                ->host(RequestFactory::CS_HOST)
                ->path("/webservices/csdescargasat")
                ->params(array(
                    "method" => "ConsultaSat",
                    "cRfcContrato" => $this->csCredenciales->getUsuario(),
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

    private static function newResultadosURI($folio, $path) {
        $uriBuilder = new URIBuilder();
        return $uriBuilder
                . scheme("https")
                . host(RequestFactory::CS_HOST)
                . path("/webservices/csdescargasat/resultados/" + $folio + $path)
                . build();
    }

    /**
     * Crea un nuevo Request para consultar el progreso de la consulta con el
     * folio dado.
     * @param string $folio
     * @return Request para conocer el progreso
     */
    static function newProgresoRequest($folio) {
        $uri = RequestFactory::newResultadosURI($folio, "/progreso");
        return new Request($uri, HttpMethod::POST);
    }

    static function newResultadosRequest($folio, $pagina) {
        $uri = RequestFactory::newResultadosURI($folio, "/" . $pagina);
        return new Request($uri);
    }

    static function newRepetirRequest($folio) {
        $uriBuilder = new URIBuilder();
        $uri = $uriBuilder
                ->scheme("https")
                ->host(RequestFactory::CS_HOST)
                ->path("/webservices/csdescargasat/repetir")
                ->build();

        return new Request($uri, HttpMethod::POST, array(
            "idConsulta" => $folio
        ));
    }

    static function newDescargaRequest($folioConsulta, $folioCFDI) {
        $uriBuilder = new URIBuilder();
        $uri = $uriBuilder
                ->scheme("https")
                ->host(RequestFactory::CS_HOST)
                ->path("/webservices/csdescargasat/descargas/" . $folioConsulta . "/" . $folioCFDI)
                ->build();

        return new Request($uri);
    }

    static function newResumenRequest($folio) {
        $uri = RequestFactory::newResultadosURI($folio, "/resumen");
        return new Request($uri);
    }

}
