<?php

namespace Beauty\Body;

use Beauty\Utils\Element;

final class Form extends Element
{
    public function __construct(string $action,string $method, private array $data = [])
    {
        $this->tag = "form";

        $this->ignoreClientAttribute("action");

        $this->ignoreClientAttribute("method");

        $this->attributes['normal']['action'] = $action;

        $this->attributes['normal']['method'] = $method;
    }

    public function withField (Field $field) : self
    {
        $this->secure = false;

        if (array_key_exists($field->name, $this->data)) {
            $field->withValue($this->data[$field->name]);
        }

        $this->withContent(strval($field));

        return $this;
    }

    public function withBtn (string $label, string $type = "submit") : self
    {
        $this->secure = false;

        $btn = (new Wrapper("button"))
        ->withAttribute("type", $type)
        ->content($label);

        $this->withContent(strval($btn));

        return $this;
    }
}