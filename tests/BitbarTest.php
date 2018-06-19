<?php

use SteveEdson\BitBar;

class BitbarTest extends \PHPUnit_Framework_TestCase {

    public function testBasicTextFormatsCorrectly()
    {
        $bb = new BitBar();

        $bb->newLine()
            ->setText("Hello World")
            ->show();

        $this->expectOutputString("Hello World\n---\n");
    }
}