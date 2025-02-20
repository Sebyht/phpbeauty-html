<?php

namespace Beauty\Body;

use Beauty\Utils\Element;
use Beauty\Utils\ElementInterface;

class Field extends Element
{
    public function __construct(public string $name, string $tag = "input")
    {
        $this->tag = $tag;

        $this->autoCloseTag = $tag === "input";
        
        $this->ignoreClientAttribute("name");

        $this->attributes['normal']['name'] = $name;
    }

    public function withValue (string $value)
    {
        if ($this->tag === "textaraea") {
            $this->withContent($value, true);

            return $this;
        }
        return $this->Addattribute("value", $value);
    }
    
    public function withType (string $type)
    {
        return $this->Addattribute("type", $type);
    }

    public function group (string $label, array $groupAttributes = []) : string
    {
        $label = (new Wrapper("label"))
        ->content($label)
        ->withAttribute("for", $this->name);

        $this->forceAttribute("id", $this->name);

        $field = parent::__toString();

        $wrapper = (new Wrapper())
        ->withChild($label)
        ->content($field);

        foreach ($groupAttributes as $key => $value) {
            if (is_numeric($key)) {
                $wrapper->withBoolAttribute($value);
            } else {
                $wrapper->withAttribute($key, $value);
            }
        }

        return strval($wrapper);
    }
}