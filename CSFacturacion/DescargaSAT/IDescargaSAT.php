<?php

namespace CSFacturacion\DescargaSAT;

/**
 * Esta es la interfaz principal para iniciar la comunicación con el WS.
 * A partir de aquí, se pueden realizar nuevas consultas, búsquedas de folios
 * previamente consultados y repetir consultas pasadas.
 *
 * @author emerino
 */
interface IDescargaSAT {

    /**
     * Realiza una consulta para obtener los CFDIs que correspondan de acuerdo
     * a los parámetros especificados. Si se especifica el callback, éste será
     * llamado una vez la consulta se encuentre terminada.
     * 
     * @param Parametros $params los parámetros de búsqueda.
     * @param mixed $callback el nombre de la función que será llamada cuando
     * se complete esta consulta, puede ser nulo (para realizar el tracking
     * manualmente).
     * @return \CSFacturacion\DescargaSAT\IConsulta la consulta que contiene la 
     * funcionalidad para obtener el status y resultados de la misma.
     * @throws \CSFacturacion\DescargaSAT\ConsultaInvalida si ocurre un problema
     * con los parámetros de la consulta.
     */
    function consultar(Parametros $params, $callback);

    /**
     * Es posible buscar consultas por folio específico, en caso que se hayan
     * realizado previamente y se quiera consultar sus resultados.
     * 
     * @param string $folio de la consulta previamente realizada.
     * @throws \CSFacturacion\DescargaSAT\ConsultaInvalida si no se encuentra
     * ninguna consulta con el folio especificado.
     * @return \CSFacturacion\DescargaSAT\IConsulta la consulta con el folio
     * especificado.
     */
    function buscar(string $folio);

    /**
     * Si la consulta con el folio dado está en status REPETIR, este método
     * repetirá la consulta para obtener los resultados necesarios.
     * 
     * @param string $folio de la consulta previamente realizada.
     * @param mixed el nombre de la función que será llamada cuando se complete
     * la repetición de esta consulta, puede ser nulo.
     * @throws \CSFacturacion\DescargaSAT\ConsultaInvalida si no es posible
     * repetir la consulta (e.g. status != "REPETIR" o no existe el folio).
     * @return \CSFacturacion\DescargaSAT\IConsulta la consulta que se repetirá.
     */
    function repetir(string $folio, $callback);
}
