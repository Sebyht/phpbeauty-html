<?php

namespace Tests\Body;

use Beauty\Body\Btn;
use Beauty\Body\Field;
use Beauty\Body\Form;
use PHPUnit\Framework\TestCase;

class FormTest extends TestCase
{
    public function testAll ()
    {
        $form = new Form("/", "get", ["unit" => "php"]);

        $unit = new Field("unit");
        $desc = new Field("desc", "textarea");

        $form
        ->withField($unit)
        ->withField($desc)
        ->withBtn("check");

        $expected = "<form action='/' method='get'><input name='unit' value='php'/>" . strval($desc);

        $expected .= "<button type='submit'>check</button></form>";

        $this->assertEquals($expected, strval($form));
    }
}