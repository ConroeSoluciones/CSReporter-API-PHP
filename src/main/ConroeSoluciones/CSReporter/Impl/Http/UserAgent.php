<?php

/*
 * Copyright 2016 NueveBit, todos los derechos reservados.
 */

namespace ConroeSoluciones\CSReporter\Impl\Http;

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
        curl_setopt($this->ch, CURLOPT_HEADER, false);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);

        if ($request->getMethod() === HttpMethod::POST) {
            curl_setopt($this->ch, CURLOPT_POST, true);

            if ($request->getEntity()) {
                curl_setopt($this->ch, CURLOPT_POSTFIELDS, $request->getEntity());
            }
        } else {
            curl_setopt($this->ch, CURLOPT_HTTPGET, true);
        }

        $rawResponse = curl_exec($this->ch);
        
        if ($rawResponse === false) {
            throw new \Exception(curl_error($this->ch), curl_errno($this->ch));
        }
        
        $code = curl_getinfo($this->ch, CURLINFO_RESPONSE_CODE);
        return new Response($rawResponse, $code);
    }

    /**
     * Realiza las operaciones necesarias para liberar los recursos utilizados.
     */
    function close() {
        curl_close($this->ch);
    }

}
