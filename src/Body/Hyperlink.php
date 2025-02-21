<?php

namespace Beauty\Body;

use Beauty\Utils\Element;

final class Hyperlink extends Element
{
    public function __construct(string $path, public string $label)
    {
        $this->tag = "a";
        
        $this->ignoreClientAttribute("href");

        $this->attributes['normal']['href'] = $path;

        $this->withContent($label, true);
    }

    public function changeLabel (string $label)
    {
        $this->withContent($label, true);

        return $this;
    }
}