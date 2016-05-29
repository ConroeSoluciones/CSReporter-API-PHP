# CSReporter PHP API

Provee una API sencilla para realizar consultas al portal del SAT a través
de nuestro Web Service.

Consta de 2 interfaces principales:

    CSFacturacion\CSReporter\CSReporterl
    CSFacturacion\CSReporter\Consulta

Las implementaciones de ambas interfaces se encargan de realizar las peticiones
HTTP a la API REST del WS, presentando una API sencilla para clientes finales.

# Uso

Existen 2 maneras de incluir la API como dependencia de otro proyecto: a través
de [Composer](https://getcomposer.org/) o de manera manual.

## Incluir dependencia con Composer

Esta es la manera recomendada de incluir la API como dependencia de otro
proyecto. En el archivo composer.json agregar lo siguiente:

    {
        "require": {
            "conroe-soluciones/csreporter": "dev-master"
        },
        "repositories": [
            {
                "type": "vcs",
                "url": "https://github.com/ConroeSoluciones/CSReporter-API-PHP.git"
            }
        ]
    }

Una vez incluida la API como dependencia de otro proyecto, es necesario ejecutar
el siguiente comando en la carpeta raíz del proyecto:

    composer install

Con esto, la API se descargará y estará lista para usarse al incluir el archivo 
"vendor/autoload.php" en los scripts donde se quiera trabajar con la API.

## Incluir dependencia manualmente

El ejecutor de tareas [Robo](http://robo.li/) es utilizado para generar un
ZIP con los archivos necesarios para ser incluidos manualmente en otro
proyecto.

Para ello, es necesario descargar e instalar [Composer](https://getcomposer.org/)
para instalar Robo como dependencia del proyecto con el siguiente comando: 

    composer install

Una vez descargado e instalado, ejecutar el siguiente comando desde la carpeta 
raíz del proyecto:

    vendor/bin/robo build:package

Lo anterior generará el archivo "build/csreporter-api.zip", el cuál podrá
ser descomprimido en otro proyecto para ser incluido manualmente, incluyendo
el archivo "autoloader.php" incluido en la raíz del archivo comprimido.

## Ejemplos de uso

Ver el repositorio [CSReporter-API-PHP-Ejemplos](https://github.com/ConroeSoluciones/CSReporter-API-PHP-Ejemplos).