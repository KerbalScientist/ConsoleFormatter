<?php

namespace KSTools\Console;

/**
 * Console Formatter.
 * Token usage:
 * #option[,option ...]:Text
 *
 * @example
 * #red:Red
 * #bg-red:Background Red
 * #red,bold,underlined:Red Bold Underlined
 *
 * Escaping:
 * Add another '#' before '#' symbol which causes unwanted formatting.
 * ##yellow: Don't want to format this.
 *
 * @package KSTools\Console
 */
class Formatter
{
    public $startToken = '#';
    public $escapeToken = '#';
    public $delimiter = ',';
    public $endToken = ':';

    protected $options = [
        // Color
        'gray' => 30,
        'black' => 30,
        'red' => 31,
        'green' => 32,
        'yellow' => 33,
        'blue' => 34,
        'magenta' => 35,
        'cyan' => 36,
        'white' => 37,
        'color-default' => 39,

        // Background
        'bg-gray' => 40,
        'bg-black' => 40,
        'bg-red' => 41,
        'bg-green' => 42,
        'bg-yellow' => 43,
        'bg-blue' => 44,
        'bg-magenta' => 45,
        'bg-cyan' => 46,
        'bg-white' => 47,
        'bg-default' => 49,

        // Style
        'df' => 0,
        'default' => 0,
        'bold' => 1,
        'faint' => 2,
        'normal' => 22,
        'italic' => 3,
        'notitalic' => 23,
        'underlined' => 4,
        'doubleunderlined' => 21,
        'notunderlined' => 24,
        'blink' => 5,
        'blinkfast' => 6,
        'noblink' => 25,
        'negative' => 7,
        'positive' => 27,
    ];

    const START_SEQUENCE = "\033[";
    const END_SEQUENCE = 'm';
    const RESET_SEQUENCE = "\033[0m";

    /**
     * Formats console output.
     * @example
     * ```
     * <?php
     *   $formatter = new KSTools\Console\Formatter();
     *   $text = "#black,bg-white:Hello #default,underlined,bold,bg-red:World#df:, "
     *     . "#bg-yellow:The#df: #italic,bg-blue:Colorful#df: #bg-magenta:One";
     *   echo $formatter->format($text) . PHP_EOL;
     * ?>
     * ```
     *
     * @param string $text Text with formatting tokens.
     * @return string
     */
    public function format($text)
    {
        $start = preg_quote($this->startToken, '~');
        $escape = preg_quote($this->escapeToken, '~');
        $delimiter = preg_quote($this->delimiter, '~');
        $end = preg_quote($this->endToken, '~');
        $pattern = "~$escape?$start(?'options'[\w$delimiter-]+)$end~";

        return preg_replace_callback($pattern, function ($matches) {
                $escaped = $this->detectEscaped($matches[0]);
                if ($escaped) {
                    return $escaped;
                }
                $codes = [];
                $options = explode($this->delimiter, $matches['options']);
                foreach ($options as $option) {
                    if (isset($this->options[$option])) {
                        $codes[] = $this->options[$option];
                    } else {
                        return $matches[0];
                    }
                }
                return self::START_SEQUENCE . implode(';', $codes) . self::END_SEQUENCE;
            }, $text) . self::RESET_SEQUENCE;
    }

    /**
     * Writes formetted output to console.
     * @see Formatter::format()
     * @param string $text
     */
    public function write($text)
    {
        echo $this->format($text);
    }

    /**
     * Writes formetted output to console with new line at the end.
     * @see Formatter::format()
     * @param string $text
     */
    public function writeln($text)
    {
        echo $this->format($text) . PHP_EOL;
    }

    protected function detectEscaped($match)
    {
        $escaped_start = substr($match, 0, strlen($this->startToken) + strlen($this->escapeToken));
        if ($escaped_start === $this->escapeToken . $this->startToken) {
            return substr($match, 0, strlen($this->escapeToken));
        }
        return null;
    }
}