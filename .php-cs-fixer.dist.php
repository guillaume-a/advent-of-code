<?php

$finder = new PhpCsFixer\Finder()
    ->in(__DIR__ . '/src')
    ->exclude('vendor');

return new PhpCsFixer\Config()
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'no_unused_imports' => true,
        'declare_strict_types' => true,
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder);
