<?php

/*
 * Copyright 2016 NueveBit, todos los derechos reservados.
 */

require_once dirname(__FILE__) . '/../main/autoloader.php';

use ConroeSoluciones\CSReporter\Credenciales;
use ConroeSoluciones\CSReporter\Impl\CSReporterImpl;
use ConroeSoluciones\CSReporter\ParametrosBuilder;
use ConroeSoluciones\CSReporter\StatusCFDI;
use ConroeSoluciones\CSReporter\TipoCFDI;

date_default_timezone_set("America/Mexico_City");

$csCredenciales = new Credenciales("CSO1304138Z0", "");
$csReporter = new CSReporterImpl($csCredenciales);

$satCredenciales = new Credenciales("MEHE860130RUA", "d0sg4t0s");
$paramsBuilder = new ParametrosBuilder();
$consulta = $csReporter->consultar($satCredenciales, $paramsBuilder
                ->fechaInicio("2016-01-01T00:00:00")
                ->fechaFin("2016-01-31T23:59:59")
                ->status(StatusCFDI::VIGENTE)
                ->tipo(TipoCFDI::EMITIDAS)
                ->build());

echo $consulta->getFolio() . "\n";

while (!$consulta->isTerminada()) {
    echo $consulta->getStatus() . "\n";
    \sleep(5);
}

echo $consulta->getStatus() . "\n";
echo "Total resultados: " . $consulta->getTotalResultados() . "\n";
echo "Total páginas: " . $consulta->getPaginas() . "\n";

for ($i = 1; $i <= $consulta->getPaginas(); $i++) {
    $resultados = $consulta->getResultados($i);

    var_dump($resultados);
}

// se debe llamar a este método para liberar los recursos que haya utilizado el
// CSReporter
$csReporter->close();
