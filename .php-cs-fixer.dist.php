<?php
/*
 * This document has been generated with
 * https://mlocati.github.io/php-cs-fixer-configurator/#version:2.19.3|configurator
 * you can change this configuration by importing this file.
 *
 * Use this command to run the tool from inside the PHP container
 * php php-cs-fixer-2.19.3.phar fix --config=.php-cs-fixer.70.php --using-cache=yes --cache-file=.php-cs-fixer.70.php.cache
 */
$config = new PhpCsFixer\Config();
return $config
    ->setRiskyAllowed(true)
    ->setUsingCache(false)
    ->setRules([
        '@PHP74Migration' => true,
        '@PSR12' => true,
        '@Symfony' => true,
        // Converts backtick operators to `shell_exec` calls.
        'backtick_to_shell_exec' => false,
        // Concatenation should be spaced according configuration.
        'concat_space' => ['spacing'=>'one'],
        // Replaces short-echo `<?=` with long format `<?php echo`/`<?php print` syntax, or vice-versa.
        'echo_tag_syntax' => false,
        // Transforms imported FQCN parameters and return types in function arguments to short version.
        'fully_qualified_strict_types' => false,
        // Heredoc/nowdoc content must be properly indented. Requires PHP >= 7.3.
        'heredoc_indentation' => false,
        // Pre- or post-increment and decrement operators should be used if possible.
        'increment_style' => false,
        // Lambda must not import variables it doesn't use...
        'lambda_not_used_import' => false,
        // List (`array` destructuring) assignment should be declared using the configured syntax. Requires PHP >= 7.1.
        'list_syntax' => false,
        // Replaces `intval`, `floatval`, `doubleval`, `strval` and `boolval` function calls with according type casting operator.
        'modernize_types_casting' => true,
        // Remove leading slashes in `use` clauses...
        'no_leading_import_slash' => false,
        // Either language construct `print` or `echo` should be used.
        'no_mixed_echo_print' => false,
        // Removes `@param`, `@return` and `@var` tags that don't provide any useful information.
        'no_superfluous_phpdoc_tags' => false,
        // Removes unneeded parentheses around control statements...
        'no_unneeded_control_parentheses' => false,
        // Variables must be set `null` instead of using `(unset)` casting...
        'no_unset_cast' => false,
        // PHPUnit annotations should be a FQCNs including a root namespace.
        'php_unit_fqcn_annotation' => false,
        // Enforce camel (or snake) case for PHPUnit test methods, following configuration.
        'php_unit_method_casing' => false,
        // Converts `protected` variables and methods to `private` where possible.
        'protected_to_private' => false,
        // Increment and decrement operators should be used if possible...
        'standardize_increment' => false,
        // Use `null` coalescing operator `??` where possible. Requires PHP >= 7.0...
        'ternary_to_null_coalescing' => false,
        // All items of the given phpdoc tags must be either left-aligned or (by default) aligned vertically.
        'phpdoc_align' => ['align' => 'left'],
        // Operators - when multiline - must always be at the beginning or at the end of the line.
        'operator_linebreak' => true,
        // Write conditions in Yoda style (`true`), non-Yoda style (`['equal' => false, 'identical' => false, 'less_and_greater' => false]`) or ignore those conditions (`null`) based on configuration.
        'yoda_style' => false,
        // PHPDoc summary should end in either a full stop, exclamation mark, or question mark.
        'phpdoc_summary' => false,
        // Throwing exception must be done in single line.
        'single_line_throw' => false,
    ])
    ->setFinder(PhpCsFixer\Finder::create()
        ->ignoreDotFiles(true)
        ->ignoreVCS(true)
        ->ignoreUnreadableDirs()
        ->in([
            __DIR__ . '/src',
            __DIR__ . '/tests',
        ])
    );
