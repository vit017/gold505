<?php


spl_autoload_register("autoloaderGold505");

function autoloaderGold505($className)
{
    include_once str_replace('\\', '/', $_SERVER["DOCUMENT_ROOT"] . "/" . $className . '.php');
}