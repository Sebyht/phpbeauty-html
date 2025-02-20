<?php

namespace Tests\Body;

use Beauty\Body\Field;
use PHPUnit\Framework\TestCase;

class FieldTest extends TestCase
{
    public function testAll ()
    {
        $name = "test";

        $field = new Field($name);

        $field
        ->withType("text")
        ->withValue("phpunit")
        ->withClass("test", "unit");

        $expectedField = "<input name='test' type='text' value='phpunit' class='test unit'/>";

        $this->assertEquals($expectedField, strval($field));

        $expectedFieldGroup = "<div class='phpunit'><label for='test'>test group</label><input name='test' type='text' value='phpunit' class='test unit' id='test'/></div>";

        $this->assertEquals($expectedFieldGroup, $field->group("test group", ["class" => "phpunit"]));
    }
}