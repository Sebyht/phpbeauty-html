<?php

use Beauty\Body\Field;
use Beauty\Body\Form;
use Beauty\Body\Hyperlink;
use Beauty\Body\ListElement;
use Beauty\Body\Text;
use Beauty\Body\Wrapper;

function err_msg (string $message)
{
    throw new Exception($message);
}

function is_associative (array $array)
{
    foreach(array_keys($array) as $key) {
        if (is_numeric($key)) {
            return false;
        }
    }

    return true;
}

function buffer (string $file, array $params = [])
{
    if (!file_exists($file)) {
        err_msg("file does not exist in $file");
    }

    is_associative($params);

    ob_start();
    extract($params);
    require $file;
    return ob_get_clean();
}

function sp (?string $directory = null) 
{
    $win = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';

    if ($directory !== null && $win) {
        return str_replace("/", "\\", $directory);
    }

    return $win ? "\\" : "/";
}

function text (string $content)
{
    return new Text($content);
}

function field (string $name, string $tag = "input")
{
    return new Field($name, $tag);
}

function form (string $action, string $method = "get", array $data = [])
{
    return new Form($action, $method, $data);
}

function listing (array $items)
{
    return new ListElement($items);
}

function wrap (string $tag = "div")
{
    return new Wrapper($tag);
}

function hyperlink (string $path, string $label)
{
    return new Hyperlink($path, $label);
}