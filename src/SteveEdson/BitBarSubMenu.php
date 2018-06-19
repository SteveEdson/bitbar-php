<?php

namespace SteveEdson;

class BitBarSubMenu {
    public $depth = 1;

    /**
     * BitBarSubMenu constructor.
     * @param $depth
     */
    public function __construct($depth)
    {
        $this->depth = $depth;
    }

    public function newLine() {
        return new BitbarLine($this->depth);
    }
}