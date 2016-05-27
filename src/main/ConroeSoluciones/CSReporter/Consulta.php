<?php

namespace CSFacturacion\CSReporter;

/**
 * 'Enum' que sirve para listar los distintos STATUS posibles de una consulta.
 */
class StatusConsulta {
    const EN_ESPERA = "EN_ESPERA";
    const EN_PROCESO = "EN_PROCESO";
    const DESCARGANDO = "DESCARGANDO";
    const FALLO_AUTENTICACION = "FALLO_AUTENTICACION";
    const FALLO_500_MISMO_HORARIO = "FALLO_500_MISMO_HORARIO";
    const FALLO = "FALLO";
    const COMPLETADO = "COMPLETADO";
    const REPETIR = "REPETIR";
}

/**
 * Representa una consulta realizada al portal CFDI del SAT. 
 *
 * @author emerino
 */
interface Consulta {

    /**
     * El status de la consulta puede ser:
     * 
     * EN_ESPERA: No han comenzado a descargarse los CFDIs, se encuentra en 
     * cola la petición.
     * EN_PROCESO: La descarga de CFDIs está en curso.
     * DESCARGANDO: Ya se tiene el total de resultados, pero aún se están 
     * descargando los XMLs.
     * FALLO_AUTENTICACION: Ocurre cuando no se ha podido autenticar con el RFC
     *  y contraseñas provistos con el portal del SAT. 
     * FALLO_500_MISMO_HORARIO: Ocurre cuando se obtienen más de 500 resultados 
     * con la misma fecha y horario (minuto exacto).
     * FALLO: Distintos errores pueden causar este estado.
     * COMPLETADO: Los CFDIs de la consulta se han descargado.
     * REPETIR: Cuando una consulta necesita repetirse (generalmente para 
     * descargar XMLs faltantes).
     * 
     * @return string El status actual de la consulta, reportado por el WS.
     */
    function getStatus();

    /**
     * Cuando una consulta ha terminado, su status puede ser:
     * FALLO_AUTENTICACION
     * FALLO_500_MISMO_HORARIO
     * FALLO
     * COMPLETADO
     * 
     * Para verificar que no se haya completado con error, verificar el método
     * isFallo() o directamente el status de la consulta.
     * 
     * @return boolean true si se devuelve cualquiera de los status anteriores
     * o false de otro modo.
     */
    function isTerminada();

    /**
     * Cualquiera de los siguientes status deben marcar esta consulta como
     * fallo:
     * 
     * FALLO_AUTENTICACION
     * FALLO_500_MISMO_HORARIO
     * FALLO
     * 
     * @return boolean true si se devuelve cualquiera de los status anteriores
     * o false de otro modo.
     */
    function isFallo();

    /**
     * Si la consulta ha sido marcada con status REPETIR, no habrá ningún 
     * resultado disponible y será necesario repetir esta consulta.
     * 
     * @see repetir()
     * @return boolean true si el status es REPETIR, false de otro modo.
     */
    function isRepetir();

    /**
     * Cuando se realiza una consulta a través de un IDescargaSAT, se genera
     * un folio único que identifica la consulta.
     * 
     * @return string el UUID que identifica a la consulta.
     */
    function getFolio();

    /**
     * Total de registros encontrados en el portal del SAT para esta consulta.
     * 
     * @return int El total de resultados de la consulta, 0 si no se encontró 
     * ninguno.
     */
    function getTotalResultados();

    /**
     * Los resultados se envían paginados, devuelve el total de páginas 
     * disponibles para obtener resultados.
     * 
     * @return int total de páginas disponibles o 0 si no hay resultados. 
     */
    function getPaginas();

    /**
     * Los resultados se devuelven paginados, por lo que este método permite
     * obtener un arreglo de CFDIs (simples) para una página determinada.
     * 
     * @param int $pagina Que se desea obtener.
     * @return array El total de registros encontrados en la página dada o
     * un arreglo vacío si no hay suficientes resultados.
     */
    function getResultados($pagina);

    /**
     * Permite obtener un CFDI específico, resultante de esta consulta,
     * como cadena.

     * @param string $folio El folio (UUID) del CFDI.
     * @return string El XML del folio dado o null si no se pudo obtener el
     * CFDI de esta consulta.
     */
    function getCFDI($folio);

    /**
     * Devuelve el XML del CFDIMeta dado. En ocasiones puede no haber un XML 
     * asociado, en estos casos devuelve null. 
     * 
     * @param string $folio del CFDIMeta.
     * @return string el XML asociado con el CFDIMeta o null si no hay ninguno.
     */
    function getCFDIXML($folio);
}
