# BitBar PHP Formatter

[![Latest Stable Version](https://poser.pugx.org/steveedson/bitbar-php/v/stable)](https://packagist.org/packages/steveedson/bitbar-php) [![Total Downloads](https://poser.pugx.org/steveedson/bitbar-php/downloads)](https://packagist.org/packages/steveedson/bitbar-php) [![Latest Unstable Version](https://poser.pugx.org/steveedson/bitbar-php/v/unstable)](https://packagist.org/packages/steveedson/bitbar-php) [![License](https://poser.pugx.org/steveedson/bitbar-php/license)](https://packagist.org/packages/steveedson/bitbar-php)

## Installing

Currently, BitBar reads any file in your directory a plugin, and tries to execute it. To workaround this, create a hidden folder, beginning with a dot, for example `.bitbar/`. In this directory create or edit your `composer.json` to include the library:


```json
{
  "require": {
    "steveedson/bitbar-php": "dev-master"
  }
}
```

or run `$ composer require "steveedson/bitbar-php"`

## Usage

In your BitBar plugins directory, create a file, e.g. `test.5m.php`. Don't forget to add the shebang at the beginning.

```php
#!/usr/bin/php

<?php

require ".bitbar/vendor/autoload.php";

use SteveEdson\BitBar;

// Create BitBar formatter
$bb = new BitBar();

// Create the first line
$line = $bb->newLine();

// Set the text and formatting
$line
    ->setText("Hello World")
    ->setColour("yellow")
    ->setUrl("https://steveedson.co.uk")
    ->show();
```

