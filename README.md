Minimalistic console text formatter
===================================

## Features
- Coloring text and background.
- Styling - underline, bold, italic, blink.
- Minimalistic syntax.

## Usage
```php
<?php
include_once 'src/Formatter.php';

use KSTools\Console\Formatter;

$formatter = new Formatter();

$text = "#black,bg-white:Hello #default,underlined,bold,bg-red:World#df:, "
    . "#bg-yellow:The#df: #italic,bg-blue:Colorful#df: #bg-magenta:One";

echo $formatter->format($text);
```

## Examples
```php
<?php
echo $formatter->format("#red:red") . PHP_EOL;
echo $formatter->format("#bg-red:background red") . PHP_EOL;
echo $formatter->format("#red,bg-yellow,underlined,bold:red background yellow underlined bold") . PHP_EOL;
echo $formatter->format("#bg-black,red:black bg red#df: default") . PHP_EOL;
echo $formatter->format("#bg-black,red:black bg red#df,black: black default background") . PHP_EOL;
```