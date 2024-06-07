# CSReporter PHP API

Provee una API sencilla para realizar consultas al portal CFDI del SAT a través
de nuestro Web Service.

Consta de 2 interfaces principales:

    ConroeSoluciones\CSReporter\CSReporter
    ConroeSoluciones\CSReporter\Consulta

Las implementaciones de ambas interfaces se encargan de realizar las peticiones
HTTP a la API REST del WS, presentando una API sencilla para clientes finales.

## Proyecto Obsoleto

**Este proyecto ya no recibe actualizaciones y dejará de funcionar el 08/10/2024** . Este repositorio será sustituido por `ConroeSoluciones\descarga-ciec-php-sdk`
a partir del `30/09/2024`.

## Dependencias

* PHP 5.3+
* [Composer](https://getcomposer.org/)

## Instalación

Existen 2 maneras de incluir la API como dependencia de otro proyecto: a través
de [Composer](https://getcomposer.org/) o de manera manual.

### Incluir dependencia con Composer

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
"vendor/autoload.php" en los scripts donde se quiera trabajar con ella.

### Incluir dependencia manualmente

Ejecutar el siguiente comando para descargar el código fuente de esta 
biblioteca (necesitas tener instalado [Git](https://git-scm.com/)):

    git clone git@github.com:ConroeSoluciones/CSReporter-API-PHP.git

El ejecutor de tareas [Robo](http://robo.li/) es utilizado para generar un
ZIP con los archivos necesarios para ser incluidos manualmente en otro
proyecto.

Para instalar Robo como dependencia del proyecto usar el siguiente comando: 

    composer install

Una vez descargado e instalado, ejecutar el siguiente comando desde la carpeta 
raíz del proyecto:

    vendor/bin/robo dist:package

Lo anterior generará el archivo "build/csreporter-api.zip", el cuál podrá
ser descomprimido en otro proyecto para ser incluido manualmente, incluyendo
el archivo "autoload.php" (incluido en la raíz del archivo comprimido) en los 
scripts que lo requieran.

## Documentación

Ejecutar el siguiente comando para descargar el código fuente de esta 
biblioteca (necesitas tener instalado [Git](https://git-scm.com/)):

    git clone git@github.com:ConroeSoluciones/CSReporter-API-PHP.git

El ejecutor de tareas [Robo](http://robo.li/) es utilizado para generar 
la documentación a través de ApiGen. Para hacerlo, primero es necesario
descargar la dependencia ApiGen con [Composer](https://getcomposer.org/) a 
través del siguiente comando:

    composer install

Una vez descargada e instalada la dependencia, ejecutar el siguiente comando
desde la carpeta raíz del proyecto:

    vendor/bin/robo dist:docs

Con esto se generará la documentación de la API en formato HTML, en el 
directorio "build/docs".

# Ejemplos de uso

Ver el repositorio [CSReporter-API-PHP-Ejemplos](https://github.com/ConroeSoluciones/CSReporter-API-PHP-Ejemplos).
