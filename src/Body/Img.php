<?php

namespace Beauty\Body;

use Beauty\Utils\Element;

class Img extends Element
{
    public function __construct(string $src, string $alternativeText)
    {
        $this->forceAttribute("src", $src);

        $this->forceAttribute("alt", $alternativeText);

        $this->tag === "img";

        $this->autoCloseTag = true;
    }
}