# CSReporter PHP API

Provee una API sencilla para realizar consultas al portal del SAT a través
de nuestro Web Service.

Consta de 2 interfaces principales:

    CSFacturacion\CSReporter\CSReporterl
    CSFacturacion\CSReporter\Consulta

Las implementaciones de ambas interfaces se encargan de realizar las peticiones
HTTP a la API REST del WS, presentando una API sencilla para clientes finales.

Ejemplo de uso:

    // importar namespaces
    use CSFacturacion\CSReporter\Impl\CSReporterImpl;
    use CSFacturacion\CSReporter\Credenciales;
    use CSFacturacion\CSReporter\ParametrosBuilder;
    use CSFacturacion\CSReporter\StatusCFDI;
    use CSFacturacion\CSReporter\TipoCFDI;
    

    // una instancia de un CSReporter debe permitir realizar múltiples
    // consultas, de un mismo contrato
    $csReporter = new CSReporterImpl(new Credenciales("usuario_cs", "pass"));

    // realizar una nueva consulta (la consulta es de sólo lectura),
    $paramsBuilder = new ParametrosBuilder();
    $consulta = $csReporter->consultar(
            new Credenciales("RFC", "pass"),
            $paramsBuilder 
             ->fechaInicio("2016-01-01T00:00:00")
             ->status(StatusCFDI::VIGENTE)
             ->tipo(TipoCFDI::EMITIDAS)
             ->build());

    // espera a que termine la consulta, verifica el status cada 10 segundos
    while(!$consulta->isTerminada()) {
        \sleep(10);
    }

    if (!$consulta->isFallo()) {
        // imprime el status en pantalla
        echo $consulta->getFolio());
        echo $consulta->getStatus();
        echo $consulta->getTotalResultados();

        if ($consulta->getTotalResultados() > 0) {
            // a partir de ahora, pueden obtenerse los resultados derivados
            // de la consulta
            for ($i = 1; $i <= $consulta->getPaginas(); $i++) {
                // obtener los resultados de la primera página
                $resultados = $consulta->getResultados($i);
                var_dump($resultados);
            }
        }
    }

    // para obtener una consulta que ya se había realizado previamente, por folio
    $folio = "556cd4f8-fb9f-46d7-de58-4ad0b8102a64";
    $consulta = $csReporter->buscar($folio);

    if ($consulta->isTerminada()) {
        echo $consulta->getStatus();
    }

    // para repetir una consulta marcada con status REPETIR
    $consulta = $csReporter->repetir($folio);
    