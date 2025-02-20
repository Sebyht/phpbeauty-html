<?php

namespace Tests\Body;

use Beauty\Body\ListElement;
use Beauty\Body\Wrapper;
use PHPUnit\Framework\TestCase;

class ListElementTest extends TestCase
{
    public function testAll ()
    {
        $list = new ListElement(["test", "test 2"]);

        $list->linkfor(1, "/phpunit.com");

        $excpectedList1 = "<ol><li>test</li><li><a href='/phpunit.com'>test 2</a></li></ol>";

        $this->assertEquals($excpectedList1, strval($list));

        $list2 = new ListElement(["first" => "test", "second" => "nesting"]);

        $list2->nested("second", (new Wrapper())->content("nesting"));

        $this->assertEquals("<ul><li>test</li><li>nesting<div>nesting</div></li></ul>", strval($list2));
    }
}