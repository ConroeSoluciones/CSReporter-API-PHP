<?php

namespace CSFacturacion\CSReporter;

/**
 * Esta es la interfaz principal para iniciar la comunicación con el WS.
 * A partir de aquí, se pueden realizar nuevas consultas, búsquedas de folios
 * previamente consultados y repetir consultas pasadas.
 *
 * @author emerino
 */
interface CSReporter {

    /**
     * Realiza una consulta para obtener los CFDIs que correspondan de acuerdo
     * a los parámetros especificados. 
     * 
     * @param Credenciales $credenciales credenciales de acceso al SAT.
     * @param Parametros $params los parámetros de búsqueda.
     * @return Consulta la consulta que contiene la 
     * funcionalidad para obtener el status y resultados de la misma.
     * @throws ConsultaInvalidaException si ocurre un problema
     * con los parámetros de la consulta.
     */
    function consultar(Credenciales $credenciales, Parametros $params);

    /**
     * Es posible buscar consultas por folio específico, en caso que se hayan
     * realizado previamente y se quiera consultar sus resultados.
     * 
     * @param string $folio de la consulta previamente realizada.
     * @throws ConsultaInvalidaException si no se encuentra
     * ninguna consulta con el folio especificado.
     * @return Consulta la consulta con el folio
     * especificado.
     */
    function buscar($folio);

    /**
     * Si la consulta con el folio dado está en status REPETIR, este método
     * repetirá la consulta para obtener los resultados necesarios.
     * 
     * @param string $folio de la consulta previamente realizada.
     * @throws ConsultaInvalida si no es posible
     * repetir la consulta (e.g. status != "REPETIR" o no existe el folio).
     * @return Consulta la consulta que se repetirá.
     */
    function repetir($folio);
}
