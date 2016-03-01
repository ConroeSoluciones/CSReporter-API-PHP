# DescargaSAT PHP API

Provee una API sencilla para realizar consultas al portal del SAT a través
de nuestro Web Service.

Consta de 2 interfaces principales:

    CSFacturacion\DescargaSAT\IDescargarSAT
    CSFacturacion\DescargaSAT\IConsulta

Las implementaciones de ambas interfaces se encargan de realizar las peticiones
HTTP a la API REST del WS, presentando una API sencilla para clientes finales.

Ejemplo de uso:

    // importar namespaces
    use CSFacturacion\DescargaSAT;

    // una instancia de un IDescargaSAT debe permitir realizar múltiples
    // consultas, de un mismo contrato
    $descargaSAT = new DescargaSAT(new Credenciales("usuario_cs", "pass"));

    // realizar una nueva consulta (la consulta es de sólo lectura),
    // la API debe manejar los tiempos de espera y permitir recibir una cadena
    // como parámetro, la cual representa la función (callback) que debe 
    // ejecutarse cuando la consulta haya terminado
    $consulta = $descargaSAT->consultar(
            new Credenciales("RFC", "pass"),
            new Parametros()
            ->fechaInicio("2016-01-01T00:00:00")
            ->status(Parametros::STATUS_VIGENTE)
            ->tipo(Parametros::TIPO_EMITIDAS),
            "callback");

    function callback($consulta) {
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
    }

    // para obtener una consulta que ya se había realizado previamente, por folio
    $folio = "556cd4f8-fb9f-46d7-de58-4ad0b8102a64";
    $consulta = $descargaSAT->buscar($folio);

    if ($consulta->isTerminada()) {
        echo $consulta->getStatus();
    }

    // para repetir una consulta marcada con status REPETIR
    $consulta = $descargaSAT->repetir($folio, "callback");
    