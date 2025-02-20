<?php

namespace Tests\Utils;

use Beauty\Utils\Renderer;
use Beauty\Utils\View;
use PHPUnit\Framework\TestCase;

class RendererTest extends TestCase
{
    public function testRenderWithAllFeatures ()
    {
        $view = new Renderer;

        $view->addPath("test", dirname(__DIR__) . "/view");

        $view->addGlobal("name", "jhon");

        $this->assertEquals("<p>hello jhon doe</p>", $view->render("@test/test", ["nickname" => "doe"]));
    }
}