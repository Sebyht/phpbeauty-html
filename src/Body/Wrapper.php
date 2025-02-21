<?php

namespace Beauty\Body;

use Beauty\Utils\Element;
use Beauty\Utils\ElementInterface;

final class Wrapper extends Element
{
    public function __construct(string $tag = "div")
    {
        $this->tag = $tag;
    }

    public function withChild (ElementInterface $child)
    {
        $this->secure = false;

        $this->withContent(strval($child));

        return $this;
    }

    public function withAttribute (string $name, string $value)
    {
        return $this->Addattribute($name, $value);
    }
    
    public function content (string $content, bool $reset = false, bool $svg = false)
    {
        $this->withContent($content, $reset);

        if ($svg && strpos($content, "<svg") === 0) {
            $this->unsecureContent();
        }

        return $this;
    }

    public function resetContent ()
    {
        $this->contents = [];

        return $this;
    }

    public function getContent ()
    {
        return implode("",$this->contents);
    }
}