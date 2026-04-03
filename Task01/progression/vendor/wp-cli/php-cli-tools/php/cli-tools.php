<?php
/**
 * Minimal stub of wp-cli/php-cli-tools for environments without Composer.
 * In a real project, run `composer install` to get the real library.
 */
namespace cli;

function line(string $text = ''): void
{
    echo $text . PHP_EOL;
}

function prompt(string $question, $default = false, string $marker = ': '): string
{
    echo $question . $marker;
    $handle = fopen('php://stdin', 'r');
    $line   = fgets($handle);
    fclose($handle);
    return trim($line) ?: (string)$default;
}
