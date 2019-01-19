<?php

namespace KSTools\Console\Tests;

use KSTools\Console\Formatter;
use PHPUnit\Framework\TestCase;

class FormatterTest extends TestCase
{

    public function formatProvider() {
        return [
            ['Some Text', 'Some Text', 'No changes in text with tokens'],
            ['#red:Text', "\033[31mText\033[0m", 'Red text'],
            ['#bg-red:Text', "\033[41mText\033[0m", 'Red background'],
            ['#red,bg-red:Text', "\033[31;41mText\033[0m", ''],
            ['#red,bg-red:Text#underlined:Text2', "\033[31;41mText\033[4mText2\033[0m", ''],
            ['##red,bg-red:Text', "#red,bg-red:Text", 'Escaped'],
            ['#red,#bg-red::Text', "#red,\e[41m:Text\e[0m", 'Nested'],
            ['#--not-existing:Text', "#--not-existing:Text", 'Non-existing option'],
        ];
    }

    public function testHasFormatMethod() {
        $formatter = new Formatter();
        $this->assertIsCallable([$formatter, 'format'], 'Formatter::format() is callable.');
        return $formatter;
    }

    /**
     * @dataProvider formatProvider
     * @depends  testHasFormatMethod
     */
    public function testFormat($input, $output, $message, Formatter $formatter)
    {
        $this->assertSame($output, $formatter->format($input), $message);
    }

    /**
     * @dataProvider formatProvider
     * @depends  testHasFormatMethod
     */
    public function testWrite($input, $output, $message, Formatter $formatter)
    {
        $this->expectOutputString($output);
        $formatter->write($input);
    }

    /**
     * @dataProvider formatProvider
     * @depends  testHasFormatMethod
     */
    public function testWriteln($input, $output, $message, Formatter $formatter)
    {
        $this->expectOutputString($output . PHP_EOL);
        $formatter->writeln($input);
    }
}
