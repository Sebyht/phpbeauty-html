<?php

namespace Beauty\Utils;

interface ElementInterface
{
    public function withClass (string ...$class) : self;

    public function withID (string $id) : self;

    public function withLang (string $lang) : self;

    public function withData (string $name, string $value) : self;

    public function withAccessibility (string $name, string $value) : self;

    public function withBoolAttribute (string $attribute) : self;

    public function withEvent (string $name, string $value) : self;

    public function canEdit (string $dataType = "text") : self;

    public function unsecureContent () : self;
}