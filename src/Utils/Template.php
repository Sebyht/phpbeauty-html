<?php

namespace Beauty\Utils;

final class Template
{
    private array $args = [
        "title" => "App",
        "lang" => "en",
        "content" => "",
        "scripts" => "",
        "styles" => "",
        "fonts" => "",
    ];

    private string $layout;

    public function __construct(private string $realpath, ?string $layout = null)
    {
        $realpath = sp($realpath);

        if (!is_dir($realpath)) {
            err_msg("$realpath is not a valid folder");  
        }

        if ($layout !== null && !file_exists($layout)) {
            err_msg("undefined layout file in $layout");
        }

        $this->layout = $layout !== null ? sp($layout) : sp(dirname(__DIR__, 2) . "/layouts/default.php");
    }

    public function default (string $arg, $value)
    {
        if (!array_key_exists($arg, $this->args)) {
            err_msg("Undefined key $arg for template args");
        }

        $this->args[$arg] = $value;
    }

    public function font (string $link)
    {
        $this->templateArg("fonts", $link);
    }

    public function title (string $title, bool $keepOld = true)
    {
        if (!$keepOld) {
            $this->args['title'] = $title;
        } else {
            $this->templateArg("title", " - " . $title);
        }

        return $this;
    }

    public function styles (string $file) : self
    {
        return $this->attachFile($file . ".css");
    }

    public function scripts (string $file) : self
    {
        return $this->attachFile($file . ".js");
    }

    public function content (string $content) : self
    {
        $this->templateArg("content", $content);

        return $this;
    }

    public function write () : string
    {
        return buffer($this->layout, $this->args);
    }

    private function templateArg (string $arg, $value) : void
    {
        if (array_key_exists($arg, $this->args) && is_string($this->args[$arg])) {
            $this->args[$arg] .= $value;
        } else {
            $this->args[$arg] = $value;
        }
    }

    private function attachFile (string $file) : self
    {
        $extension = pathinfo($file)['extension'];

        $virtual_file = "/" .  $extension . "/" . $file;

        $realfile = $this->realpath . sp(). $virtual_file;

        if (!file_exists($realfile)) {
            err_msg("no file for $realfile");
        }

        $key = $extension === "css" ? "styles" : "scripts";

        $src = "'$virtual_file'";

        $link = $extension === "css" ? "<link rel='stylesheet' type='text/css' href=$src>" : "<script src=$src></script>";

        $this->templateArg($key, $link);

        return $this;
    }
}