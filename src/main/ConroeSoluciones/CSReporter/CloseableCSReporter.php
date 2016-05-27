<?php

namespace CSFacturacion\CSReporter;

/*
 * Copyright 2016 NueveBit, todos los derechos reservados.
 */

/**
 * Description of CloseableCSReporter
 *
 * @author emerino
 */
interface CloseableCSReporter extends CSReporter {

    function close();
}
