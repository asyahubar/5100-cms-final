<?php

/**
 * Dumps the data on the screen
 * @param $data
 */
function dd($data)
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    die;
}

function view($file, $data = [])
{
    $file = str_replace('.', '/', $file);
    extract($data);
    require "views/{$file}.view.php";
}

function redirect($path)
{
    header("Location: {$path}");
}