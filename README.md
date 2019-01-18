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

$formatter->writeln($text);
```

## Examples
```php
<?php
$formatter->writeln("#red:red");
$formatter->writeln("#bg-red:background red");
$formatter->writeln("#red,bg-yellow,underlined,bold:red background yellow underlined bold");
$formatter->writeln("#bg-black,red:black bg red#df: default");
$formatter->writeln("#bg-black,red:black bg red#df,black: black default background");
```