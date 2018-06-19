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

    public function testSubmenus() {
        $bb = new BitBar();

        $places = $bb->newLine()
            ->setText("Places");

        $placesData = ['London', 'Paris', 'Tokyo'];

        foreach($placesData as $place) {
            $places = $places->addSubMenu()
                ->newLine()
                ->setText($place);
        }

        $places->show();
    }

    public function testNestedSubmenus() {

        $data = [
            'Places' => [
                'London', 'Paris', 'Toyko',
            ],
            'Fruit' => [
                'Apple',
                'Orange',
                [
                    'title' => 'Melon',
                    'items' => [
                        'Watermelon',
                        'Honeydew'
                    ],
                ],
            ],
        ];

        $bb = new BitBar();

        foreach($data as $title => $items) {
            $line = $bb->newLine()
                ->setText($title);

            $subMenu = $line->addSubMenu();

            foreach($items as $item) {
                $title = is_array($item) ? $item['title'] : $item;

                $subMenuItem = $subMenu->newLine()
                ->setText($title);

                if(is_array($item)) {
                    $nestedSubMenu = $line->addSubMenu();

                    foreach($item['items'] as $subItem) {
                        $nestedSubMenu
                            ->newLine()
                            ->setText($subItem);
                        }
                }

                $subMenuItem->show();
            }
        }
    }
}