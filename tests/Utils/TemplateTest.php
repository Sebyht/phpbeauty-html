<?php

namespace Tests\Utils;

use Beauty\Utils\Template;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class TemplateTest extends TestCase
{
    private Template $template;

    protected function setUp(): void
    {
        $this->template = new Template(dirname(__DIR__) . "/public");
    }

    public function testArgs ()
    {
        $template = $this->template
        ->styles("index")
        ->scripts("test");

        $args = (new ReflectionClass($template))->getProperty("args")->getValue($template);

        $this->assertEquals("<link rel='stylesheet' src='css/index.css' />", $args['styles']);

        $this->assertEquals("<script src='js/test.js'></script>", $args['scripts']);
    }

    public function testWrite ()
    {
        $content = "hello world";

        $title = "Unit test";

        $lang = "en";

        $this->template
        ->content($content)
        ->default("title", $title);


        $expected = buffer(dirname(__DIR__,2) . "\layouts\default.php", compact("content", "title", "lang"));

        $this->assertEquals($expected, $this->template->write());
    }
}