## Installing

Currently, BitBar thinks that any file in your plugins directory is a plugin, and tries to execute it. To workaround this, create a hidden folder, beginning with a dot, for example `.bitbar/`. In this directory create or edit your `composer.json` to include the library:


```json
{
  "require": {
    "steveedson/bitbar-php": "dev-master"
  }
}
```

or run `$ composer require "steveedson/bitbar-php"`

## Usage

```php
<?php

require "vendor/autoload.php";

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

