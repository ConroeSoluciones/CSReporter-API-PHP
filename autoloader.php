<?php

/* 
 * Copyright 2016 NueveBit, todos los derechos reservados.
 */

spl_autoload_register("register_autoload_csreporter");
function register_autoload_csreporter($name) {
    require_once str_replace("\\", "/", $name) . ".php";
}
