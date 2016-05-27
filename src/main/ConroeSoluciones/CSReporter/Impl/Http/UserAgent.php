<?php

/*
 * Copyright 2016 NueveBit, todos los derechos reservados.
 */

namespace CSFacturacion\CSReporter\Impl\Http;

/**
 * Se encarga de manejar toda la comunicación HTTP y devolverla en un formato de
 * fácil acceso (e.g. un String o una lista).
 *
 * @author emerino
 */
class UserAgent {

    private $ch;

    function __construct() {
        $this->ch = curl_init();
    }

    /**
     * Realiza una petición a un servidor web.
     * 
     * @param Request $request la petición a enviar.
     * @return Response la respuesta del servidor.
     */
    function open(Request $request) {
        $uri = $request->getURI();
        curl_setopt($this->ch, CURLOPT_URL, $uri);
        curl_setopt($this->ch, CURLOPT_HEADER, 0);

        if ($request->getMethod() === HttpMethod::POST) {
            curl_setopt($this->ch, CURLOPT_POST, true);

            if ($request->getEntity()) {
                curl_setopt($this->ch, CURLOPT_POSTFIELDS, $request->getEntity());
            }
        } else {
            curl_setopt($this->ch, CURLOPT_POST, false);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, null);
        }

        $rawResponse = curl_exec($this->ch);
        $code = curl_getinfo($this->ch, CURLINFO_RESPONSE_CODE);
        return new Response($rawResponse, $code);
    }

    /**
     * Realiza las operaciones necesarias para liberar los recursos utilizados.
     */
    function close() {
        $this->ch->close();
    }

}
