<?php

namespace SteveEdson;

class BitBar {
    public function newLine() {
        return new BitBarLine();
    }

    public function divide() {
        $_line = new BitBarLine();
        $_line->show();
    }
}