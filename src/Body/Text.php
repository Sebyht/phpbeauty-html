<?php

namespace Beauty\Body;

use Beauty\Utils\Element;

final class Text extends Element
{
    public function __construct(string $content)
    {
        $this->tag = "p";

        $this->withContent($content, true);
    }

    public function title (int $level = 1)
    {
        if ($level < 1 || $level > 6) {
            $level = 6;
        }

        $this->tag = "h" . $level;

        return $this;
    }

    public function sample (string $surround = "span")
    {
        $this->tag = $surround;

        return $this;
    }
}