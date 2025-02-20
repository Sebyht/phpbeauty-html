<?php


namespace Beauty\Utils;

final class Renderer
{
    private array $paths = [];

    private array $globals = [];

    public function render (string $view, array $params = [])
    {
        if ($view[0] !== "@") {
            return null;
        }

        $view = sp($view);

        $namespace = substr($view, 1, strpos($view, sp()) - 1);

        $view = $this->paths[$namespace] . substr($view, strpos($view, sp())) . ".php";

        return buffer($view, array_merge($params, $this->globals));
    }

    public function addPath (string $namespace, string $directory)
    {
        $this->paths[$namespace] = sp($directory);
    }

    public function addGlobal(string $name, $value)
    {
        $this->globals[$name] = $value;
    }
}