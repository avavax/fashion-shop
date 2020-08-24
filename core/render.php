<?php

function render(string $path, array $vars = []) : string
{
    $systemTemplateRenererIntoFullPath = $_SERVER['DOCUMENT_ROOT'] . "/views/{$path}.php";
    extract($vars);
    ob_start();
    include $systemTemplateRenererIntoFullPath;
    return ob_get_clean();
}
