<?php
/*
 * This document has been generated with
 * https://mlocati.github.io/php-cs-fixer-configurator/#version:2.19.3|configurator
 */
$config = new PhpCsFixer\Config();

return $config
    ->setRiskyAllowed(true)
    ->setUsingCache(false)
    ->setRules([
        '@PhpCsFixer:risky' => true,
        '@PhpCsFixer' => true,
        '@PSR12' => true,
        // Write conditions in Yoda style (`true`), non-Yoda style (`['equal' => false, 'identical' => false, 'less_and_greater' => false]`) or ignore those conditions (`null`) based on configuration.
        'yoda_style' => false,
        // Visibility MUST be declared on all properties and methods; `abstract` and `final` MUST be declared before the visibility; `static` MUST be declared after the visibility.
        'visibility_required' => ['elements' => ['method', 'property']],
        // Concatenation should be spaced according configuration.
        'concat_space' => ['spacing' => 'one'],
        // Sorts PHPDoc types.
        'phpdoc_types_order' => ['null_adjustment' => 'always_last'],
        // Single-line comments and multi-line comments with only one line of actual content should use the `//` syntax.
        'single_line_comment_style' => false,
        // Add leading `\` before function invocation to speed up resolving.
        'native_function_invocation' => false,
        // PHPDoc summary should end in either a full stop, exclamation mark, or question mark.
        'phpdoc_summary' => false,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->ignoreDotFiles(true)
            ->ignoreVCS(true)
            ->ignoreUnreadableDirs()
            ->in([
                __DIR__ . '/src',
                __DIR__ . '/tests',
            ])
            ->append([
                __DIR__ . '/.php-cs-fixer.dist.php',
            ])
    )
;
